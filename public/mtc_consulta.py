"""
MTC - Consulta Registro Nacional de Transporte de Carga
=========================================================
Instalación:
    pip install requests beautifulsoup4
    # Si requests da 403 (servidores cloud), instala también:
    pip install playwright && playwright install chromium

Uso desde terminal:
    python mtc_consulta.py --placa APS828
    python mtc_consulta.py --ruc 20123456789

Como módulo:
    from mtc_consulta import consultar_placa
    datos = consultar_placa("APS828")

Como servidor REST local:
    python mtc_consulta.py --servidor
    → GET http://localhost:8000/placa/APS828
    → Docs en http://localhost:8000/docs
"""

import sys
import json
import argparse
import requests
from bs4 import BeautifulSoup

BASE_URL  = "https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_consultadgtt/"
FORM_URL  = BASE_URL + "Frm_rep_intra_mercancia.aspx"

HEADERS = {
    "User-Agent": (
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/124.0.0.0 Safari/537.36"
    ),
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "es-PE,es;q=0.9,en;q=0.7",
    "Referer": FORM_URL,
}

TIPO_RADIO = {
    "ruc":        "rbOpciones_0", # ID: rbOpciones_0
    "partida":    "rbOpciones_1", # Asumido por orden
    "placa":      "rbOpciones_2", # ID: rbOpciones_2
    "constancia": "rbOpciones_3", # Asumido por orden
}

# Selectores especificos por ID real en el HTML
SELECTORES = {
    "input": "txtValor",
    "boton": "btnBuscar",
}


# ─── MÉTODO 1: requests + BeautifulSoup ─────────────────────────────────────

def _get_viewstate(session):
    resp = session.get(FORM_URL, headers=HEADERS, timeout=20)
    resp.raise_for_status()
    soup = BeautifulSoup(resp.text, "html.parser")
    campos = {}
    for name in ("__VIEWSTATE", "__VIEWSTATEGENERATOR", "__EVENTVALIDATION",
                 "__EVENTTARGET", "__EVENTARGUMENT"):
        tag = soup.find("input", {"name": name})
        if tag:
            campos[name] = tag.get("value", "")
    return campos


def _consultar_requests(tipo, valor):
    session = requests.Session()
    viewstate = _get_viewstate(session)
    payload = {
        **viewstate,
        "rbOpciones": TIPO_RADIO[tipo], # El name es rbOpciones, el value es el ID
        SELECTORES["input"]: valor.strip().upper(),
        SELECTORES["boton"]: "Buscar",
    }
    resp = session.post(
        FORM_URL,
        data=payload,
        headers={**HEADERS, "Content-Type": "application/x-www-form-urlencoded"},
        timeout=30,
        allow_redirects=True,
    )
    resp.raise_for_status()
    return _parsear_html(resp.text, tipo, valor)


# ─── MÉTODO 2: Playwright (navegador real, evita bloqueos 403) ───────────────

def _consultar_playwright(tipo, valor):
    try:
        from playwright.sync_api import sync_playwright
    except ImportError:
        raise RuntimeError(
            "Playwright no instalado. Ejecuta:\n"
            "  pip install playwright\n"
            "  playwright install chromium"
        )

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page(
            user_agent=HEADERS["User-Agent"],
            extra_http_headers={"Accept-Language": "es-PE,es;q=0.9"},
        )
        page.goto(FORM_URL, wait_until="domcontentloaded", timeout=30000)

        radio_map = {
            "ruc":        "input[id*='rbOpciones_0']",
            "partida":    "input[id*='rbOpciones_1']",
            "placa":      "input[id*='rbOpciones_2']",
            "constancia": "input[id*='rbOpciones_3']",
        }
        
        # Click radio and wait for potential ASP.NET postback
        page.click(radio_map[tipo])
        page.wait_for_timeout(1000) 
        
        page.fill(f"input[id*='{SELECTORES['input']}']", valor.strip().upper())
        
        # Click y esperar navegacion o cambio de DOM
        page.click(f"input[id*='{SELECTORES['boton']}']")
        
        html_final = ""
        
        try:
            # Esperar a que aparezca la tabla de resultados
            page.wait_for_selector("a:has-text('Consultar'), #dgConsulta, .table", timeout=15000)
            
            # Siempre incluimos la pagina de resultados (resumen) como primer bloque
            html_final += page.content() + "\n<!-- SPLIT -->\n"
            
            # Obtener todos los enlaces de "Consultar" usando un selector mas flexible
            selector_link = "a:has-text('Consultar')"
            num_links = page.locator(selector_link).count()
            
            if num_links > 0:
                for i in range(num_links):
                    # Volver a la lista y hacer click en el i-esimo link
                    links = page.locator(selector_link)
                    if i < links.count():
                        links.nth(i).click()
                        page.wait_for_load_state("domcontentloaded")
                        page.wait_for_timeout(2500) # Espera suficiente para que cargue la tabla de vehiculos
                        html_final += page.content() + "\n<!-- SPLIT -->\n"
                        # Regresar a la lista de resultados
                        page.go_back()
                        page.wait_for_selector(selector_link, timeout=10000)
        except Exception as e:
            if not html_final: html_final = page.content()

        browser.close()

    return _parsear_html(html_final, tipo, valor)


# ─── PARSER COMÚN ────────────────────────────────────────────────────────────

def _parsear_html(html_raw, tipo, valor):
    # Soporta multiples bloques de HTML unidos por <!-- SPLIT -->
    bloques = html_raw.split("<!-- SPLIT -->")
    
    resultado = {
        "encontrado": True,
        "tipo_busqueda": tipo,
        "valor_buscado": valor,
        "datos": {},
        "vehiculos": [],
    }

    for html in bloques:
        if not html.strip(): continue
        soup = BeautifulSoup(html, "html.parser")
        texto = soup.get_text(" ", strip=True).lower()

        if "no se encontr" in texto or "sin resultado" in texto:
            continue

        for tabla in soup.find_all("table"):
            text_tabla = tabla.get_text(" ", strip=True)
            if len(text_tabla) < 10: continue

            # Buscar encabezados en TH o en la fila con estilo
            encabezados = [th.get_text(strip=True) for th in tabla.find_all("th")]
            if not encabezados:
                primera_fila = tabla.find("tr")
                if primera_fila:
                    encabezados = [td.get_text(strip=True) for td in primera_fila.find_all("td")]

            # Si parece una tabla de vehiculos/detalles (muchas columnas)
            if len(encabezados) >= 4:
                filas = tabla.find_all("tr")
                for fila in filas[1:]:
                    celdas = [td.get_text(strip=True) for td in fila.find_all("td")]
                    if len(celdas) >= len(encabezados) and any(celdas):
                        obj = dict(zip(encabezados, celdas[:len(encabezados)]))
                        # Evitar duplicados exactos y filas de paginacion
                        if obj not in resultado["vehiculos"] and "pag." not in str(obj).lower():
                            resultado["vehiculos"].append(obj)
            else:
                # Tabla de datos llave-valor
                for fila in tabla.find_all("tr"):
                    cols = fila.find_all(["td", "th"])
                    if len(cols) == 2:
                        etiqueta = cols[0].get_text(strip=True).rstrip(":").strip()
                        val = cols[1].get_text(strip=True)
                        if etiqueta and val and len(etiqueta) < 60:
                            resultado["datos"][etiqueta] = val

    # Si la busqueda fue por PLACA, filtramos la lista para mostrar solo esa placa
    if tipo == "placa":
        valor_limpio = valor.strip().upper()
        resultado["vehiculos"] = [
            v for v in resultado["vehiculos"] 
            if str(v.get("Placa", "")).strip().upper() == valor_limpio
        ]

    if not resultado["datos"] and not resultado["vehiculos"]:
        resultado["advertencia"] = "No se pudieron extraer datos detallados."

    return resultado


# ─── FUNCIÓN PRINCIPAL ────────────────────────────────────────────────────────

def consultar(tipo, valor):
    """
    Consulta el Registro Nacional de Transporte de Carga del MTC.
    Intenta primero con requests; si da 403, usa Playwright automáticamente.

    tipo  : 'placa' | 'ruc' | 'partida' | 'constancia'
    valor : el valor a buscar
    """
    tipo = tipo.lower()
    if tipo not in TIPO_RADIO:
        return {"error": f"Tipo invalido: '{tipo}'. Opciones: {list(TIPO_RADIO)}"}

    try:
        res = _consultar_requests(tipo, valor)
        # Si no hay datos ni vehiculos, es probable que requests no haya funcionado bien con el sitio ASP.NET
        if not res.get("datos") and not res.get("vehiculos") and res.get("encontrado"):
            try:
                return _consultar_playwright(tipo, valor)
            except Exception:
                return res # Retorna el original si playwright falla
        return res
    except requests.HTTPError as e:
        if e.response is not None and e.response.status_code == 403:
            try:
                return _consultar_playwright(tipo, valor)
            except RuntimeError as pe:
                return {"error": str(pe)}
        return {"error": str(e)}
    except requests.RequestException as e:
        return {"error": f"Error de conexion: {e}"}


def consultar_placa(placa):      return consultar("placa", placa)
def consultar_ruc(ruc):          return consultar("ruc", ruc)
def consultar_constancia(num):   return consultar("constancia", num)
def consultar_partida(partida):  return consultar("partida", partida)


# ─── Servidor FastAPI ─────────────────────────────────────────────────────────

def iniciar_servidor():
    try:
        from fastapi import FastAPI, Query
        from fastapi.middleware.cors import CORSMiddleware
        import uvicorn
    except ImportError:
        print("Instala: pip install fastapi uvicorn")
        sys.exit(1)

    app = FastAPI(
        title="MTC Consulta API",
        description="Registro Nacional de Transporte de Carga - MTC Peru",
        version="1.1.0",
    )
    app.add_middleware(CORSMiddleware, allow_origins=["*"],
                       allow_methods=["*"], allow_headers=["*"])

    @app.get("/placa/{placa}")
    def api_placa(placa: str): return consultar_placa(placa)

    @app.get("/ruc/{ruc}")
    def api_ruc(ruc: str): return consultar_ruc(ruc)

    @app.get("/constancia/{num}")
    def api_constancia(num: str): return consultar_constancia(num)

    @app.get("/partida/{partida}")
    def api_partida(partida: str): return consultar_partida(partida)

    @app.get("/consultar")
    def api_consultar(tipo: str = Query(...), valor: str = Query(...)):
        return consultar(tipo, valor)

    print("\n  MTC Consulta API ->  http://localhost:8000")
    print("  Documentacion   ->  http://localhost:8000/docs\n")
    uvicorn.run(app, host="0.0.0.0", port=8000)


# ─── CLI ──────────────────────────────────────────────────────────────────────

def main():
    parser = argparse.ArgumentParser(
        description="Consulta Registro Nacional de Transporte de Carga - MTC"
    )
    g = parser.add_mutually_exclusive_group()
    g.add_argument("--placa",      metavar="PLACA")
    g.add_argument("--ruc",        metavar="RUC")
    g.add_argument("--constancia", metavar="NUM")
    g.add_argument("--partida",    metavar="PARTIDA")
    g.add_argument("--servidor",   action="store_true", help="Iniciar servidor en :8000")
    args = parser.parse_args()

    if args.servidor:        iniciar_servidor()
    elif args.placa:         print(json.dumps(consultar_placa(args.placa),      ensure_ascii=False, indent=2))
    elif args.ruc:           print(json.dumps(consultar_ruc(args.ruc),          ensure_ascii=False, indent=2))
    elif args.constancia:    print(json.dumps(consultar_constancia(args.constancia), ensure_ascii=False, indent=2))
    elif args.partida:       print(json.dumps(consultar_partida(args.partida),  ensure_ascii=False, indent=2))
    else:                    parser.print_help()


if __name__ == "__main__":
    main()

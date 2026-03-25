<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Archivo;
use App\Modelos\FeDocumento;
use App\Modelos\CMPOrden;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\STDEmpresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Hashids;
use SplFileInfo;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteTraits;

class ModificarArchivoController extends Controller
{
    use GeneralesTraits;
    use ComprobanteTraits;

    /**
     * Sube o reemplaza un archivo PDF para un documento específico.
     */
    public function actionModificarArchivoPDF(Request $request, $idopcion, $linea, $idoc_prefijo, $idoc_encoded)
    {
        // Descifrar el ID usando tu función estándar
        $idoc = $this->funciones->decodificarmaestraprefijo($idoc_encoded, $idoc_prefijo);

        // Obtener el tipo de archivo y el archivo físico
        $tipo_archivo = $request->input('tipo_archivo');
        $file = $request->file('archivo_pdf');

        if (!$file || !$tipo_archivo) {
            return Redirect::back()->with('errorbd', 'Debe seleccionar un archivo y especificar el tipo.');
        }

        // Obtener datos del documento
        $fedocumento = FeDocumento::where('ID_DOCUMENTO', $idoc)
            ->where('COD_ESTADO', '<>', 'ETM0000000000006')
            ->first();

        // Intentar buscar en CMPOrden
        $ordencompra = CMPOrden::where('COD_ORDEN', '=', $idoc)->first();
        $cod_empr_proveedor = '';
        $ruc_proveedor = '';

        if ($ordencompra) {
            $cod_empr_proveedor = $ordencompra->COD_EMPR_CLIENTE;
        } else {
            // Si no está en CMPOrden, buscar en CMPDocumentoCtble
            $documento_ctble = CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE', '=', $idoc)->first();
            if ($documento_ctble) {
                // En DOCUMENTO_CTBLE, el proveedor suele ser COD_EMPR_EMISOR
                $cod_empr_proveedor = $documento_ctble->COD_EMPR_EMISOR;
                $ordencompra = $documento_ctble; // Reutilizar variable para el prefijo empresa
            }
        }

        if (!$ordencompra) {
            return Redirect::back()->with('errorbd', 'Error! No se encontró el registro del documento (' . $idoc . ').');
        }

        // Si tenemos el código del proveedor, buscar su RUC en STD.EMPRESA
        if ($cod_empr_proveedor != '') {
            $proveedor_empresa = STDEmpresa::where('COD_EMPR', $cod_empr_proveedor)->first();
            if ($proveedor_empresa) {
                $ruc_proveedor = $proveedor_empresa->NRO_DOCUMENTO;
            }
        }

        if ($ruc_proveedor == '') {
            return Redirect::back()->with('errorbd', 'No se pudo determinar el RUC del proveedor para el código: ' . $cod_empr_proveedor);
        }

        // Definir el item del documento
        $doc_item_final = ($fedocumento) ? $fedocumento->DOCUMENTO_ITEM : $linea;

        try {
            DB::beginTransaction();

            $contadorArchivos = Archivo::count();

            // Usar prefijo_empresa del Trait ComprobanteTraits
            $prefijocarperta = $this->prefijo_empresa($ordencompra->COD_EMPR);

            $rutafile = $this->pathFiles . '\\comprobantes\\' . $prefijocarperta . '\\' . $ruc_proveedor;

            $nombrefilecdr = $contadorArchivos . '-' . $file->getClientOriginalName();

            // Crear carpeta si no existe
            $this->versicarpetanoexiste($rutafile);

            $rutacompleta = $rutafile . '\\' . $nombrefilecdr;
            copy($file->getRealPath(), $rutacompleta);

            // Desactivar archivos anteriores del mismo tipo
            Archivo::where('ID_DOCUMENTO', $idoc)
                ->where('TIPO_ARCHIVO', $tipo_archivo)
                ->where('ACTIVO', 1)
                ->update([
                    'ACTIVO' => 0,
                    'FECHA_MOD' => $this->fechaactual,
                    'USUARIO_MOD' => Session::get('usuario')->id
                ]);

            // Crear el nuevo registro de archivo
            $newArchivo = new Archivo();
            $newArchivo->ID_DOCUMENTO = $idoc;
            $newArchivo->DOCUMENTO_ITEM = $doc_item_final;
            $newArchivo->TIPO_ARCHIVO = $tipo_archivo;
            $newArchivo->NOMBRE_ARCHIVO = $nombrefilecdr;

            $docAsoc = CMPDocAsociarCompra::where('COD_CATEGORIA_DOCUMENTO', $tipo_archivo)->first();
            $newArchivo->DESCRIPCION_ARCHIVO = $docAsoc ? $docAsoc->NOM_CATEGORIA_DOCUMENTO : 'ARCHIVO MODIFICADO';

            $newArchivo->URL_ARCHIVO = $rutacompleta;
            $newArchivo->SIZE = filesize($file);

            $info = new SplFileInfo($file->getClientOriginalName());
            $newArchivo->EXTENSION = $info->getExtension();

            $newArchivo->ACTIVO = 1;
            $newArchivo->FECHA_CREA = $this->fechaactual;
            $newArchivo->USUARIO_CREA = Session::get('usuario')->id;
            $newArchivo->save();

            DB::commit();
            return Redirect::back()->with('bienhecho', 'Archivo PDF actualizado con éxito.');

        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::back()->with('errorbd', 'Error al actualizar el archivo: ' . $ex->getMessage());
        }
    }
}

<?php

namespace App\Services;

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Illuminate\Support\Facades\Storage;

class SunatService
{
    private $see;
    private $empresa;

    public function __construct()
    {
        ini_set('default_socket_timeout', 15); // Evitar colgarse indefinidamente en consultas SOAP lentas o caídas (ej: Efact Beta)
        $empId = session('empresa_id') ?? (session('empresa') ? session('empresa')->id : null);
        if ($empId) {
            $this->empresa = \App\Models\Empresa::find($empId);
            if ($this->empresa) {
                session(['empresa' => $this->empresa]);
            }
        } else {
            $this->empresa = session('empresa');
        }
        $this->initSee();
    }

    private function initSee()
    {
        $this->see = new \App\Services\Greenter\CustomSee();

        // 1. Cargar el Certificado Digital
        $certPath = $this->empresa && $this->empresa->certificado ? storage_path('app/public/' . $this->empresa->certificado) : null;
        if ($certPath && file_exists($certPath)) {
            $this->see->setCertificate($this->cleanCertificatePem(file_get_contents($certPath)));
        } else {
            // Manejar error o usar un proxy de pruebas si lo desean, pero lo ideal es requerir el certificado.
        }

        // 2. Definir el proveedor y el entorno
        $proveedor = $this->empresa ? ($this->empresa->proveedor_fe ?? 'sunat') : 'sunat';
        $esProduccion = ($this->empresa && $this->empresa->sunat_entorno == 1);

        if ($proveedor === 'efact') {
            $entorno = $esProduccion ? 'https://ose.efact.pe/ol-ti-itcpe/billService' : 'https://ose-gw1.efact.pe/ol-ti-itcpe/billService';
        } else {
            $entorno = $esProduccion ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA;
        }

        $this->see->setService($entorno);

        // 3. Establecer las credenciales (RUC + Usuario, Clave)
        if ($this->empresa) {
            if ($proveedor === 'efact' && !empty($this->empresa->efact_usuario)) {
                // EFACT normalmente entrega el usuario completo (ej: el RUC solo). 
                // Pasamos string vacío en el primer parámetro para que Greenter no vuelva a concatenar el RUC.
                $this->see->setClaveSOL(
                    '', 
                    $this->empresa->efact_usuario,
                    $this->empresa->efact_password
                );
            } else if (!empty($this->empresa->sunat_usuario)) {
                // Credenciales SUNAT por defecto
                $this->see->setClaveSOL(
                    $this->empresa->ruc,
                    $this->empresa->sunat_usuario,
                    $this->empresa->sunat_password
                );
            }
        }
    }

    public function getCompany()
    {
        $company = new Company();
        $company->setRuc($this->empresa->ruc)
            ->setRazonSocial($this->empresa->nombre);

        // La dirección podría venir de la Sede "Principal" (Anexo 0000) o de la tabla empresa.
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDistrito('LIMA')
            ->setProvincia('LIMA')
            ->setDepartamento('LIMA')
            ->setUrbanizacion('-')
            ->setCodLocal('0000') // Anexo por defecto
            ->setDireccion('CALLE PRINCIPAL 123'); // ESTO DEBE VENIR DE LA SEDE DINÁMICAMENTE.

        $company->setAddress($address);

        return $company;
    }

    /**
     * Devuelve la instancia See configurada. Útil para que los Controladores 
     * inyecten y envíen directamente Facturas/Boletas/NC.
     */
    public function getSee()
    {
        return $this->see;
    }

    /**
     * Inicializa See específicamente para Guías de Remisión (SOAP endpoint).
     */
    public function getGuiaSee()
    {
        $see = new See();
        
        // 1. Determinar entorno
        $isProduccion = ($this->empresa && ($this->empresa->sunat_entorno_guia ?? $this->empresa->sunat_entorno) == 1);
        $entorno = $isProduccion ? SunatEndpoints::GUIA_PRODUCCION : SunatEndpoints::GUIA_BETA;
        $see->setService($entorno);

        // 2. Configurar Certificado
        if ($isProduccion) {
            $certPath = $this->empresa && $this->empresa->certificado ? storage_path('app/public/' . $this->empresa->certificado) : null;
            if ($certPath && file_exists($certPath)) {
                $see->setCertificate($this->cleanCertificatePem(file_get_contents($certPath)));
            }
        } else {
            // USAR CERTIFICADO DE PRUEBA DE GREENTER (Buscamos la ruta real en v5.x)
            $certDemo = base_path('vendor/greenter/xmldsig/tests/certificate.pem');
            if (file_exists($certDemo)) {
                $see->setCertificate(file_get_contents($certDemo));
            } else {
                // Si el certificado no existe, lanzamos una excepción controlada
                throw new \Exception("No se encontró el certificado de pruebas en: " . $certDemo);
            }
        }


        // 3. Configurar Credenciales Clave SOL
        if ($isProduccion) {
            if ($this->empresa && $this->empresa->sunat_usuario && $this->empresa->sunat_password) {
                $see->setClaveSOL(
                    $this->empresa->ruc,
                    $this->empresa->sunat_usuario,
                    $this->empresa->sunat_password
                );
            }
        } else {
            // CREDENCIALES DE PRUEBA SUNAT (MODDATOS)
            $see->setClaveSOL('20123456789', 'MODDATOS', 'MODDATOS');
        }

        return $see;
    }

    /**
     * Utilidad para guardar el XML firmado que devuelve Greenter en el Storage.
     * Ahora lo guarda comprimido en formato .ZIP por requerimiento del usuario.
     */
    private $modoTest = false;

    public function setModoTest($value)
    {
        $this->modoTest = $value;
    }

    /**
     * Utilidad para guardar el XML firmado que devuelve Greenter en el Storage.
     */
    public function guardarXml($filename, $xmlContent)
    {
        $ruc = $this->empresa ? $this->empresa->ruc : 'default';
        $zipName = $filename . '.zip';
        $path = 'sunat/' . $ruc . '/xml/' . $zipName;

        // Crear el ZIP en memoria/temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'sunat_xml_zip');
        $zip = new \ZipArchive();
        if ($zip->open($tempFile, \ZipArchive::CREATE) === TRUE) {
            $zip->addFromString($filename . '.xml', $xmlContent);
            $zip->close();

            // Guardar el contenido del ZIP en el Storage
            Storage::disk('public')->put($path, file_get_contents($tempFile));
            unlink($tempFile); // Eliminar temporal
        }

        return $path;
    }

    /**
     * Utilidad para guardar la respuesta de SUNAT (El CDR Zip) en el Storage.
     */
    public function guardarCdr($filename, $zipContent)
    {
        $ruc = $this->empresa ? $this->empresa->ruc : 'default';
        $path = 'sunat/' . $ruc . '/cdr/R-' . $filename . '.zip';
        Storage::disk('public')->put($path, $zipContent);
        return $path;
    }

    /**
     * Devuelve la instancia API REST configurada para Guías de Remisión (Sistema GRE 2.1).
     */
    public function getGuiaApi()
    {
        $isProduccion = ($this->empresa && ($this->empresa->sunat_entorno_guia ?? $this->empresa->sunat_entorno) == 1);
        $proveedorGuia = $this->empresa ? ($this->empresa->proveedor_guia ?? 'sunat') : 'sunat';
        
        if ($proveedorGuia === 'efact') {
            $see = new See();
            $entorno = $isProduccion ? 'https://ose.efact.pe/ol-ti-itcpe/billService' : 'https://ose-gw1.efact.pe/ol-ti-itcpe/billService';
            $see->setService($entorno);

            $certPath = $this->empresa && $this->empresa->certificado ? storage_path('app/public/' . $this->empresa->certificado) : null;
            if ($certPath && file_exists($certPath)) {
                $see->setCertificate($this->cleanCertificatePem(file_get_contents($certPath)));
            } else {
                if (!$isProduccion) {
                    $certDemo = base_path('vendor/greenter/xmldsig/tests/certificate.pem');
                    if (file_exists($certDemo)) {
                        $see->setCertificate(file_get_contents($certDemo));
                    }
                }
            }

            if ($this->empresa) {
                $see->setClaveSOL(
                    '', 
                    $this->empresa->efact_usuario,
                    $this->empresa->efact_password
                );
            }
            return $see;
        }
        
        if ($proveedorGuia === 'nubefact') {
            $endpoints = $isProduccion ? [
                'auth' => 'https://gre.nubefact.com/v1',
                'cpe' => 'https://gre.nubefact.com/v1',
            ] : [
                'auth' => 'https://gre-test.nubefact.com/v1',
                'cpe' => 'https://gre-test.nubefact.com/v1',
            ];
        } else {
            $endpoints = $isProduccion ? [
                'auth' => 'https://api-seguridad.sunat.gob.pe/v1',
                'cpe' => 'https://api-cpe.sunat.gob.pe/v1',
            ] : [
                'auth' => 'https://gre-test.nubefact.com/v1', // Fallback seguro por temas de DNS de gre-test de SUNAT
                'cpe' => 'https://gre-test.nubefact.com/v1',
            ];
        }


        $api = new \Greenter\Api($endpoints);

        // 1. Configurar Certificado Digital
        if ($isProduccion) {
            $certPath = $this->empresa && $this->empresa->certificado ? storage_path('app/public/' . $this->empresa->certificado) : null;
            if ($certPath && file_exists($certPath)) {
                $api->setCertificate($this->cleanCertificatePem(file_get_contents($certPath)));
            }
        } else {
            // USAR CERTIFICADO DE PRUEBA DE GREENTER (Buscamos la ruta real en v5.x)
            $certDemo = base_path('vendor/greenter/xmldsig/tests/certificate.pem');
            if (file_exists($certDemo)) {
                $api->setCertificate(file_get_contents($certDemo));
            }
        }

        // 2. Configurar Credenciales
        if ($isProduccion) {
            // Para el modo oficial, necesitamos client_id y client_secret de la tabla empresas
            $api->setApiCredentials($this->empresa->client_id, $this->empresa->client_secret);
            $api->setClaveSOL(
                $this->empresa->ruc,
                $this->empresa->sunat_usuario,
                $this->empresa->sunat_password
            );
        } else {
            // Credenciales de prueba oficiales de Nubefact Proxy (para Greenter 5)
            $api->setApiCredentials('test-85e5b0ae-255c-4891-a595-0b98c65c9854', 'test-Hty/M6QshYvPgItX2P0+Kw==');
            $api->setClaveSOL('20161515648', 'MODDATOS', 'MODDATOS');
        }

        return $api;
    }

    /**
     * Extrae el Hash del XML firmado (DigestValue) para mostrar en el PDF
     */
    public function getHash($xmlContent)
    {

        $doc = new \DOMDocument();
        $doc->loadXML($xmlContent);
        $hash = $doc->getElementsByTagName('DigestValue')->item(0);
        return $hash ? $hash->nodeValue : '';
    }

    private function cleanCertificatePem($pemContent)
    {
        // 1. Extraer la llave privada
        $privateKey = '';
        if (preg_match('/-----BEGIN [A-Z ]*PRIVATE KEY-----[\s\S]+?-----END [A-Z ]*PRIVATE KEY-----/', $pemContent, $matches)) {
            $privateKey = $matches[0];
        }

        // 2. Extraer el primer certificado únicamente (ignorar CA intermedias que confunden a SUNAT)
        $firstCert = '';
        if (preg_match('/-----BEGIN CERTIFICATE-----[\s\S]+?-----END CERTIFICATE-----/', $pemContent, $matches)) {
            $firstCert = $matches[0];
        }

        if (!empty($privateKey) && !empty($firstCert)) {
            return $firstCert . "\n" . $privateKey;
        }

        return $pemContent;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Modelos\Archivo;
use App\Modelos\FeDocumento;
use App\Modelos\CMPOrden;
use App\Modelos\LqgLiquidacionGasto;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\FePlanillaEntregable;

use Session;

use App\Traits\ComprobanteTraits;

class FileController extends Controller
{

    use ComprobanteTraits;

    public function serveFileContratoSG(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);

        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $rutafile               =       '\\\\10.1.0.201/cpe/Contratos/';
        $remoteFile             =       $rutafile.$newstr.'.pdf';
        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }


    public function serveFileModelo(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $rutafile               =       '\\\\10.1.50.2/comprobantes/modelo/';
        $remoteFile             =       $rutafile.$fileName;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }

    public function serveFileEstiba(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);

        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);
        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$archivo->ID_DOCUMENTO.'/';

        //dd($rutafile);

        $remoteFile             =       $rutafile.$newstr;
        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }

    public function serveFileContrato(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        $ordencompra            =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$archivo->ID_DOCUMENTO)->first();
        $prefijocarperta        =       $this->prefijo_empresa($ordencompra->COD_EMPR);


        //dd($prefijocarperta);

        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->RUC_PROVEEDOR.'/';

        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }


    public function serveFilePlaC(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);
        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->where('URL_ARCHIVO','like','%'.$prefijocarperta.'%')->first();
        $fedocumento            =       FePlanillaEntregable::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        //dd($archivo->ID_DOCUMENTO);

        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->ID_DOCUMENTO.'/';
        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }

    public function serveFileLG(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);
        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->where('URL_ARCHIVO','like','%'.$prefijocarperta.'%')->first();
        $fedocumento            =       LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        //dd($archivo->ID_DOCUMENTO);

        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->ID_DOCUMENTO.'/';
        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }


    public function serveFilePago(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();

        if($fedocumento->OPERACION == 'CONTRATO'){
            $ordencompra            =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$archivo->ID_DOCUMENTO)->first();
            $COD_EMPR = $ordencompra->COD_EMPR;

            $prefijocarperta        =       $this->prefijo_empresa($COD_EMPR);
            $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->RUC_PROVEEDOR.'/';

        }else{
            if($fedocumento->OPERACION == 'COMISION'){
                $COD_EMPR            =       Session::get('empresas')->COD_EMPR;
                $prefijocarperta        =       $this->prefijo_empresa($COD_EMPR);
                $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->ID_DOCUMENTO.'/';

            }else{
                $ordencompra            =       CMPOrden::where('COD_ORDEN','=',$archivo->ID_DOCUMENTO)->first();
                $COD_EMPR = $ordencompra->COD_EMPR;
                $prefijocarperta        =       $this->prefijo_empresa($COD_EMPR);
                $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->RUC_PROVEEDOR.'/';

            }
        }






        //dd($prefijocarperta);



        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);
        //dd($remoteFile);
        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }



    public function serveFile(Request $request)
    {
        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        $ordencompra            =       CMPOrden::where('COD_ORDEN','=',$archivo->ID_DOCUMENTO)->first();
        $prefijocarperta        =       $this->prefijo_empresa($ordencompra->COD_EMPR);

        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->RUC_PROVEEDOR.'/';

        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!file_exists($remoteFile)) {
            print_r($remoteFile);
            abort(404, 'Archivo no encontrado.');
        }

        // Crear una respuesta en streaming para servir el archivo
        return new StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0'
        ]);
    }
}

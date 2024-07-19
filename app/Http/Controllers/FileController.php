<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Modelos\Archivo;
use App\Modelos\FeDocumento;
use App\Modelos\CMPOrden;
use App\Modelos\CMPDocumentoCtble;


use App\Traits\ComprobanteTraits;

class FileController extends Controller
{

    use ComprobanteTraits;

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Modelos\Archivo;
use App\Modelos\FeDocumento;
use App\Modelos\CMPOrden;
use App\Modelos\LqgLiquidacionGasto;
use App\Modelos\ProRentaCuartaCategoria;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\FePlanillaEntregable;
use App\Modelos\VMergeOPActual;
use App\Modelos\Firma;
use App\Modelos\FeRefAsoc;




use Session;

use App\Traits\ComprobanteTraits;

class FileController extends Controller
{

    use ComprobanteTraits;

    public function serveFileContratoSG(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

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
        if (!$this->checkFileExists($remoteFile)) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

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
        if (!$this->checkFileExists($remoteFile)) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

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
        if (!$this->checkFileExists($remoteFile)) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();

        $remoteFile             =       '';
        if ($archivo && !empty($archivo->URL_ARCHIVO)) {
            $remoteFile = str_replace('\\', '/', $archivo->URL_ARCHIVO);
        }

        if (empty($remoteFile) || !$this->checkFileExists($remoteFile)) {
            $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
            $ordencompra            =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$archivo->ID_DOCUMENTO)->first();

            $prefijocarperta        =       '';
            if ($fedocumento && $fedocumento->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($fedocumento->COD_EMPR);
            } elseif ($ordencompra && $ordencompra->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($ordencompra->COD_EMPR);
            }

            $rucProveedor           =       $fedocumento ? $fedocumento->RUC_PROVEEDOR : '';
            $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$rucProveedor.'/';
            $remoteFile             =       str_replace('\\', '/', $rutafile.$newstr);
        }

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileNotaCredito(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();

        $remoteFile             =       '';
        if ($archivo && !empty($archivo->URL_ARCHIVO)) {
            $remoteFile = str_replace('\\', '/', $archivo->URL_ARCHIVO);
        }

        if (empty($remoteFile) || !$this->checkFileExists($remoteFile)) {
            $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
            $ordencompra            =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$archivo->ID_DOCUMENTO)->first();

            $prefijocarperta        =       '';
            if ($fedocumento && $fedocumento->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($fedocumento->COD_EMPR);
            } elseif ($ordencompra && $ordencompra->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($ordencompra->COD_EMPR);
            }

            $rucProveedor           =       $fedocumento ? $fedocumento->RUC_PROVEEDOR : '';
            $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$rucProveedor.'/';
            $remoteFile             =       str_replace('\\', '/', $rutafile.$newstr);
        }

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileNotaDebito(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();

        $remoteFile             =       '';
        if ($archivo && !empty($archivo->URL_ARCHIVO)) {
            $remoteFile = str_replace('\\', '/', $archivo->URL_ARCHIVO);
        }

        if (empty($remoteFile) || !$this->checkFileExists($remoteFile)) {
            $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
            $ordencompra            =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$archivo->ID_DOCUMENTO)->first();

            $prefijocarperta        =       '';
            if ($fedocumento && $fedocumento->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($fedocumento->COD_EMPR);
            } elseif ($ordencompra && $ordencompra->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($ordencompra->COD_EMPR);
            }

            $rucProveedor           =       $fedocumento ? $fedocumento->RUC_PROVEEDOR : '';
            $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$rucProveedor.'/';
            $remoteFile             =       str_replace('\\', '/', $rutafile.$newstr);
        }

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileLiquidacionCompraAnticipo(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        $op                     =       VMergeOPActual::where('COD_ESTADO','=','1')
                                            ->where('COD_AUTORIZACION','=',$fedocumento->ID_DOCUMENTO)
                                            ->first();
        $prefijocarperta        =       $this->prefijo_empresa($fedocumento->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$op->NRO_DOC.'/';
        //dd($rutafile);
        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileOrdenCompraAnticipo(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();


        $prefijocarperta        =       $this->prefijo_empresa($fedocumento->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$archivo->ID_DOCUMENTO.'/';

        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

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
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileFirma(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);

        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =       Firma::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        $rutafile               =       '\\\\10.1.50.2/comprobantes/FIRMA/';
        $remoteFile             =       $rutafile.$newstr;

        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);
                //dd($remoteFile);
        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
            abort(404, 'Imagen no encontrada.');
        }


        // Detectar el tipo MIME automáticamente (jpg, png, etc.)
        $mimeType = mime_content_type($remoteFile);

        // Crear una respuesta en streaming para servir la imagen
        return new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($remoteFile) {
            $fileHandle = fopen($remoteFile, 'rb');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 8192);
                ob_flush();
                flush();
            }
            fclose($fileHandle);
        }, 200, [
            'Content-Type' => $mimeType, // ejemplo: image/jpeg o image/png
            'Content-Disposition' => 'inline; filename="' . basename($remoteFile) . '"',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }


    public function serveFileLG(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

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
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileRC(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);
        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        //dd($archivo);

        $fedocumento            =       ProRentaCuartaCategoria::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        //dd($archivo->ID_DOCUMENTO);

        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/RENTACUARTA/';
        $remoteFile             =       $rutafile.$newstr;

        //dd($remoteFile);
        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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

    public function serveFileAC(Request $request)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);
        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();
        //dd($archivo);

        $fedocumento            =       ProRentaCuartaCategoria::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
        //dd($archivo->ID_DOCUMENTO);

        $prefijocarperta        =       $this->prefijo_empresa(Session::get('empresas')->COD_EMPR);
        $rutafile               =       '\\\\10.1.50.2/comprobantes/CONTRATOACOPIO/';
        $remoteFile             =       $rutafile.$newstr;

        //dd($remoteFile);
        // Reemplazar las barras invertidas por barras normales
        $remoteFile = str_replace('\\', '/', $remoteFile);

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();

        $remoteFile             =       '';
        if ($archivo && !empty($archivo->URL_ARCHIVO)) {
            $remoteFile = str_replace('\\', '/', $archivo->URL_ARCHIVO);
        }

        if (empty($remoteFile) || !$this->checkFileExists($remoteFile)) {
            $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();

            if($fedocumento && $fedocumento->OPERACION == 'CONTRATO'){
                $ordencompra            =       CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$archivo->ID_DOCUMENTO)->first();
                $COD_EMPR = $ordencompra ? $ordencompra->COD_EMPR : '';

                $prefijocarperta        =       $this->prefijo_empresa($COD_EMPR);
                $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->RUC_PROVEEDOR.'/';

            }else{
                if($fedocumento && $fedocumento->OPERACION == 'COMISION'){
                    $COD_EMPR            =       Session::get('empresas')->COD_EMPR;
                    $prefijocarperta        =       $this->prefijo_empresa($COD_EMPR);
                    $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$fedocumento->ID_DOCUMENTO.'/';

                }else{
                    $ordencompra            =       CMPOrden::where('COD_ORDEN','=',$archivo->ID_DOCUMENTO)->first();
                    $COD_EMPR = $ordencompra ? $ordencompra->COD_EMPR : ($fedocumento ? $fedocumento->COD_EMPR : '');
                    $prefijocarperta        =       $this->prefijo_empresa($COD_EMPR);
                    $rucProveedor           =       $fedocumento ? $fedocumento->RUC_PROVEEDOR : '';
                    $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$rucProveedor.'/';

                }
            }

            $remoteFile             =       $rutafile.$newstr;

            // Reemplazar las barras invertidas por barras normales
            $remoteFile = str_replace('\\', '/', $remoteFile);
        }

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session()->save();

        // Validar la entrada
        $this->validate($request, [
            'file' => 'required|string'
        ]);


        // Ruta de red del archivo
        $fileName = $request->query('file');
        $newstr = str_replace('"', '', $fileName);

        $archivo                =       Archivo::where('NOMBRE_ARCHIVO','=',$newstr)->first();

        $remoteFile             =       '';
        if ($archivo && !empty($archivo->URL_ARCHIVO)) {
            $remoteFile = str_replace('\\', '/', $archivo->URL_ARCHIVO);
        }

        if (empty($remoteFile) || !$this->checkFileExists($remoteFile)) {
            $fedocumento            =       FeDocumento::where('ID_DOCUMENTO','=',$archivo->ID_DOCUMENTO)->first();
            $ordencompra            =       CMPOrden::where('COD_ORDEN','=',$archivo->ID_DOCUMENTO)->first();

            $prefijocarperta        =       '';
            if ($fedocumento && $fedocumento->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($fedocumento->COD_EMPR);
            } elseif ($ordencompra && $ordencompra->COD_EMPR) {
                $prefijocarperta    =       $this->prefijo_empresa($ordencompra->COD_EMPR);
            }

            $rucProveedor           =       $fedocumento ? $fedocumento->RUC_PROVEEDOR : '';
            $rutafile               =       '\\\\10.1.50.2/comprobantes/'.$prefijocarperta.'/'.$rucProveedor.'/';
            $remoteFile             =       str_replace('\\', '/', $rutafile.$newstr);
        }

        // Verificar si el archivo existe
        if (!$this->checkFileExists($remoteFile)) {
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

    private function checkFileExists($remoteFile)
    {
        // Normalize path separators to forward slashes for parsing
        $normalized = str_replace('\\', '/', $remoteFile);
        
        // If it's a UNC network path (starts with //)
        if (strpos($normalized, '//') === 0) {
            // 1. Extract host and run a fast TCP check if in local environment
            if (preg_match('/^\/\/([^\/]+)/', $normalized, $matches)) {
                $host = $matches[1];
                if (config('app.env') === 'local') {
                    $connection = @fsockopen($host, 445, $errno, $errstr, 0.1);
                    if (!$connection) {
                        return false; // Host offline, fail fast!
                    }
                    fclose($connection);
                }
            }
            
            // 2. Extract share root (e.g. //10.1.50.2/comprobantes)
            if (preg_match('/^\/\/[^\/]+\/[^\/]+/', $normalized, $matches)) {
                $shareRoot = $matches[0];
                $cacheKey = 'unc_accessible_' . md5($shareRoot);
                
                if (\cache()->get($cacheKey) === 'no') {
                    return false; // Share is inaccessible, fail fast!
                }
                
                $start = microtime(true);
                $exists = file_exists($remoteFile);
                $elapsed = microtime(true) - $start;
                
                // If it took too long or doesn't exist, cache it as inaccessible
                if ($elapsed > 0.2 || !$exists) {
                    \cache()->put($cacheKey, 'no', 600); // cache for 10 minutes
                }
                
                return $exists;
            }
        }
        
        return file_exists($remoteFile);
    }
}

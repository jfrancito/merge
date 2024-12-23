<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modelos\SuperPrecio;
use PDO;

class DocumentoApiController extends Controller {

    public function actionBuscarPrecio() {

        $dni = '';
        header('Content-Type: application/json; charset=utf-8');
        $lista              = SuperPrecio::get()->toArray();
        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );
        $arraydata    =     $lista;
        return response()->json($arraydata, 
                $responsecode, $header, JSON_UNESCAPED_UNICODE);

    }

}

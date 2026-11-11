<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\User;

class Authaw {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {



        if(!Session::has('empresas')){
            if(!Session::has('usuario')){
                return Redirect()->to('/login');
            }else{
                return Redirect()->to('/acceso');
            }
        }else{
            if(Session::has('usuario')){

                /********* nuevo **********/
                $usuario                    =   User::where('id','=',Session::get('usuario')->id)
                                                ->where('activo','=',1)->first();                             
                if(count($usuario)<=0){

                    Session::forget('usuario');
                    Session::forget('listamenu');
                    Session::forget('empresas');
                    Session::forget('listaopciones');
                    Session::forget('color');
                    return Redirect()->to('/login');
                }  
                /**************************/

                return $next($request);


            }else{
                return Redirect()->to('/login');
            }

        }



        // if (Session::has('usuario')) {

        //     return $next($request);

        // } else {

        //     return Redirect()->to('/login');

        // }

    }
}

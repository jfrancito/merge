<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/resultado-api-precios', 'DocumentoApiController@actionBuscarPrecio');


Route::post('/api-openai-lectura-guias', 'DocumentoApiController@actionOpenAILecturaGuias');
Route::post('/api-regex-guias', 'DocumentoApiController@actionRegexGuias');

Route::get('/api-deepseek-lectura-guias', 'DocumentoApiController@actionDeepseekLecturaGuias');
Route::get('/api-paddleocr-deepseek-guias', 'DocumentoApiController@actionDeepseekPaddleocrGuias');
Route::get('/api-paddleocr-huggingface-guias', 'DocumentoApiController@actionDeepseekHuggingfaceGuias');




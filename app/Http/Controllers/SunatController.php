<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\FeToken;

use View;
use Session;
use Hashids;
use App\Traits\SunatTraits;


class SunatController extends Controller
{
    use SunatTraits;
	public function actionComprasSunat(Request $request)
	{
		$this->sut_traer_data_sunat('IACHEM0000010394');
		//$this->sut_traer_data_sunat('IACHEM0000007086');

	}	

}

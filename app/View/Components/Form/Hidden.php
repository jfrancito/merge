<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hidden extends Component
{

	public $name;
	public $value;

	public function __construct($name, $value=null)
	{
		$this->name  = $name;
		$this->value = $value;
	}

	public function render(): View|Closure|string
	{
		return view('components.form.hidden');
	}
}

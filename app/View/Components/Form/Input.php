<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
	public $col;
	public $label;
	public $name;
	public $type;
	public $icon;
	public $value;
	public $placeholder;
	public $disabled;
	public $required;

	public function __construct($label, $name, $type="text", $icon=null, $value=null, $placeholder=null,$col="6",$disabled="",$required="")
	{
		$this->label = $label;
		$this->name  = $name;
		$this->type  = $type;
		$this->icon  = $icon;
		$this->value = $value;
		$this->placeholder = $placeholder;
		$this->col = $col;
		$this->disabled=$disabled;
		$this->required=$required;
	}

	public function render(): View|Closure|string
	{
		return view('components.form.input');
	}
	
}

<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Nombre extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;

    public function __construct(
     $label = 'Nombre',
     $name = 'nombre',
     $value = '',
     $placeholder = ''
    ) {
     $this->label = $label;
     $this->name = $name;
     $this->value = $value;
     $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
     return view('components.form.nombre');
    }
}

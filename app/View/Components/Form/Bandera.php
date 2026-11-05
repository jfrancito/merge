<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bandera extends Component
{
     // public $col;
    public $label;
    public $id;
    public $name;
    public $value;
    public $disabled;
    public $required;
    
    public function __construct($name, $value = 0, $label = null, $id = null,$disabled='',$required='')
    {
        $this->name  = $name;
        $this->value = $value;
        $this->label = $label;
        $this->disabled=$disabled;
        $this->required=$required;
        $this->id    = $id ?? 'bandera_' . uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.bandera');
    }
}

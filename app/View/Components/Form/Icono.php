<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icono extends Component
{
    public $col;
    public $label;
    public $name;
    public $value;
    public $disabled;
    
    public function __construct($label, $name, $value='',$col="6",$disabled="")
    {
        $this->label = $label;
        $this->name  = $name;
        $this->value = $value;
        $this->col = $col;
        $this->disabled=$disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.icono');
    }
}

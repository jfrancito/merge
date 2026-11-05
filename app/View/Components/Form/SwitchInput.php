<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SwitchInput extends Component
{
    public $label;
    public $name;
    public $value;
    public $checked;
    public $disabled;
    public $col;
    public $required;

    public function __construct(
        $label,
        $name,
        $value = 1,
        $checked = false,
        $disabled = false,
        $col = 3,
        $required=''
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->disabled = $disabled;
        $this->col = $col;
        $this->required=$required;
    }

    public function render()
    {
        return view('components.form.switch-input');
    }
}


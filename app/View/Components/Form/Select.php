<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $name;
    public $options;
    public $value;
    public $icon;
    public $col;
    public $required;
    public $id;

    public function __construct(
        $label, 
        $name, 
        $options = [], 
        $value = null, 
        $icon = null,
        $col = 6,
        $required='',
        $id ='idselect'
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->value = $value;
        $this->icon = $icon;
        $this->col = $col;
        $this->required = $required;
        $this->id=$id;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.select');
    }
}

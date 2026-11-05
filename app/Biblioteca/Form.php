<?php

namespace App\Biblioteca;

class Form
{
    /**
     * Crea un elemento select HTML compatible con Form::select de Laravel Collective.
     *
     * @param string $name Nombre del campo y del select
     * @param array|\Traversable $list Lista de opciones [valor => texto]
     * @param mixed $selected Valor o valores seleccionados
     * @param array $options Atributos HTML adicionales para el tag select
     * @return \Illuminate\Support\HtmlString
     */
    public static function select($name, $list = [], $selected = null, array $options = [])
    {
        $attributes = '';
        if (!isset($options['name'])) {
            $options['name'] = $name;
        }
        if (!isset($options['id'])) {
            $options['id'] = str_replace(['[', ']'], ['_', ''], $name);
        }

        foreach ($options as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $attributes .= ' ' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                }
            } else {
                $attributes .= ' ' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }

        $html = '<select' . $attributes . '>';

        $selectedValues = is_array($selected) ? $selected : [$selected];
        // Convert to string for consistent comparison
        $selectedValues = array_map(function ($val) {
            return $val !== null ? (string)$val : '';
        }, $selectedValues);

        if ($list) {
            foreach ($list as $value => $display) {
                if (is_array($display)) {
                    $html .= '<optgroup label="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '">';
                    foreach ($display as $optVal => $optDisplay) {
                        $isSelected = in_array((string)$optVal, $selectedValues, true) ? ' selected="selected"' : '';
                        $html .= '<option value="' . htmlspecialchars((string)$optVal, ENT_QUOTES, 'UTF-8') . '"' . $isSelected . '>' . htmlspecialchars((string)$optDisplay, ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    $html .= '</optgroup>';
                } else {
                    $isSelected = in_array((string)$value, $selectedValues, true) ? ' selected="selected"' : '';
                    $html .= '<option value="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '"' . $isSelected . '>' . htmlspecialchars((string)$display, ENT_QUOTES, 'UTF-8') . '</option>';
                }
            }
        }

        $html .= '</select>';

        return new \Illuminate\Support\HtmlString($html);
    }
}


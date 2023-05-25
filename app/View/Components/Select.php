<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public string $type;
    public string $class;
    public string $name;
    public string $value;
    public string $label;
    public string $holder;

    public function __construct(
        string $type = 'text',
        string $class = '',
        string $name = '',
        string $value = '',
        string $label = '',
        string $holder = ''
    ) {
        $this->type = $type;
        $this->class = $class;
        $this->name = $name;
        $this->value = $value;
        $this->label = $label ? : ucfirst($name);
        $this->holder = $holder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}

<?php

namespace App\View\Components\Articles;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
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

    public function render(): View
    {
        return view('components.articles.input');
    }
}

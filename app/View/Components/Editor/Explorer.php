<?php

namespace App\View\Components\Editor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Explorer extends Component
{
    public $structure;

    public $isRoot;

    public $currentPath;

    /**
     * Create a new component instance.
     */
    public function __construct($structure, $isRoot = true, $currentPath = '')
    {
        $this->structure = $structure;
        $this->isRoot = $isRoot;
        $this->currentPath = $currentPath;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.editor.explorer');
    }
}

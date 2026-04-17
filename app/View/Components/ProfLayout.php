<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProfLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.prof', [
            'nav' => [
                ['label' => 'dashboard', 'url' => '/prof/dashboard'],
                ['label' => 'exam', 'url' => '/prof/exam']
            ]
        ]);
    }
}

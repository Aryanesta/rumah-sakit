<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AngsmartLayout extends Component
{
    public function __construct(
        public ?string $breadcrumb = null,
    ) {}

    public function render(): View
    {
        return view('layouts.angsmart');
    }
}

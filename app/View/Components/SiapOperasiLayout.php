<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SiapOperasiLayout extends Component
{
    public function __construct(
        public ?string $breadcrumb = null,
    ) {}

    public function render(): View
    {
        return view('layouts.siap-operasi');
    }
}

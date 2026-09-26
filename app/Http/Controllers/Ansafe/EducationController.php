<?php

namespace App\Http\Controllers\Ansafe;

use App\Http\Controllers\Controller;
use App\Support\Ansafe\AnsafeDemoData;
use Illuminate\View\View;

final class EducationController extends Controller
{
    public function __invoke(): View
    {
        return view('apps.ansafe.education.index', [
            'videos' => AnsafeDemoData::educationVideos(),
            'watched' => AnsafeDemoData::watchedVideos(),
        ]);
    }
}

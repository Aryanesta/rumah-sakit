<?php

namespace App\Http\Controllers;

use App\Support\ApplicationLauncher;
use App\Support\TimeGreeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class AppLauncherController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'applications' => ApplicationLauncher::applications(),
            'greeting' => TimeGreeting::forUser(Auth::user()),
        ]);
    }
}

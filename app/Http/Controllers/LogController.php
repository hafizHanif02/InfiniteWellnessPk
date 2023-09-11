<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('logs.index', [
            'logs' => Log::with('actionByUser')->filter($request)->latest()->paginate(10)->onEachSide(1),
        ]);
    }
}

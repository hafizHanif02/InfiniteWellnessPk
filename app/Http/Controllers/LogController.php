<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogController extends Controller
{
    public function __invoke(Request $request): View
    {
        if (isset($request->search_data)) {
            return view('logs.index', [
                'logs' => Log::where('action', 'like', '%' . $request->search_data . '%')->with('actionByUser')->filter($request)->latest()->get(),
                'search_data' => $request->search_data
            ]);
        }else{
            return view('logs.index', [
                'logs' => Log::with('actionByUser')->filter($request)->latest()->paginate(10)->onEachSide(1),
                'search_data' => ''
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Chapter3;

use App\Ai\Agents\PageAnalyzer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebFetchController extends Controller {
    public function pageAnalyzer(Request $request) {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000']
        ]);
        $agent = PageAnalyzer::make();
        $res = $agent->prompt($validated['message']);
        return response()->json([
            'answer' => (string) $res,
        ]);
    }
}

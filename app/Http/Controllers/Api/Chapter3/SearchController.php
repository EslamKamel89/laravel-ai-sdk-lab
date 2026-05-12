<?php

namespace App\Http\Controllers\Api\Chapter3;

use App\Ai\Agents\WebResearcher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller {
    public function search(Request $request) {
        $validated = $request->validate([
            'query' => ['required', 'string', 'max:1000']
        ]);
        $query = $validated['query'];
        $agent = WebResearcher::make();
        $res = $agent->prompt($query);
        return response()->json([
            'answer' => (string)$res,
        ]);
    }
}

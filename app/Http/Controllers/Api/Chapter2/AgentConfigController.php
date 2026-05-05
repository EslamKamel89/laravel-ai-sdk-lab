<?php

namespace App\Http\Controllers\Api\Chapter2;

use App\Ai\Agents\CreativeWriter;
use App\Ai\Agents\PreciseExtractor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentConfigController extends Controller {
    public function creativeWriter(Request $request) {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'genre' => ['nullable', 'string', 'max:50']
        ]);
        $agent = CreativeWriter::make();
        $genre = $request->input('genre', 'general');
        $prompt = "Genre: {$genre}\n\n{$request->input('message')}";
        $response = $agent->prompt($prompt);
        return response()->json([
            'genre' => $genre,
            'raw_response' => $response,
            'response' => (string)$response,
        ]);
    }
    public function extractContent(Request $request) {
        $request->validate([
            'message' => ['required', 'string', 'max:1000']
        ]);
        $message = $request->input('message');
        $agent = PreciseExtractor::make();
        $res = $agent->prompt($message);
        return response()->json([
            'raw_response' => $res,
            'response' => (string)$res,
        ]);
    }
}

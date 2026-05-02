<?php

namespace App\Http\Controllers\Api\Chapter2;

use App\Ai\Agents\SentimentAnalyzer;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\JsonSchema\JsonSchema;

use function Laravel\Ai\agent;

class StructuredOutputController extends Controller {
    public function analyzeSentiment(Request $request): JsonResponse {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:2000']
        ]);
        $text = $validated['text'];
        $agent = SentimentAnalyzer::make();
        $response = $agent->prompt($text);
        return response()->json([
            'user_message' => $text,
            'response_raw' => $response,
            'response_str' => (string) $response,
            // 'response_json'=> $response->schema
        ]);
    }
    public function simpleAnonymousSentimentAnalyzer(Request $request): JsonResponse {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:2000']
        ]);
        $text = $validated['text'];
        $instructions = <<<'PROMPT'
Sentiment analysis:

Return:
- sentiment: positive|negative|neutral
- score: 1–10
- topics: 1–5 keywords
- summary: one sentence

Rules: use only text; unclear→neutral (4–6); strong→extremes; be consistent.
PROMPT;
        $get_schema = fn(JsonSchema $schema) => [
            'sentiment' => $schema
                ->string()
                ->enum(['negative', 'neutral', 'positive'])
                ->description('Overall sentiment')
                ->required(),

            'score' => $schema
                ->integer()
                ->min(1)
                ->max(10)
                ->description('1=very negative, 10=very positive')
                ->required(),

            'topics' => $schema
                ->array()
                ->items($schema->string())
                ->description('1–5 concise keywords or phrases')
                ->required(),

            'summary' => $schema
                ->string()
                ->description('One concise sentence summarizing the sentiment')
                ->required(),
        ];
        $agent = agent(instructions: $instructions, schema: $get_schema);
        $response = $agent->prompt($text);
        return response()->json($response);
    }
}

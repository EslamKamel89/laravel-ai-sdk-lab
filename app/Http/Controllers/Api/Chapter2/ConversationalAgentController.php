<?php

namespace App\Http\Controllers\Api\Chapter2;

use App\Ai\Agents\CourseAssistant;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationalAgentController extends Controller {
    public function startConversation(Request $request): JsonResponse {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000']
        ]);
        $user = auth()->user();
        $message = $validated['message'];
        $agent = CourseAssistant::make()->forUser($user);
        $response = $agent->prompt($message);
        return response()->json([
            'user_message' => $message,
            'conversation_id' => $response->conversationId,
            'response_raw' => $response,
            'response_str' => (string) $response,
            'hint' => 'Save the conversation_id'
        ]);
    }
    public function continueConversation(Request $request): JsonResponse {
        $validated = $request->validate([
            'conversation_id' => ['required', 'string'],
            'message' => ['required', 'string', 'max:1000'],
        ]);
        [$conversationId, $message] = [$validated['conversation_id'], $validated['message']];
        $user = auth()->user();
        $agent = CourseAssistant::make()->continue($conversationId, $user);
        $response = $agent->prompt($message);
        return response()->json([
            'user_message' => $message,
            'conversation_id' => $response->conversationId,
            'response_json' => $response,
            'response_str' => (string) $response,
            'hint' => 'Save the conversation_id',
        ]);
    }
}

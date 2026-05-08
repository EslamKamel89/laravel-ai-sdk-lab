<?php

namespace App\Http\Controllers\Api\Chapter3;

use App\Ai\Agents\TimeAwareAssistant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Laravel\Ai\{agent};

class ToolUsageController extends Controller {

    public function getRequestedTime(Request $request) {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000']
        ]);
        $message = $validated['message'];
        $timeAwareAgent = TimeAwareAssistant::make();
        $timeAwareRes = $timeAwareAgent->prompt($message);
        $normalAgent = agent('You are a helpful assistant.');
        $normalRes =  $normalAgent->prompt($message);
        return response()->json([
            'time_aware_agent_response' => [
                // 'raw_response' => $timeAwareRes,
                'response' => (string)$timeAwareRes,
            ],
            'normal_agent_response' => [
                // 'raw_response' => $normalRes,
                'response' => (string)$normalRes,
            ],
        ]);
    }
}

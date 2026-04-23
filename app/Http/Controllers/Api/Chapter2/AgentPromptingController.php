<?php

namespace App\Http\Controllers\Api\Chapter2;

use App\Ai\Agents\HelloWorldAgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentPromptingController extends Controller {
    public function helloWorld(Request $request) {
        /* this is response example when this method is triggered
        {
        "demo": "Basic Prompt - Hello World",
        "response_raw": {
            "messages": [
            {
                "role": "assistant",
                "content": "Hello! I’m an AI assistant. I can help with things like:\n\n- Answering questions\n- Explaining concepts\n- Writing and editing text\n- Brainstorming ideas\n- Summarizing articles or notes\n- Helping with coding and debugging\n- Translating or rephrasing content\n- Planning trips, projects, or study schedules\n- Creating emails, resumes, and reports\n\nYou can talk to me naturally, like:\n- “Explain this simply”\n- “Help me write a professional email”\n- “Debug this Python code”\n- “Summarize this paragraph”\n- “Give me ideas for a business name”\n\nIf you want, you can test me with anything right now.",
                "toolCalls": []
            }
            ],
            "toolCalls": [],
            "toolResults": [],
            "steps": [
            {
                "text": "Hello! I’m an AI assistant. I can help with things like:\n\n- Answering questions\n- Explaining concepts\n- Writing and editing text\n- Brainstorming ideas\n- Summarizing articles or notes\n- Helping with coding and debugging\n- Translating or rephrasing content\n- Planning trips, projects, or study schedules\n- Creating emails, resumes, and reports\n\nYou can talk to me naturally, like:\n- “Explain this simply”\n- “Help me write a professional email”\n- “Debug this Python code”\n- “Summarize this paragraph”\n- “Give me ideas for a business name”\n\nIf you want, you can test me with anything right now.",
                "tool_calls": [],
                "tool_results": [],
                "finish_reason": "stop",
                "usage": {
                "prompt_tokens": 29,
                "completion_tokens": 146,
                "cache_write_input_tokens": 0,
                "cache_read_input_tokens": 0,
                "reasoning_tokens": 0
                },
                "meta": {
                "provider": "openai",
                "model": "gpt-5.4-2026-03-05",
                "citations": []
                }
            }
            ],
            "text": "Hello! I’m an AI assistant. I can help with things like:\n\n- Answering questions\n- Explaining concepts\n- Writing and editing text\n- Brainstorming ideas\n- Summarizing articles or notes\n- Helping with coding and debugging\n- Translating or rephrasing content\n- Planning trips, projects, or study schedules\n- Creating emails, resumes, and reports\n\nYou can talk to me naturally, like:\n- “Explain this simply”\n- “Help me write a professional email”\n- “Debug this Python code”\n- “Summarize this paragraph”\n- “Give me ideas for a business name”\n\nIf you want, you can test me with anything right now.",
            "usage": {
            "prompt_tokens": 29,
            "completion_tokens": 146,
            "cache_write_input_tokens": 0,
            "cache_read_input_tokens": 0,
            "reasoning_tokens": 0
            },
            "meta": {
            "provider": "openai",
            "model": "gpt-5.4-2026-03-05",
            "citations": []
            },
            "invocationId": "019dba79-e0a0-70a3-a457-1e20e98b07c6",
            "conversationId": null,
            "conversationUser": null
        },
        "response_str": "Hello! I’m an AI assistant. I can help with things like:\n\n- Answering questions\n- Explaining concepts\n- Writing and editing text\n- Brainstorming ideas\n- Summarizing articles or notes\n- Helping with coding and debugging\n- Translating or rephrasing content\n- Planning trips, projects, or study schedules\n- Creating emails, resumes, and reports\n\nYou can talk to me naturally, like:\n- “Explain this simply”\n- “Help me write a professional email”\n- “Debug this Python code”\n- “Summarize this paragraph”\n- “Give me ideas for a business name”\n\nIf you want, you can test me with anything right now."
        }
         */
        $agent = HelloWorldAgent::make();
        $response = $agent->prompt('Hello! what are you and what you can help me with?');
        return response()->json([
            'demo' => 'Basic Prompt - Hello World',
            'response_raw' => $response,
            'response_str' => (string) $response
        ]);
    }
    public function promptWithInput(Request $request) {
        $validated = $request->validate([
            'prompt' => ['string', 'required', 'max:1000'],
            'provider' => ['string', 'nullable'],
            'model' => ['string', 'nullable']
        ]);
        $agent = HelloWorldAgent::make();
        $prompt = $validated['prompt'];
        $provider = $request->query('provider', 'openai');
        $model = $request->query('model', null);
        $response = $agent->prompt($prompt, provider: $provider, model: $model);
        return response()->json([
            'demo' => 'prompt with user input',
            'user_message' => $prompt,
            'response_raw' => $response,
            'response_str' => (string) $response
        ]);
    }
}

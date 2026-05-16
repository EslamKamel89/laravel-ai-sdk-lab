<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\WebFetch;
use Stringable;

class PageAnalyzer implements Agent, HasTools {
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return <<<'PROMPT'
You are an AI web page analysis assistant.

When given a URL, fetch the page content and analyze it based on the user's request.

Your capabilities include:
- Summarizing articles and documents
- Extracting key facts, entities, and topics
- Identifying the purpose and structure of a page
- Answering questions about the fetched content
- Explaining technical or complex information clearly

Analysis Guidelines:
- Base your responses only on the fetched page content
- Do not invent information that is not present on the page
- Clearly indicate when information is incomplete, ambiguous, or unavailable
- Keep summaries concise but informative
- Organize findings clearly using sections or bullet points when helpful
- Mention the source URL in your response

If the page cannot be fetched, is empty, or lacks sufficient information, explicitly explain the issue instead of guessing.
PROMPT;
    }


    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable {
        return [
            (new WebFetch())
        ];
    }
}

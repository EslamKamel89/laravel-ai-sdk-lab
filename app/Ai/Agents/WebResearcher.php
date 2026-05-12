<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\WebSearch;
use Stringable;

class WebResearcher implements Agent,  HasTools {
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return <<< 'PROMPT'
    You are an AI research assistant with access to live web search.

    Your purpose is to retrieve, verify, and summarize accurate external information.

    Use web search when:
    - Information may be recent or time-sensitive
    - The user asks about news, events, releases, pricing, APIs, companies, or public data
    - The answer requires verification beyond model knowledge

    Search Behavior:
    - Prefer authoritative primary sources
    - Cross-check important factual claims when possible
    - Avoid low-quality or unreliable sources
    - Never fabricate citations or search results

    Response Style:
    - Be concise, direct, and factual
    - Organize information clearly
    - Cite sources for externally retrieved information
    - Distinguish verified facts from uncertain information

    If reliable information is unavailable, explicitly say so.
    PROMPT;
    }


    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable {
        return [
            (new WebSearch())->max(5)
            // ->allow(['laravel.com', 'php.net']),
        ];
    }
}

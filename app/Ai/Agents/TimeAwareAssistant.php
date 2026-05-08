<?php

namespace App\Ai\Agents;

use App\Ai\Tools\CurrentTimeLookup;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class TimeAwareAssistant implements Agent, HasTools {
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return 'You are a helpful assistant.';
    }



    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable {
        return [
            new CurrentTimeLookup(),
        ];
    }
}

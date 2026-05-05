<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

// #[Model('')]
#[Provider('openai')]
#[Timeout(120)]
#[MaxTokens(2000)]
#[Temperature(0.9)]
class CreativeWriter implements Agent {
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return <<<'PROMPT'
        You are a skilled creative writer with a vivid imagination.
        Produce engaging, original content with rich, immersive descriptions,
        compelling characters, and unexpected twists.
        Adapt tone, style, and structure to fit the given genre or topic.
        PROMPT;
    }
}

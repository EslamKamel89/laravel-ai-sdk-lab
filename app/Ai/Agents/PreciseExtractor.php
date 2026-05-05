<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;

#[Temperature(0.0)]
#[Timeout(90)]
#[MaxTokens(500)]
class PreciseExtractor implements Agent, HasStructuredOutput {
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return <<<'PROMPT'
        You are a precise data extraction assistant.
        Extract only the requested fields from the input.
        Return factual, concise results with no assumptions or extra text.
        If a field is missing, use null or an empty value.
        PROMPT;
    }
    /**
     * Get the agent's structured output schema definition.
     *
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array {
        return [
            'name' => $schema
                ->string()
                ->description('Full name of the person')
                ->required(),
            'email' => $schema
                ->string()
                ->description('Email address if found otherwise empty string')
                ->required(),
            'phone_number' => $schema
                ->string()
                ->description('Phone Number if found otherwise empty string')
                ->required(),
            'company' => $schema
                ->string()
                ->description('company name if found otherwise empty string')
                ->required(),
        ];
    }
}

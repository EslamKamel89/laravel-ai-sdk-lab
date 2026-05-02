<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class SentimentAnalyzer implements Agent, HasStructuredOutput {
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return <<<'PROMPT'
Sentiment analysis:

Return:
- sentiment: positive|negative|neutral
- score: 1–10
- topics: 1–5 keywords
- summary: one sentence

Rules: use only text; unclear→neutral (4–6); strong→extremes; be consistent.
PROMPT;
    }

    /**
     * Define structured output schema.
     */
    public function schema(JsonSchema $schema): array {
        return [
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
    }
}

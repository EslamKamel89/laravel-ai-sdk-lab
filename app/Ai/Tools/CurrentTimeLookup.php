<?php

namespace App\Ai\Tools;

use Carbon\Carbon;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CurrentTimeLookup implements Tool {
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string {
        return <<<'PROMPT'
    Retrieve the current date and time.

    Use this tool when:
    - The user asks for the current time or date
    - The user refers to "now", "today", or "current time"
    - The user asks for time in a specific location or timezone

    If no timezone is provided, default to UTC.

    The tool returns structured time information including:
    - full datetime
    - formatted date
    - formatted time
    - day of week
    - UTC offset
    PROMPT;
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string {
        $timezone = $request->str('timezone', 'UTC');
        try {
            $now = Carbon::now($timezone);
            return json_encode([
                'success' => true,
                'timezone' => $timezone,
                'datetime' => $now->toDateTimeString(),
                'date' => $now->toFormattedDateString(),
                'time' => $now->format('g:i A'),
                'day_of_week' => $now->format('l'),
                'utc_offset' => $now->format('P'),
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'success' => false,
                'error' => 'Invalid timezone',
                'message' => $th->getMessage(),
                'example_timezones' => [
                    'UTC',
                    'Africa/Cairo',
                    'Europe/London',
                    'America/New_York'
                ]
            ]);
        }
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array {
        return [
            'timezone' => $schema
                ->string()
                ->required()
                ->description(
                    'Optional timezone (e.g. "UTC", "Africa/Cairo", "Europe/London"). If not provided, defaults to UTC.'
                ),
        ];
    }
}

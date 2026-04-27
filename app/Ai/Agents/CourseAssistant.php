<?php

namespace App\Ai\Agents;

use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;


class CourseAssistant implements Agent, Conversational {
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string {
        return "You are a teaching assistant for laravel ai sdk. "
            . "you should memorize and index the user conversation "
            . "When the user asks reference something he mentioned earlier acknowledges it and build upon it "
            . "Keep responses concise 2 to 3 sentences maximum";
    }

    // you have to comment this method that is created by default when you are using RemembersConversations trait so it won't override the functionality of the trait and always return an empty list.
    // public function messages(): iterable {
    //     return [];
    // }
}

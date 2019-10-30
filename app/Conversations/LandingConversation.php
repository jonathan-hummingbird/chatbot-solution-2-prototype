<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Log;

class LandingConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $extras = $this->bot->getMessage()->getExtras();
        $apiReply = $extras['apiReply'];
//        $apiContext = $extras['apiContexts'];
//        Log::alert($apiContext);
        $sender = $this->bot->getMessage()->getSender();
        Log::alert("Sender is " . $sender);
        $question_text = strlen($apiReply) === 0 ? "Is there anything else I can do to help?" : $apiReply;
        $question = Question::create($question_text)->callbackId("which_action")
            ->addButtons([
                Button::create("Tell me about your moving plan")->value("moving this Friday"),
                Button::create("Subscribe to newsletter")->value("subscribe"),
            ]);
        $this->bot->ask($question, function () {
            //Get user reply
            $nextAction = $this->bot->getMessage()->getExtras()['apiAction'];
            Log::alert("Received intent is " . $nextAction);
            startNextConversation($this->bot, $nextAction);
        });
    }
}

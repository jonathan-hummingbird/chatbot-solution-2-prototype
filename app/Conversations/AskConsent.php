<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class AskConsent extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply("Do you agree to receive notifications via email?");

        //Move to conversation based on stack without any user reply
        moveToNextConversation($this->bot);
    }
}

<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class AskDestination extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply("Where are you moving to?");

        //Move to conversation based on stack without any user reply
        moveToNextConversation($this->bot);
    }
}

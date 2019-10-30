<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class AskMovingDate extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply("When is the moving date?");

        //Move to conversation based on stack without any user reply
        moveToNextConversation($this->bot);
    }
}

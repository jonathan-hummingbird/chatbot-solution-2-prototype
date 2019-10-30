<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class AskEmail extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply("What is your email address?");

        //Move to conversation based on stack without any user reply
        moveToNextConversation($this->bot);
    }
}

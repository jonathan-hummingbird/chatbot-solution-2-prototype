<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class ShowMovingCost extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply("Your moving cost is approximately $500 USD");

        //Move to conversation based on stack without any user reply
        moveToNextConversation($this->bot);
    }
}

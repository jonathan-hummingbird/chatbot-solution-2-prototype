<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class LoopLandingConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply("Go to loop again");
    }
}

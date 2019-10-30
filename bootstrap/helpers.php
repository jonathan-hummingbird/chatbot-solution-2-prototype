<?php

use App\Conversations\LandingConversation;
use App\ConversationState;
use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Log;

const FINISH_INTENT = "bye";

const CONVERSATION_FLOW = [
    "moving_complete" => ["show_moving_cost"],
    "moving_date_only" => ["ask_origin", "ask_destination", "show_moving_cost"],
    "moving_origin_only" => ["ask_destination", "ask_date", "show_moving_cost"],
    "moving_destination_only" => ["ask_origin", "ask_date", "show_moving_cost"],
    "moving_destination_date" => ["ask_origin", "show_moving_cost"],
    "moving_origin_date" => ["ask_destination", "show_moving_cost"],
    "moving_origin_destination" => ["ask_date", "show_moving_cost"],
];

const MAP_ACTION_TO_CONVERSATION = [
    "moving_complete" => null, //Root intent
    "moving_date_only" => null,
    "moving_origin_only" => null,
    "moving_destination_only" => null,
    "moving_destination_date" => null,
    "moving_origin_date" => null,
    "moving_origin_destination" => null,
    "ask_origin" => "App\Conversations\AskOrigin",
    "ask_destination" => "App\Conversations\AskDestination",
    "ask_date" => "App\Conversations\AskMovingDate",
    "show_moving_cost" => "App\Conversations\ShowMovingCost"
];

function startNextConversation(BotMan $bot, $next_intent) {
    $state = new ConversationState();

    if ($next_intent === FINISH_INTENT) {
        Log::alert("BYE FLOW DETECTED!");
        $reply = $bot->getMessage()->getExtras()['apiReply'];
        $bot->reply($reply);
        return;
    }

    //Handle incorrect intent
    if (!array_key_exists($next_intent, MAP_ACTION_TO_CONVERSATION) || !array_key_exists($next_intent, CONVERSATION_FLOW)) {
        Log::alert("INCORRECT INTENT DETECTED!");
        $bot->startConversation(new LandingConversation());
        return;
    }

    if (MAP_ACTION_TO_CONVERSATION[$next_intent] === null) {
        //If action is root intent, we need to clear intent
        $state->clear();
        $flow = CONVERSATION_FLOW[$next_intent];
        $nextAction = $flow[0];
        $state->updateReplace(array_slice($flow, 1));
        $nextClass = MAP_ACTION_TO_CONVERSATION[$nextAction];
        $bot->startConversation(new $nextClass());
    } else {
        moveToNextConversation($bot);
    }
    return;
}

function moveToNextConversation(Botman $bot) {
    $state = new ConversationState();
    if (count($state->get()) === 0) {
        //Empty stack, repeat loop again
        $bot->startConversation(new LandingConversation());
    } else {
        $next = $state->get()[0];
        $update = array_slice($state->get(), 1);
        $state->updateReplace($update);
        $nextClass = MAP_ACTION_TO_CONVERSATION[$next];
        $bot->startConversation(new $nextClass());
    }

}

<?php
use App\Conversations\LandingConversation;
use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Middleware\ApiAi;

$botman = resolve('botman');
$dialogFlow = ApiAi::create(env("DIALOG_FLOW_API_TOKEN", ""))->listenForAction();
// Apply global "received" middleware
$botman->middleware->received($dialogFlow);

$botman->hears('Hi', function (BotMan $bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('greetings', function(BotMan $bot) {
    $bot->startConversation(new LandingConversation());
})->middleware($dialogFlow);


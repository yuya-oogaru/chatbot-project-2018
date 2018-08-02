<?php

//composerでインストールしたライブラリ読み込み
require_once __DIR__.'/vendor/autoload.php';

$inputString = file_get_contents('php://input');
error_log($inputString);

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

printf("httpClient = %s \n",$httpClient);
printf("bot = %s \n",$bot);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');

$response = $bot->replyMessage('<replyToken>', $textMessageBuilder);

foreach ($events as $event) {

    $bot->replyText($event->getReplyToken(), $event->getText());
}


?>

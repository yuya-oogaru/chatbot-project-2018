<?php

//composerでインストールしたライブラリ読み込み
require_once __DIR__.'/vendor/autoload.php';

$inputString = file_get_contents('php://input');
error_log($inputString);

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {

    $bot->replyText($event->getReplyToken(), $event->getText());
}

?>

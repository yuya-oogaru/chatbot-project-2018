<?php

//composerでインストールしたライブラリ読み込み
require_once __DIR__.'/vendor/autoload.php';

$inputString = file_get_contents('php://input');

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$signature = $_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE]; 
$Events = $Bot->parseEventRequest($inputString, $Signature);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);

$response = $bot -> replyMessage($events->getReplyToken(), $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

?>

<?php

//composerでインストールしたライブラリ読み込み
require_once __DIR__.'/vendor/autoload.php';

$inputData = file_get_contents("php://input");

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$signature = $_SERVER["HTTP_". \LINE\LINEBot\Constant\HTTPHeader :: LINE_SIGNATURE]; 
$Events = $Bot->parseEventRequest($inputData, $signature);

foreach($Events as $event){

$SendMessage = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
$SendMessage->add($textMessageBuilder);
$response = $bot -> replyMessage($event->getReplyToken(), $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}
?>

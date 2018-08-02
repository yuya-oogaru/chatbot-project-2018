<?php

// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
printf("client = %d\n",$httpClient);

$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
printf("bot = %d\n",$bot);

$inputData = file_get_contents('php://input');
error_log($inputData);

$replyToken = new \LINE\LINEBot\Event\BaseEvent\getReplyToken();

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage($replyToken, $textMessageBuilder);
error_log($replyToken);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

?>

<?php

//composerでインストールしたライブラリ読み込み
require_onec__DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPCLient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

$bot = new \LINE\LINEBot($httpClient, ['channnelSecret' => getenv('CHANNEL_SECRET')]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contrnts('php://input'),$signsture);

foreach ($events as $event){
	$bot->replyText($events->getReplyToken(), 'TextMessage');
}

?>

/**************************************************************
*               ** LINE BOT Project(2018/08/03)**
*
*
*
*
*
*
*************************************************************/

<?php

// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

// 送られて来たJSONデータを取得
$json_string = file_get_contents('php://input');
$json = json_decode($json_string);

/****署名認証****/

// アクセストークンを使いCurlHTTPClientをインスタンス化
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
// CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
// LINE Messaging APIがリクエストに付与した署名を取得
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
// 署名が正当かチェック。正当であればリクエストをパースし配列へ
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

/****************/

/*受信メッセージ抽出*/
$getMessage = $json->events[0]->message->text;

/*リプライトークン（返信証明）取得*/
$replyToken = $json->events[0]->replyToken;

/*返信メッセージ構築*/
$sendMessage =  new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getMessage);


replyTextMessage($events, $bot, $replyToken, $sendMessage);

/* 配列に格納された各イベントをループで処理 */
function replyTextMessage($events, $bot, $replyToken, $sendMessage){
	foreach ($events as $event) {
		$response = $bot->replyMessage($replyToken, $sendMessage);
		
		// レスポンスが異常な場合
		if (!$response->isSucceeded()) {
	    	// エラー内容を出力
			error_log('Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
		}
	}
}

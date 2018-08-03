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

/*返信*/
foreach ($events as $event) {
	replyMultiMessage($bot, $replyToken, 
	new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getMessage),
	new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, 113)
	);
	
	replyButtonsTemplate($bot,$replyToken,
	'お天気お知らせ - 今日は天気予報は晴れです',
	'https://' . $_SERVER['HTTP_HOST'] . '/imgs/template.jpg',
	'お天気お知らせ',
	'今日は天気予報は晴れです',
	new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder (
		'明日の天気', 'tomorrow'),
	new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder (
		'週末の天気', 'weekend'),
	new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
		'Webで見る', 'http://google.jp')
	);
}

/******メッセージおうむ返し関数(未使用)******/
function replyTextMessage($bot, $replyToken, $sendMessage){
/* 配列に格納された各イベントをループで処理 */
	$response = $bot->replyMessage($replyToken, $sendMessage);
	// レスポンスが異常な場合
	if (!$response->isSucceeded()) {
	   	// エラー内容を出力
		error_log('text send Failed! '. $response->getHTTPStatus . ' ' . $response->getRawBody());
	}
}

/******メッセージランチャ******/
function replyMultiMessage($bot, $replyToken, ...$msgs) {
  // MultiMessageBuilderをインスタンス化
  $builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
  // ビルダーにメッセージを全て追加
  foreach($msgs as $value) {
    $builder->add($value);
  }
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

/******ボタンメッセージテンプレート******/
function replyButtonsTemplate($bot, $replyToken, $alternativeText, $imageUrl, $title, $text, ...$actions) {
	$actionArray = array();

	foreach($actions as $value) {
		array_push($actionArray, $value);
	}

	$builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
		$alternativeText,
		new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder ($title, $text, $imageUrl, $actionArray)
	);
	
	$response = $bot->replyMessage($replyToken, $builder);
	if (!$response->isSucceeded()) {
		error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
	}
}

?>

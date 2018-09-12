/**************************************************************
*           ** LINE TEST BOT Project(2018/08/03)**
*
*
*                   テストプログラム！！
*                   本番で使用しないこと
*             処理を全部メインメソッドに書いてるけど
*                   本番では直します・・・
*************************************************************/

<?php

// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

/************************************************************
＊ここからリプライトークン取得までは変えないで
*************************************************************/

// 送られて来たJSONデータを取得
$json_string = file_get_contents('php://input');
error_log(file_get_contents('php://input'));
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


/*ユーザー情報*/
/**************************
$response  :ユーザーＩＤ
$profile   :ユーザープロフィール(表示名,ユーザーID,画像のURL,ステータスメッセージ)
***************************/
$response = $json->events[0]->source->userId;
$profile = $bot->getProfile($response)->getJSONDecodedBody();

$preSendMessage = 'default text';/*テキスト初期化*/
$stickerType = 1;

/******ジョルダンのメッセージでない場合はここを実行して終了******/
if($messageType == false){
	/*メッセージに対して返信を変える*/
	switch($getMessage){
		case 'メニュー':
			$preSendMessage = 'テスト完了！';
			$stickerType = 114;
			break;
		case '大軽':
			$preSendMessage = '開発者の名前';
			$stickerType = 119;
			break;
		case 'うるさい':
			return;
		default :
			$preSendMessage = "無効なメッセージです。\n
現在、当ＢＯＴがサポートしている経路情報は、ジョルダンフォーマットのみとなっています.";
			$stickerType = 113;
			break;
	}

	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($preSendMessage),
			new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, $stickerType)
		);
	}
	return;
}
/**************ここまで**************/


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


?>

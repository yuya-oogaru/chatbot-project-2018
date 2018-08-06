/**************************************************************
*           ** LINE TEST BOT Project(2018/08/03)**
*
*
*                   テストプログラム！！
*                   本番で使用しないこと
*
*
*************************************************************/

<?php

// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

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

/*ジョルダンのメッセージかどうか判断*/
$startPos = mb_strpos($getMessage, 'ジョルダン乗換案内', 1, "UTF-8");

/*交通費データの抽出場所特定*/

$routeNamePos = mb_strpos($getMessage, '  ',1 , "UTF-8");
$dateEndPos = mb_strpos($getMessage, ')',$routeNamePos , "UTF-8");
$transitTimePos = mb_strpos($getMessage, '乗換', 1, "UTF-8");
$transitTimeEndPos = mb_strpos($getMessage, '回', 1, "UTF-8");
$totalPricePos = mb_strpos($getMessage, '　', $transitTimePos, "UTF-8");
$totalPricePos += 1;
$totalPriceEndPos = mb_strpos($getMessage, '円', $totalPricePos, "UTF-8");

$preSendMessage = 'default text';

/*****データ抽出*****/

/*ユーザー情報*/
$response = $json->events[0]->source->userId;
$profile = $bot->getProfile($response)->getJSONDecodedBody();

/*交通費データ*/
$routes = mb_substr($getMessage, 1, $routeNamePos, "UTF-8");
$date = mb_substr($getMessage, ($routeNamePos + 1), (($dateEndPos - $routeNamePos) + 1), "UTF-8");
$transit = mb_substr($getMessage, ($transitTimePos + 2), ($transitTimeEndPos - ($transitTimePos + 2)), "UTF-8");
$price = mb_substr($getMessage, $totalPricePos, ($totalPriceEndPos - $totalPricePos), "UTF-8");


/*返信*/
if($startPos != false){
	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
		
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('交通費データは以下の内容で登録可能です。
			
			'.'登録者名 : ['.$profile['displayName'].']
			'.'登録日時 : ['.date('Y/m/d').']
			'.'経路 : ['.$routes.']
			'.'乗車日 : ['.$date.']
			'.'乗換回数 : ['.$transit.'回]
			'.'運賃合計 : ['.$price.'円]'
			),
			new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(3, 229)
		);
	}
}else{
	/*メッセージに対して返信を変える*/
	switch($getMessage){
		case 'テスト':
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
			$preSendMessage = $json->events[0]->message->text;
			$stickerType = 113;
			break;
	}

	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($preSendMessage),
			new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, $stickerType)
		);
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

?>

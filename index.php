/**************************************************************
*           ** LINE TEST BOT Project(2018/08/03)**
*
*
*                      テストプログラム！！
*                      本番で使用しないこと
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
//$getMessage = $json->events[0]->message->text;

$getMessage = '桜ノ宮〜東京  8/ 3(金) 13:47 - 16:43\n2時間56分　乗換2回　14,650円\n--------------------\n切符利用時の運賃です。\n[ 8/ 3]\n13:47発　桜ノ宮\n　大阪環状
線大阪方面関空快速≪日根野で切り離し注意≫(関西空港行)\n13:55発　大阪\n　ＪＲ京都線(高槻行)\n14:10発　新大阪\n　のぞみ364号(N700系)(東京行)\n16:43着　
東京\n\n--------------------\n詳しい結果はコチラ\nジョルダン乗換案内\n';

/*リプライトークン（返信証明）取得*/
$replyToken = $json->events[0]->replyToken;

/*ジョルダンのメッセージかどうか判断*/
$startPos = mb_strpos($getMessage, 'ジョルダン乗換案内');

/*必要情報の抽出*/
$routeNamePos = strpos($getMessage, '  ');
//$transitTimePos = mb_strpos($getMessage, '　');

$preSendMessage = 'default text';
new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($startPos);
/*返信*/
if($startPos != 'false'){
	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($routeNamePos),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($transitTimePos),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('入力された経路は['. substr($getMessage, 0, $routeNamePos). ']です。'),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('日付は['. substr($getMessage, $routeNamePos, 12). ']です。'),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('乗換回数は['. substr($getMessage, $transitTimePos, 12). ']です。'),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('運賃合計は['. substr($getMessage, ($transitTimePos + 12), 12). ']です。')
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
			$preSendMessage = '偉大な開発者の名前';
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
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($preSendMessage)
			//new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, $stickerType)
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

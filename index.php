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
require_once __DIR__ . '/basicfunc.php';

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
***************************/
$userID = $json->events[0]->source->userId;

$preSendMessage = 'default text';/*テキスト初期化*/
$stickerType = 1;

	/*メッセージに対して返信を変える*/
	switch($getMessage){
		case '大軽':
			$preSendMessage = '開発者の名前';
			$stickerType = 119;
			break;
		case 'テスト':
			$preSendMessage = 'テストwww';
			break;
		case 'うるさい':
			return;
		default :
			foreach ($events as $event) {
				replyConfirmTemplate($bot, 
				$event->getReplyToken(), 
				'Are you sure?','Are you sure?', 
				new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('yes', 'yes'),
				new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder ('no', 'no'));
			}
			
			registerUser($userID, waiting, $getMessage);
			return;
	}

	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($preSendMessage),
			new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, $stickerType)
		);
	}
	
	return ;

/*******ＤＢにユーザーステータスを追加する関数*******/

function registerUser($userID, $status, $tempData){
	$dbh = dbConnection::getConnection();
	$sql = 'insert into status (userID, status, tempData) values (:userID, :status, :tempData)';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*登録者ID（ラインアカウントID）*/
	$sth->bindValue(':status', $status, PDO::PARAM_STR);            /*状態*/
	$sth->bindValue(':tempData', $tempData, PDO::PARAM_STR);        /*一時データ*/
	
	$sth->execute();
}


?>

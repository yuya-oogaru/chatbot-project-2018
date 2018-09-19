<?php

/*インクルードファイル*/
require_once (__DIR__ . '/MessageBuild/messageTemplate.php');
require_once (__DIR__ . '/MessageBuild/DataListTemplate.php');
require_once (__DIR__ . '/MessageBuild/MenuListTemplate.php');
require_once (__DIR__ . '/basicfunc.php');

/*LINEBotアクセストークン*/
$access_token = getenv('CHANNEL_ACCESS_TOKEN');

/**************ユーザー情報読み取り*******************/

//APIから送信されてきたイベントオブジェクトを取得
$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);

//イベントオブジェクトから必要な情報を抽出
$message = $json_obj->{"events"}[0]->{"message"}->{"text"};
$reply_token = $json_obj->{"events"}[0]->{"replyToken"};

/*****************応答メッセージ作成**********************/

$post_data = textMessage($reply_token, 'default message');   /*応答フォーマット初期化*/

switch($message){
case '請求':
	$post_data = confirmTemplate($reply_token, '申請運賃をユーザー請求で登録しますか？','請求あり','請求なし'); /*確認テンプレート*/
	break;
case '往復':
	$post_data = confirmTemplate($reply_token, '申請運賃を往復で登録しますか？','往復','片道'); /*確認テンプレート*/
	break;
case '登録':
	$post_data = FlexTemplate($reply_token);    /*Flexメッセージ*/
	break;
case '申請':
	$post_data = ApplyFlexTemplate($reply_token);    /* 申請内容確認メッセージ*/
	break;
case 'メニュー':
	$post_data = MenuListFlexTemplate($reply_token);    /*メニューFlexメッセージ*/
	break;
case 'キャンセル':
	return;
default :
	$post_data = textMessage($reply_token, $message);     /*テキストメッセージ*/
	break;
}
/*Jsonを日本語（２バイト文字）に対応 = json扱うファイルは 文字コードをUTF-8にしないといけない！！！*/


/*メッセージjsonデータ確認*/
error_log('post_data = '.json_encode($post_data).'');

/****************応答メッセージ送信*******************/
sendReplyMessage($post_data, $access_token);

?>

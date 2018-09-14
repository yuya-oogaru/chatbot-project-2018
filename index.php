<?php

/*メッセージJSONデータ構成ファイル*/
require (__DIR__ . '/MessageBuild/messageTemplate.php');
require (__DIR__ . '/MessageBuild/DataListTemplate.php');
require (__DIR__ . '/MessageBuild/MenuListTemplate.php');

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
case '確認':
	$post_data = confirmTemplate($reply_token, 'Are you sure?'); /*確認テンプレート*/
	break;
case '登録':
	$post_data = FlexTemplate($reply_token);    /*Flexメッセージ*/
	break;
case '申請':
	$post_data = DataListFlexTemplate($reply_token);    /*リストFlexメッセージ*/
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

//curlを使用してメッセージを返信する
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $access_token
));
$result = curl_exec($ch);
curl_close($ch);

?>

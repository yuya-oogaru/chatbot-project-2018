<?php

/*インクルードファイル*/
require_once (__DIR__ . '/MessageBuild/messageTemplate.php');
require_once (__DIR__ . '/MessageBuild/DataListTemplate.php');
require_once (__DIR__ . '/MessageBuild/MenuListTemplate.php');
require_once (__DIR__ . '/basicfunc.php');
require_once (__DIR__ . '/test_function.php');
require_once (__DIR__ . '/sql.php');

/*LINEBotアクセストークン*/
$access_token = getenv('CHANNEL_ACCESS_TOKEN');

/**************ユーザー情報読み取り*******************/

//APIから送信されてきたイベントオブジェクトを取得
$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);

//イベントオブジェクトから必要な情報を抽出
$message = $json_obj->{"events"}[0]->{"message"}->{"text"};
$reply_token = $json_obj->{"events"}[0]->{"replyToken"};

//ユーザーID取得
$userID = $json_obj->{"events"}[0]->{"source"}->{"userId"};

/*************ユーザーのステータス確認******************/

/*既存のユーザー情報がない場合*/
if(searchUserID($userID) == NULL){
	registerUser($userID, 'pre_proc', 1);
}

/*ステータス確認*/
$status = searchStatus($userID);

/*****************応答メッセージ作成**********************/

$post_data = textMessage($reply_token, $status);
//$post_data = testSelection($post_data, $message, $reply_token);

/*Jsonを日本語（２バイト文字）に対応 = json扱うファイルは 文字コードをUTF-8にしないといけない！！！*/


/*メッセージjsonデータ確認*/
error_log('post_data = '.json_encode($post_data).'');

/****************応答メッセージ送信*******************/
sendReplyMessage($post_data, $access_token);

?>

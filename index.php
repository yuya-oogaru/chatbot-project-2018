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

/*既存のユーザー情報がない場合の初期化*/
if(searchUserID($userID) == NULL){
	registerUser($userID, 'pre_proc', 1);
}

/*ステータス確認*/
$status = searchStatus($userID);

/**********デバッグオプション・ステータス確認**********/

/*ステータス確認は、メッセージに「ステータス」と送ることで行う。*/
if($message == 'ステータス'){
	$post_data = textMessage($reply_token, 'ステータスは'.$status);
	sendReplyMessage($post_data, $access_token);
	return;
}


/****************ステータスに応じた処理呼び出し******************

確認したステータスをもとに、当該の処理を呼び出し。


***各状態名***

[共通]

pre_proc        :ユーザーが何も操作を行っていない状態（初期）

[メニュー選択中]

menu            :ユーザーがメニューを表示し、機能の選択を行っている状態

[経路データ登録処理中]

ins_inp_office  :ユーザーが、登録する行先名を入力している状態
ins_sel_claim   :ユーザーが、ユーザー請求の可否を選択している状態
ins_sel_rounds  :ユーザーが、往復の有無を選択している状態
ins_inp_others  :ユーザーが、備考の入力を行っている状態
ins_sel_confirm :ユーザーが、登録内容の確認を行っている状態

[経路データ申請処理中]

aplly_confirm   :ユーザーが申請内容の確認を行っている状態


[経路データ削除処理中]

del_inp_num     :ユーザーが削除するデータを選択している状態。
del_confirm     :ユーザーが削除内容の確認を行っている状態。

****************************************************************/

switch($status){
	case 'pre_proc':
		
		updateStatus($userID, 'ins_inp_office');
		$post_data = textMessage($reply_token, 'ステータスをins_inp_officeへ移行');
		
		break;
	case 'ins_inp_office':
		
		updateStatus($userID, 'ins_sel_claim');
		$post_data = textMessage($reply_token, 'ステータスをins_sel_claimへ移行');
		
		break;
	case 'ins_sel_claim':
		
		updateStatus($userID, 'ins_sel_rounds');
		$post_data = textMessage($reply_token, 'ステータスをins_sel_roundsへ移行');
		
		break;
	case 'ins_sel_rounds':
		
		updateStatus($userID, 'ins_inp_others');
		$post_data = textMessage($reply_token, 'ステータスをins_inp_othersへ移行');
		
		break;
	case 'ins_inp_others':
		
		updateStatus($userID, 'ins_sel_confirm');
		$post_data = textMessage($reply_token, 'ステータスをins_sel_confirmへ移行');
		
		break;
	case 'ins_sel_confirm':
		
		updateStatus($userID, 'pre_proc');
		$post_data = textMessage($reply_token, 'ステータスをpre_procへ移行');
		
		break;
		
	case 'menu':
		
		break;
		
	case 'aplly_confirm':
		
		$post_data = textMessage($reply_token, 'ステータスエラー 管理者に報告してください');
		
		break;
	case 'del_inp_num':
		
		$post_data = textMessage($reply_token, 'ステータスエラー 管理者に報告してください');
		
		break;
	case 'del_confirm':
		
		$post_data = textMessage($reply_token, 'ステータスエラー 管理者に報告してください');
		
		break;
	default:
		$post_data = textMessage($reply_token, 'ステータスエラー 管理者に報告してください');
		break;
}

/**********デバッグオプション・ステータスリセット**********/

/*リセットは、メッセージに「リセット」と送ることで行う。*/
if($message == 'リセット'){
	updateStatus($userID, 'pre_proc');
	$post_data = textMessage($reply_token, 'ステータスをpre_procへリセット');
}

/*****************応答メッセージ作成**********************/

//$post_data = textMessage($reply_token, $status);
//$post_data = testSelection($post_data, $message, $reply_token);

/*Jsonを日本語（２バイト文字）に対応 = json扱うファイルは 文字コードをUTF-8にしないといけない！！！*/


/*メッセージjsonデータ確認*/
error_log('post_data = '.json_encode($post_data).'');

/****************応答メッセージ送信*******************/
sendReplyMessage($post_data, $access_token);

?>

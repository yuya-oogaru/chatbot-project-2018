<?php
/*
*                 交通費申請Bot ver 1.0
*                 メインソースファイル
*
*    2018 ソースコードに会社名入れてもいいんでしょうか？
*
*
*********************************************************/

/*ToDo 定数定義！*/

/*バージョン*/
//define('VERSION'.'1.0');

/*****インクルードファイル*****/
require_once (__DIR__ . '/MessageBuild/messageTemplate.php');  /*LINEメッセージ送信用JSONデータ構築処理メインファイル*/
require_once (__DIR__ . '/MessageBuild/DataListTemplate.php'); /*LINEメッセージ送信用JSONデータ構築処理 申請メッセージ用*/
require_once (__DIR__ . '/MessageBuild/MenuListTemplate.php'); /*LINEメッセージ送信用JSONデータ構築処理 機能メニュー用*/
require_once (__DIR__ . '/basicfunc.php');                     /*メッセージ送信・データベース接続などの、基本的な処理*/
require_once (__DIR__ . '/get_profile.php');                   /*ユーザー名取得用*/
require_once (__DIR__ . '/SqlExecuter/main_sql.php');          /*データベース操作（I/O）処理(メイン)*/
require_once (__DIR__ . '/SqlExecuter/debug_option_sql.php');  /*デバッグオプション用SQL*/
require_once (__DIR__ . '/SqlExecuter/status_sql.php');        /*ユーザーのステータス用データベース操作（I/O）処理*/
require_once (__DIR__ . '/SqlExecuter/temp_data_sql.php');     /*登録データ取得用データベース操作処理*/
require_once (__DIR__ . '/SqlExecuter/list_data_sql.php');     /*一時記憶データベース操作処理*/
require_once (__DIR__ . '/menu.php');                          /*Botの各機能呼び出し処理*/
require_once (__DIR__ . '/insert_proc_launcher.php');          /*経路データ登録機能メインファイル*/
require_once (__DIR__ . '/insert_proc_sub_func.php');          /*経路データ登録機能サブファイル*/
require_once (__DIR__ . '/apply_delete_proc_launcher.php');    /*経路データ申請・削除メインファイル*/
require_once (__DIR__ . '/apply_delete_proc_sub_func.php');    /*経路データ申請・削除サブファイル*/

/*LINEBotアクセストークン(heroku側で定義)*/
$access_token = getenv('CHANNEL_ACCESS_TOKEN');

/****************************************************
         ここから、Botのメイン処理に移ります。
*****************************************************/


/**************ユーザー情報読み取り*******************/

/*APIから送信されてきたイベントオブジェクトを取得*/
$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);

/*受信jsonデータ確認*/
error_log('receive_data = '.$json_string.'');

/*イベントオブジェクトから必要な情報を取得*/
$message = $json_obj->{"events"}[0]->{"message"}->{"text"};
$reply_token = $json_obj->{"events"}[0]->{"replyToken"};

/*ユーザーID取得*/
$userID = $json_obj->{"events"}[0]->{"source"}->{"userId"};
/*ユーザー名の取得*/
$userName = getLineUserName($void);

/*データベースLINE_USERINFO_MSへの登録がない場合（初回登録時のみの操作）*/
if(getUserInfoMsData($userID) == NULL){
	insertDataToUserInfoMs($userID, $userName);
/*登録がある場合はユーザーネーム更新*/
}else{
	update_userNames($userID, $userName);
}
	
/*************ユーザーのステータス確認******************/

/*既存のユーザー情報がない場合の初期化*/
if(searchUserID($userID) == NULL){
	registerUser($userID, 'pre_proc');
}

/*ステータス確認*/
$status = searchStatus($userID);

/************メッセージの種類判断***********************/

$messageType = checkMessageType($json_obj);

/******経路登録だけは、どの状態からでもアクセス可能*********/

if(($messageType != 'textMessage')&&
	($messageType != 'unsupported')){
	
	updateStatus($userID, 'pre_proc');
	$status = 'pre_proc';
}

/**********デバッグオプション・登録データ全消去**********/
if($message == '全削除'){
	deleteAllData_DebugOpt($userID);
	updateStatus($userID, 'pre_proc');
	$post_data = textMessage($reply_token, 'データを全削除しました。');
	sendReplyMessage($post_data, $access_token);
	return;
}
/**********デバッグオプション・ステータスリセット**********/

/*リセットは、メッセージに「リセット」と送ることで行う。*/
if($message == 'リセット'){
	updateStatus($userID, 'pre_proc');
	$post_data = textMessage($reply_token, 'ステータスをpre_procにリセット');
	sendReplyMessage($post_data, $access_token);
	return;
}
/**********デバッグオプション・ステータス確認**********/

/*ステータス確認は、メッセージに「ステータス」と送ることで行う。*/
if($message == 'ステータス'){
	$post_data = textMessage($reply_token, 'ステータスは'.$status);
	sendReplyMessage($post_data, $access_token);
	return;
}
/**************応答メッセージ初期化*************************/

$post_data = textMessage($reply_token, 'default message');

/****************ステータスに応じた処理呼び出し******************

確認したステータスをもとに、当該の処理を呼び出し。

***各状態名($status)***

[共通]

pre_proc        :ユーザーが何も操作を行っていない状態（初期）

[経路データ登録処理中]

ins_inp_office  :ユーザーが、登録する行先名を入力している状態
ins_sel_claim   :ユーザーが、ユーザー請求の可否を選択している状態
ins_sel_rounds  :ユーザーが、往復の有無を選択している状態
ins_inp_others  :ユーザーが、備考の入力を行っている状態
ins_sel_confirm :ユーザーが、登録内容の確認を行っている状態

[メニュー選択中]

menu  :ユーザーがメニューを表示し、機能の選択を行っている状態

[経路データ申請処理中]

aplly_confirm   :ユーザーが申請内容の確認を行っている状態

[経路データ削除処理中]
	
del_inp_num :ユーザーが削除するデータを選択している状態。
del_confirm :ユーザーが削除内容の確認を行っている状態。

---------------------------------------------------------------

正規処理順序（本来呼び出される）

経路登録：I1～I6

経路申請：M1～M2->A1

経路削除：M1～M2->D1～D2

****************************************************************/

switch($status){
	case 'pre_proc':
		
		if(($messageType == 'androidJorudan')||
			($messageType == 'iosJorudan')){
			/*I１．経路データ読み取り＝＞行先入力要求*/
			$post_data = pre_proc_func($userID, $message, $reply_token, $messageType);
			
		}else if($message == 'メニュー'){

			/*M1.メニュー選択要求*/
			$post_data = MenuListFlexTemplate($reply_token, $userID);
			
			/*ステータスをmenuへ移行*/
			updateStatus($userID, 'menu');
			
		}else{
			/*無効なコマンド*/
			$post_data = textMessage($reply_token, '無効なコマンドです。メッセージで「メニュー」と入力送信すると、メニュー画面を呼び出すことができます。');
		}
		
		break;
		
	case 'ins_inp_office':

		/*I２．行先読み取り＝＞ユーザー請求可否選択要求*/
		$post_data = ins_inp_office_func($userID, $message, $reply_token);
		break;
		
	case 'ins_sel_claim':
		
		/*I３．ユーザー請求可否選択読み取り＝＞往復の有無選択要求*/
		$post_data = ins_sel_claim_func($userID, $message, $reply_token);
		break;
		
	case 'ins_sel_rounds':
		
		/*I４．往復の有無選択読み取り＝＞備考入力要求*/
		$post_data = ins_sel_rounds_func($userID, $message, $reply_token);
		break;
		
	case 'ins_inp_others':
		
		/*I５．備考入力読み取り＝＞入力内容確認要求*/
		$post_data = ins_inp_others_func($userID, $message, $reply_token, $post_data);
		break;
		
	case 'ins_sel_confirm':
		
		/*I６．入力内容確認y/n読み取り＝＞入力内容DB登録*/
		$post_data = ins_sel_confirm_func($userID, $message, $reply_token);
		break;
		
	case 'menu':
	
		/*M２.メニュー選択読み取り＝＞削除・申請処理開始*/
		$post_data = menu_func($userID, $message, $reply_token);
		break;
		
	case 'aplly_confirm':
		
		/*A１．申請可否選択読み取り＝＞申請処理*/
		$post_data = aplly_confirm_func($userID, $message, $reply_token);
		break;
	
	case 'del_inp_num':
	
		/*D１．削除データの登録No読み取り＝＞削除データ確認要求*/
		$post_data = del_inp_num_func($userID, $message, $reply_token);
		break;
		
	case 'del_confirm':
	
		/*D２．削除データ確認y/n読み取り＝＞削除処理*/
		$post_data = del_confirm_func($userID, $message, $reply_token);
		break;
		
	default:
	
		$post_data = textMessage($reply_token, 'ステータスエラー 管理者に報告してください');
		break;
}

/**********************************************************/

/*Jsonを日本語（２バイト文字）に対応 = json扱うファイルは 文字コードをUTF-8にしないといけない！！！*/

/*メッセージjsonデータ確認*/
error_log('post_data = '.json_encode($post_data).'');

/*応答メッセージ送信*/
sendReplyMessage($post_data, $access_token);

?>

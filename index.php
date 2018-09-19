<?php

/*ToDo 定数定義！*/

/*インクルードファイル*/
require_once (__DIR__ . '/MessageBuild/messageTemplate.php');
require_once (__DIR__ . '/MessageBuild/DataListTemplate.php');
require_once (__DIR__ . '/MessageBuild/MenuListTemplate.php');
require_once (__DIR__ . '/basicfunc.php');
require_once (__DIR__ . '/sql.php');
require_once (__DIR__ . '/insert_proc_launcher.php');
require_once (__DIR__ . '/apply_delete_proc_launcher.php');

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

/************メッセージの種類判断***********************/

/*メッセージが、ジョルダン検索結果かどうか判断（違う場合は'FALSE'が返る）*/
$messageType = mb_strpos($message, 'ジョルダン乗換案内', 4, "UTF-8");

/**********デバッグオプション・ステータス確認**********/

/*ステータス確認は、メッセージに「ステータス」と送ることで行う。*/
if($message == 'ステータス'){
	$post_data = textMessage($reply_token, 'ステータスは'.$status);
	sendReplyMessage($post_data, $access_token);
	return;
}

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

-----------------------------------------------------------------

正規処理順序（本来呼び出される）

経路登録：I1～I6

経路申請：M1～M2->A1

経路削除：M1～M2->D1～D2

****************************************************************/

switch($status){
	case 'pre_proc':
		
		if($messageType != FALSE){
			/*I１．経路データ読み取り＝＞行先入力要求*/
			$post_data = pre_proc_func($userID, $message, $reply_token);
			
		}else if($message == 'メニュー'){

			/*M1.メニュー選択要求*/
			$post_data = MenuListFlexTemplate($reply_token);
			
			/*ステータスをmenuへ移行*/
			updateStatus($userID, 'menu');
			
		}else{
			/*無効なコマンド*/
			$post_data = textMessage($reply_token, '無効なコマンド');
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

/**********デバッグオプション・ステータスリセット**********/

/*リセットは、メッセージに「リセット」と送ることで行う。*/
if($message == 'リセット'){
	updateStatus($userID, 'pre_proc');
	$post_data = textMessage($reply_token, 'ステータスをpre_procへリセット');
}
/**********************************************************/

/*Jsonを日本語（２バイト文字）に対応 = json扱うファイルは 文字コードをUTF-8にしないといけない！！！*/

/*メッセージjsonデータ確認*/
error_log('post_data = '.json_encode($post_data).'');

/****************応答メッセージ送信*******************/
sendReplyMessage($post_data, $access_token);


function menu_func($userID, $message, $reply_token){

	/*機能メニュー画面にて’申請’を選択*/
	if($message == '申請'){
	
		/*申請確認画面呼び出し*/
		$post_data = ApplyFlexTemplate($reply_token);
		/*ステータスをaplly_confirmへ移行*/
		updateStatus($userID, 'aplly_confirm');
		
	/*機能メニュー画面にて’一件削除’を選択*/
	}else if($message == '一件削除'){
	
		updateStatus($userID, 'del_inp_num');
		$post_data = textMessage($reply_token, '削除する経路データの番号を入力してください。');
	
	/*機能メニュー画面にて’キャンセル’を選択*/
	}else if($message == 'キャンセル'){
	
		updateStatus($userID, 'pre_proc');
		$post_data = textMessage($reply_token, 'キャンセルしました。');
			
	/*そのほかの想定外入力*/
	}else{
	
		$post_data = textMessage($reply_token, '無効なコマンド');
		
	}
	return $post_data;
}
?>

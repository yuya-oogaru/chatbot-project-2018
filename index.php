<?php

/*インクルードファイル*/
require_once (__DIR__ . '/MessageBuild/messageTemplate.php');
require_once (__DIR__ . '/MessageBuild/DataListTemplate.php');
require_once (__DIR__ . '/MessageBuild/MenuListTemplate.php');
require_once (__DIR__ . '/basicfunc.php');
require_once (__DIR__ . '/test_function.php');
require_once (__DIR__ . '/sql.php');
require_once (__DIR__ . '/proc_launcher.php');

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

***各状態名***

[共通]

pre_proc        :ユーザーが何も操作を行っていない状態（初期）

[経路データ登録処理中]

ins_inp_office  :ユーザーが、登録する行先名を入力している状態
ins_sel_claim   :ユーザーが、ユーザー請求の可否を選択している状態
ins_sel_rounds  :ユーザーが、往復の有無を選択している状態
ins_inp_others  :ユーザーが、備考の入力を行っている状態
ins_sel_confirm :ユーザーが、登録内容の確認を行っている状態

****************************************************************/

switch($status){
	case 'pre_proc':/*incomp*/
		
		if($messageType != FALSE){
			/*経路データ登録へ*/
			updateStatus($userID, 'ins_inp_office');
			$post_data = textMessage($reply_token, '行先（会社名）を入力してください。');
			
		}else if($message == 'メニュー'){
			/*メニュー画面呼び出しへ*/
			$post_data = menu_proc_launcher($userID, $message, $reply_token, $post_data);
			
		}else{
			/*無効なコマンド*/
			$post_data = textMessage($reply_token, '無効なコマンド');
		}
		
		break;
	case 'ins_inp_office':/*incomp*/
		
		updateStatus($userID, 'ins_sel_claim');
		$post_data = confirmTemplate($reply_token, '申請運賃をユーザー請求で登録しますか？', 'ユーザー請求', '自社請求');
		
		break;
	case 'ins_sel_claim':/*incomp*/
		
		updateStatus($userID, 'ins_sel_rounds');
		$post_data = confirmTemplate($reply_token, '申請運賃を往復で登録しますか？', '往復', '片道');
		
		break;
	case 'ins_sel_rounds':/*incomp*/
		
		updateStatus($userID, 'ins_inp_others');
		$post_data = textMessage($reply_token, '備考があれば入力してください。');
		
		break;
	case 'ins_inp_others':/*incomp*/
		
		updateStatus($userID, 'ins_sel_confirm');
		$post_data = FlexTemplate($reply_token, '以上の内容で登録しますか？', '内容確認');
		
		break;
	case 'ins_sel_confirm':/*incomp*/
		
		updateStatus($userID, 'pre_proc');
		
		if($message == 'はい'){
			$post_data = textMessage($reply_token, '経路データを登録しました。');
		}else if($message == 'いいえ'){
			$post_data = textMessage($reply_token, '登録をキャンセルしました。');
		}else{
			$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
			updateStatus($userID, 'ins_sel_confirm');
		}
		
		break;
		
	/*************************************************************
	[メニュー選択中]

	menu  :ユーザーがメニューを表示し、機能の選択を行っている状態
	
	**************************************************************/
	case 'menu':
	
		if($message == '申請'){
			$post_data = apply_proc_launcher($userID, $message, $reply_token, $post_data);
			
		}else if($message == '一件削除'){
			updateStatus($userID, 'del_inp_num');
			$post_data = textMessage($reply_token, '削除する経路データの番号を入力してください。');
			
		}else if($message == 'キャンセル'){
			updateStatus($userID, 'pre_proc');
			$post_data = textMessage($reply_token, 'キャンセルしました。');
			
		}else{
			$post_data = textMessage($reply_token, '無効なコマンド');
		}
		
		break;
		
	/****************************************************************
	[経路データ申請処理中]

	aplly_confirm   :ユーザーが申請内容の確認を行っている状態

	****************************************************************/
	case 'aplly_confirm':
		
		/*ステータスをpre_procへ移行*/
		updateStatus($userID, 'pre_proc');
		
		if($message == 'はい'){
			$post_data = textMessage($reply_token, '経路データを申請しました。');
		}else if($message == 'いいえ'){
			$post_data = textMessage($reply_token, '申請をキャンセルしました。');
		}else{
			$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
			updateStatus($userID, 'aplly_confirm');
		}
		
		break;
		
	/****************************************************************
	[経路データ削除処理中]
	
	del_inp_num :ユーザーが削除するデータを選択している状態。
	del_confirm :ユーザーが削除内容の確認を行っている状態。
	
	****************************************************************/
	
	case 'del_inp_num':/*incomp*/
		
		updateStatus($userID, 'del_confirm');
		$post_data = FlexTemplate($reply_token, '以上のデータを削除しますか？', '削除データ確認');
		
		break;
	case 'del_confirm':/*incomp*/
		
		updateStatus($userID, 'pre_proc');
		
		if($message == 'はい'){
			$post_data = textMessage($reply_token, '経路データを削除しました。');
		}else if($message == 'いいえ'){
			$post_data = textMessage($reply_token, '削除をキャンセルしました。');
		}else{
			$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
			updateStatus($userID, 'del_confirm');
		}
		
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

?>

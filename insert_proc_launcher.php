<?php

function pre_proc_func($userID, $message, $reply_token){

	/*経路データ登録へ*/
	updateStatus($userID, 'ins_inp_office');
	$post_data = textMessage($reply_token, '行先（会社名）を入力してください。');
	
	return $post_data;

}
/********************************/
function ins_inp_office_func($userID, $message, $reply_token){

	/*行先入力を受け付ける*/
	
	
	updateStatus($userID, 'ins_sel_claim');
	
	/*ユーザー請求可否選択を要求*/
	$post_data = confirmTemplate($reply_token, '申請運賃をユーザー請求で登録しますか？', 'ユーザー請求', '自社請求');

	return $post_data;

}
/*******************************/
function ins_sel_claim_func($userID, $message, $reply_token){

	/*ユーザー請求可否選択を受け付ける*/
	
	updateStatus($userID, 'ins_sel_rounds');
	
	/*往復の有無選択を要求*/
	$post_data = confirmTemplate($reply_token, '申請運賃を往復で登録しますか？', '往復', '片道');	
	
	return $post_data;

}
/*******************************/
function ins_sel_rounds_func($userID, $message, $reply_token){

	updateStatus($userID, 'ins_inp_others');
	
	/*備考の入力選択を要求*/
	$post_data = textMessage($reply_token, '備考があれば入力してください。');
	
	return $post_data;

}
/*******************************/
function ins_inp_others_func($userID, $message, $reply_token, $post_data){

	updateStatus($userID, 'ins_sel_confirm');
	
	/*内容確認を要求*/
	$post_data = FlexTemplate($reply_token, '以上の内容で登録しますか？', '内容確認');
			
	
	return $post_data;

}
/*******************************/
function ins_sel_confirm_func($userID, $message, $reply_token){

	updateStatus($userID, 'pre_proc');
	
	if($message == 'はい'){
		$post_data = textMessage($reply_token, '経路データを登録しました。');
	}else if($message == 'いいえ'){
		$post_data = textMessage($reply_token, '登録をキャンセルしました。');
	}else{
		$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
		updateStatus($userID, 'ins_sel_confirm');
	}
	
	return $post_data;

}
/********************************/

?>
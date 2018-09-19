<?php

function del_inp_num_func($userID, $message, $reply_token){

	updateStatus($userID, 'del_confirm');
	$post_data = FlexTemplate($reply_token, '以上のデータを削除しますか？', '削除データ確認');
	
	return $post_data;

}
/********************************/
function del_confirm_func($userID, $message, $reply_token){

	updateStatus($userID, 'pre_proc');
		
	if($message == 'はい'){
		$post_data = textMessage($reply_token, '経路データを削除しました。');
	}else if($message == 'いいえ'){
		$post_data = textMessage($reply_token, '削除をキャンセルしました。');
	}else{
		$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
		updateStatus($userID, 'del_confirm');
	}

	return $post_data;

}
/********************************/
function aplly_confirm_func($userID, $message, $reply_token){

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
	return $post_data;

}

?>
<?php

function del_inp_num_func($userID, $message, $reply_token){

	updateDeleteNoTemp($userID, $message);
	
	if(getRoute($userID, $message) != NULL){
		$post_data = DeleteRouteFlexTemplate($reply_token, '以上のデータを削除しますか？', '削除データ確認', $userID, $message);
		updateStatus($userID, 'del_confirm');
	}else{
		$post_data = textMessage($reply_token, '入力された番号に該当するデータは、存在しません。');
		updateStatus($userID, 'pre_proc');
	}
	
	return $post_data;

}
/********************************/
function del_confirm_func($userID, $message, $reply_token){
		
	if($message == 'はい'){
		
		/*データの削除*/
		$RouteNo = getDeleteNoTemp($userID);
		deleteRouteData($userID, $RouteNo);
		
		/*既存データの登録No再割り当て*/
		resetRouteNo($userID);
		
		$post_data = textMessage($reply_token, '経路データを削除しました。');
		
		/*一時記憶DBの個人行削除*/
		deleteTempData($userID);
		
	}else if($message == 'いいえ'){
		$post_data = textMessage($reply_token, '削除をキャンセルしました。');
				
		/*一時記憶DBの個人行削除*/
		deleteTempData($userID);
		
	}else{
		$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
		updateStatus($userID, 'del_confirm');
	}

	return $post_data;

}
/********************************/
function aplly_confirm_func($userID, $message, $reply_token){

	
	if($message == 'はい'){
	
		applyRouteData($userID);
	
		$post_data = textMessage($reply_token, '経路データを申請しました。');
		
		/*一時記憶DBの個人行削除*/
		deleteTempData($userID);
		
	}else if($message == 'いいえ'){
		$post_data = textMessage($reply_token, '申請をキャンセルしました。');
				
		/*一時記憶DBの個人行削除*/
		deleteTempData($userID);
		
	}else{
		$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
		updateStatus($userID, 'aplly_confirm');
	}
	return $post_data;

}

?>
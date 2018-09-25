<?php

/*機能メニュー画面の選択によって、所定の処理を行う。*/
function menu_func($userID, $message, $reply_token){

	/*機能メニュー画面にて’申請’を選択*/
	if($message == '申請'){
		
		if(getRoute($userID, 1) != NULL){
			/*申請確認画面呼び出し*/
			$post_data = ApplyFlexTemplate($reply_token, $userID);
			/*ステータスをaplly_confirmへ移行*/
			updateStatus($userID, 'aplly_confirm');
		}else{
			$post_data = textMessage($reply_token, '申請できる経路データがありません。');
			updateStatus($userID, 'pre_proc');
		}
		
	/*機能メニュー画面にて’一件削除’を選択*/
	}else if($message == '一件削除'){
	
		if(getRoute($userID, 1) != NULL){
			updateStatus($userID, 'del_inp_num');
			$post_data = textMessage($reply_token, '削除する経路データの番号を入力してください。');
		}else{
			$post_data = textMessage($reply_token, '登録されているデータはありません。');
			updateStatus($userID, 'pre_proc');		
		}
	
	/*機能メニュー画面にて’キャンセル’を選択*/
	}else if($message == 'キャンセル'){
	
		$post_data = textMessage($reply_token, 'キャンセルしました。');
				
		/*一時記憶DBの個人行削除*/
		deleteTempData($userID);
		
			
	/*そのほかの想定外入力*/
	}else{
	
		$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
		
	}
	return $post_data;
}
?>

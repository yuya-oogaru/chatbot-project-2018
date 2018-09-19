<?php

function insert_proc_launcher($userID, $message, $reply_token, $post_data){

	
	
	
	return;

}

function menu_proc_launcher($userID, $message, $reply_token, $post_data){

	/*機能メニュー画面呼び出し*/
	$post_data = MenuListFlexTemplate($reply_token);
	
	/*ステータスをmenuへ移行*/
	updateStatus($userID, 'menu');
	
	return $post_data;

}

function delete_proc_launcher($userID, $message, $reply_token, $post_data){


	return;
}

function apply_proc_launcher($userID, $message, $reply_token, $post_data){

	/*申請確認画面呼び出し*/
	$post_data = ApplyFlexTemplate($reply_token);
	
	/*ステータスをaplly_confirmへ移行*/
	updateStatus($userID, 'aplly_confirm');
	
	return $post_data;
}

?>
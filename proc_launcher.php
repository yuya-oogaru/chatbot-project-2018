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


	return;
}

?>
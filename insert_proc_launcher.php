<?php
/*              insert_proc_launcher.php
*
*       
*
*
*
*
*
*
*   *それぞれの処理内容については、基本設計書を参照
**********************************************************/


/****************ジョルダンデータ読み取り*****************/
function pre_proc_func($userID, $message, $reply_token){

	/*データ格納変数*/
	$routes = 'default'; /*経路（文字列）*/
	$date = 'default';   /*乗車日（文字列）*/
	$price = '0';        /*合計運賃（整数）*/

	/*ジョルダンから経路データ読み取り*/
	GetRouteData($message, $routes, $date, $price);
	
	updateStatus($userID, 'ins_inp_office');
	
	/*一時記憶DBにデータを登録*/
	updateDateTemp($userID, $routes);
	updateRouteTemp($userID, $date);
	updatePriceTemp($userID, $price);
	
	$post_data = textMessage($reply_token, '行先（会社名）を入力してください。');
	
	return $post_data;

}
/***************行先（社名）入力*****************/
function ins_inp_office_func($userID, $message, $reply_token){

	updateStatus($userID, 'ins_sel_claim');
	
	/*一時記憶DBにデータを登録*/
	updateDestinationTemp($userID, $message);
	
	/*ユーザー請求可否選択を要求*/
	$post_data = confirmTemplate($reply_token, '申請運賃をユーザー請求で登録しますか？', 'ユーザー請求', '自社請求');

	return $post_data;

}
/**************ユーザー請求可否選択*****************/
function ins_sel_claim_func($userID, $message, $reply_token){
	
	updateStatus($userID, 'ins_sel_rounds');
	
	$price = getPriceTemp($userID);
	
	/*一時記憶DBにデータを登録
	if($message == 'ユーザー請求'){
		updateUserPriceTemp($userID, $price);
	}else if($message == '自社請求')｛
		//$price = 0;
		updateUserPriceTemp($userID, $price);
	}else{
		//$price = 0;
		updateUserPriceTemp($userID, $price);
	}*/
	
	/*往復の有無選択を要求*/
	$post_data = confirmTemplate($reply_token, '申請運賃を往復で登録しますか？', '往復', '片道');	
	
	return $post_data;

}
/***************往復の有無選択****************/
function ins_sel_rounds_func($userID, $message, $reply_token){

	updateStatus($userID, 'ins_inp_others');
	
	/*一時記憶DBにデータを登録*/
	if($message == '往復'){
		updateRoundsTemp($userID, 1);
		
		/*合計運賃を倍に*/
		updatePriceTemp($userID, (getPriceTemp($userID) *2));
		
	}else if($message == '片道')｛
		updateRoundsTemp($userID, 000);
	}else{
		updateRoundsTemp($userID, 666);
	}
	
	/*備考の入力選択を要求*/
	$post_data = textMessage($reply_token, '備考があれば入力してください。（なければ’なし’と入力します。）');
	
	return $post_data;

}
/***************備考入力****************/
function ins_inp_others_func($userID, $message, $reply_token, $post_data){

	updateStatus($userID, 'ins_sel_confirm');
	
	/*一時記憶DBにデータを登録*/
	updateCommentsTemp($userID, $message)
	
	/*内容確認を要求*/
	$post_data = FlexTemplate($reply_token, '以上の内容で登録しますか？', '内容確認');
			
	
	return $post_data;

}
/***************全入力情報表示・入力情報確定選択****************/
function ins_sel_confirm_func($userID, $message, $reply_token){

	updateStatus($userID, 'pre_proc');
	
	/*登録を許可する（確認画面にて'はい'押下）*/
	if($message == 'はい'){
		$post_data = textMessage($reply_token, '経路データを登録しました。');
		
	/*登録を許可しない（確認画面にて'いいえ'押下）*/
	}else if($message == 'いいえ'){
		$post_data = textMessage($reply_token, '登録をキャンセルしました。');
		
	/*そのほかの想定外入力*/
	}else{
		$post_data = textMessage($reply_token, 'メッセージ内の選択肢ボタンから選んでください。');
		updateStatus($userID, 'ins_sel_confirm');
	}
	
	return $post_data;

}
/********************************/

?>
<?php
function testSelection($reply_msg, $message_tempemp, $reply_token_temp){
	switch($message_tempemp){
	case '請求':
		$reply_msg = confirmTemplate($reply_token_temp, '申請運賃をユーザー請求で登録しますか？', '請求あり', '請求なし'); /*確認テンプレート*/
		break;
	case '往復':
		$reply_msg = confirmTemplate($reply_token_temp, '申請運賃を往復で登録しますか？', '往復', '片道'); /*確認テンプレート*/
		break;
	case '登録':
		$reply_msg = FlexTemplate($reply_token_temp);    /*Flexメッセージ*/
		break;
	case '申請':
		$reply_msg = ApplyFlexTemplate($reply_token_temp);    /* 申請内容確認メッセージ*/
		break;
	case 'メニュー':
		$reply_msg = MenuListFlexTemplate($reply_token_temp);    /*メニューFlexメッセージ*/
		break;
	default :
		$reply_msg = textMessage($reply_token_temp, $message_tempemp);     /*テキストメッセージ*/
		break;
	}
	
	return $reply_msg;
}


?>
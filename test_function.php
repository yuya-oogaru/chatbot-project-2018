<?php
function testSelection($post_data){
	switch($message){
	case '請求':
		$post_data = confirmTemplate($reply_token, '申請運賃をユーザー請求で登録しますか？', '請求あり', '請求なし'); /*確認テンプレート*/
		break;
	case '往復':
		$post_data = confirmTemplate($reply_token, '申請運賃を往復で登録しますか？', '往復', '片道'); /*確認テンプレート*/
		break;
	case '登録':
		$post_data = FlexTemplate($reply_token);    /*Flexメッセージ*/
		break;
	case '申請':
		$post_data = ApplyFlexTemplate($reply_token);    /* 申請内容確認メッセージ*/
		break;
	case 'メニュー':
		$post_data = MenuListFlexTemplate($reply_token);    /*メニューFlexメッセージ*/
		break;
	default :
		$post_data = textMessage($reply_token, $message);     /*テキストメッセージ*/
		break;
	}
	
	return $post_data;
}


?>
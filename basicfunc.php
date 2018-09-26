<?php

/*データベース接続クラス*/

class dbConnection{
	// インスタンス
	protected static $db;
	// コンストラクタ
	private function __construct() {
		try {
			// 環境変数からデータベースへの接続情報を取得し
			$url = parse_url(getenv('DATABASE_URL'));
			// データソース
			$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
			// 接続を確立
			self::$db = new PDO($dsn, $url['user'], $url['pass']);
			// エラー時例外を投げるように設定
			self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $e) {
			error_log('Connection Error: ' . $e->getMessage());
		}
	}

	// シングルトン。存在しない場合のみインスタンス化
	public static function getConnection() {
		if (!self::$db) {
			new dbConnection();
		}
		return self::$db;
	}
}
/****************応答メッセージ送信*******************/
function sendReplyMessage($post_data, $access_token){
	//curlを使用してメッセージを返信する
	$ch = curl_init("https://api.line.me/v2/bot/message/reply");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json; charser=UTF-8',
	    'Authorization: Bearer ' . $access_token
	));
	$result = curl_exec($ch);
	curl_close($ch);
}
/****************メッセージの種類判断********************/
function checkMessageType($json_obj){
	
	/**********************************************
	          メッセージ種類判断用変数
		
	**各変数には、判断結果が格納される**
	
	・肯定的判定 : TRUE
	・否定的判定 : FALSE
		
	$androidJorudan : ジョルダン経路検索結果（android版）
	$iosJorudan     : ジョルダン経路検索結果（iOS版）
	$textMessage    : ユーザー入力のテキストメッセージ
	
	**呼び出し元に返される判断結果は以下の通り**
	
	・'androidJorudan' = メッセージは、ジョルダン経路検索結果（android版）
	・'iosJorudan'     = メッセージは、ジョルダン経路検索結果（iOS版）
	・'textMessage'    = メッセージは、ユーザー入力のテキストメッセージ
	・'unsupported'    = Botで動作をサポートしていない形式
	
	**********************************************/
	
	/*JSONからメッセージタイプ取得*/
	$messageType = $json_obj->{"events"}[0]->{"message"}->{"type"};
	/*JSONからメッセージ取得*/
	$message = $json_obj->{"events"}[0]->{"message"}->{"text"};
	
	/*ジョルダンメッセージ（android版）*/
	if((mb_strpos($message, 'ジョルダン乗換案内', 4, "UTF-8") != FALSE)&&
		(mb_strpos($message, '詳しい結果はコチラ', 4, "UTF-8") != FALSE)){
		
		$androidJorudan = TRUE;
	}else{
	
		$androidJorudan = FALSE;
	}
	
	/*ジョルダンメッセージ（iOS版）*/
	if((mb_strpos($message, 'ジョルダン乗換案内', 4, "UTF-8") != FALSE)&&
		(mb_strpos($message, '詳しい結果はコチラ', 4, "UTF-8") == FALSE)){
		
		$iosJorudan = TRUE;
	}else{
	
		$iosJorudan = FALSE;
	}
	
	/*ユーザー入力のテキストメッセージ*/
	if((mb_strpos($message, 'ジョルダン乗換案内', 4, "UTF-8") == FALSE)&&
		($messageType == 'text')){
		
		$textMessage = TRUE;
	}else{
	
		$textMessage = FALSE;
	}	
	
	/*****************判断結果送信*******************/
	
	if($androidJorudan == TRUE){
		return 'androidJorudan';
	}elseif($iosJorudan == TRUE){
		return 'iosJorudan';
	}elseif($textMessage == TRUE){
		return 'textMessage';
	}else{
		return 'unsupported';
	}
}
?>

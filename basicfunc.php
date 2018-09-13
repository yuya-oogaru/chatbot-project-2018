<?php
/******メッセージランチャ******/
function replyMultiMessage($bot, $replyToken, ...$msgs) {
	// MultiMessageBuilderをインスタンス化
	$builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
	// ビルダーにメッセージを全て追加
	foreach($msgs as $value) {
		$builder->add($value);
	}
	$response = $bot->replyMessage($replyToken, $builder);
	
	if (!$response->isSucceeded()) {
		error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
	}
}

// Confirmテンプレートを返信。引数はLINEBot、返信先、代替テキスト、
// 本文、アクション(可変長引数)
function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {
  $actionArray = array();
  foreach($actions as $value) {
    array_push($actionArray, $value);
  }
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
    $alternativeText,
    // Confirmテンプレートの引数はテキスト、アクションの配列
    new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder ($text, $actionArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

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



?>

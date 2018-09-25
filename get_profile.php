<?php
function getLineUserName($void){

	// Composerでインストールしたライブラリを一括読み込み
	require_once __DIR__ . '/vendor/autoload.php';

	// 送られて来たJSONデータを取得
	$json_string = file_get_contents('php://input');
	$json = json_decode($json_string);
	
	// アクセストークンを使いCurlHTTPClientをインスタンス化
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
	// CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
	
	$response = $json->events[0]->source->userId;
	$profile = $bot->getProfile($response)->getJSONDecodedBody();
	
	return $profile['displayName'];
}
?>

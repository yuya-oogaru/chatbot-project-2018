<?php
http_response_code(200) ;
echo '200 {}';

// HTTPヘッダーを取得
$headers = getallheaders();
// HTTPヘッダーから、署名検証用データを取得
$headerSignature = $headers["X-Line-Signature"];
// 送られて来たJSONデータを取得
$json_string = file_get_contents('php://input');
$json = json_decode($json_string);

// Channel secretを秘密鍵として、JSONデータからハッシュ値を計算
$channelSecret = 'メモした Channel Secret の文字列';
$httpRequestBody = $json_string;
$hash = hash_hmac('sha256', $httpRequestBody, $channelSecret, true);
$signature = base64_encode($hash);
// HTTPヘッダーから得た値と、計算したハッシュ値を比較
if($headerSignature !== $signature)
{
	return;
}

if($json->events[0]->type !== 'message')
{
	return;
}
// JSONデータから返信先を取得
$replyToken = $json->events[0]->replyToken;
// JSONデータからメッセージを取得
$message = $json->events[0]->message->text;

// HTTPヘッダを設定
$channelToken = getenv('CHANNEL_ACCESS_TOKEN');
$headers = [
	'Authorization: Bearer ' . $channelToken,
	'Content-Type: application/json; charset=utf-8',
];

// POSTデータを設定してJSONにエンコード
$post = [
	'replyToken' => $replyToken,
	'messages' => [
		[
			'type' => 'text',
			'text' => $message,
		],
	],
];
$post = json_encode($post);

// HTTPリクエストを設定
$ch = curl_init('https://api.line.me/v2/bot/message/reply');
$options = [
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_HTTPHEADER => $headers,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_BINARYTRANSFER => true,
	CURLOPT_HEADER => true,
	CURLOPT_POSTFIELDS => $post,
];

// 実行
curl_setopt_array($ch, $options);

// エラーチェック
$result = curl_exec($ch);
$errno = curl_errno($ch);
if ($errno) {
	return;
}

// HTTPステータスを取得
$info = curl_getinfo($ch);
$httpStatus = $info['http_code'];

$responseHeaderSize = $info['header_size'];
$body = substr($result, $responseHeaderSize);

// 200 だったら OK
echo $httpStatus . ' ' . $body;

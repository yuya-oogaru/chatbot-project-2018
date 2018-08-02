<?php
require_once __DIR__ . '/vendor/autoload.php';

$jsonString = file_get_contents('php://input');
error_log($jsonString);
$jsonObj = json_decode($jsonString);


// 取得メッセージと送り返す先の指定
$message = $jsonObj->{"events"}[0]->{"message"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
$messages =  $message->{"text"}

$messageData = [
'type' => 'text',
'text' => "送信したメッセージ : $messages"
];

// 返送情報の作成と送信
$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData,$messageData2]  // 複数送信時は、ここを増やすこと
];

?>


<?php
 
require_once __DIR__ . '/messageTemplate.php';

 
$access_token = getenv('CHANNEL_ACCESS_TOKEN');


//APIから送信されてきたイベントオブジェクトを取得
$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);
 
//イベントオブジェクトから必要な情報を抽出
$message = $json_obj->{"events"}[0]->{"message"};
$reply_token = $json_obj->{"events"}[0]->{"replyToken"};
/*
$post_data = [
	"replyToken" => $reply_token,
	"messages" => [
	  [
  		"type" => "template",
  		"altText" => "this is a confirm template",
  		"template" => [
			"type" => "confirm",
     	 	"text" => "Are you sure?",
     	 	"actions" => [
     	    	[
            		"type" => "message",
            		"label" => "Yes",
            		"text" => "yes"
          		],
          		[
           		 	"type" => "message",
            		"label" => "No",
            		"text" => "no"
          		]
      		]
  		]
  	  ]
  	]
];*/
/*************************************************/
$post_data = confirmTemplate($reply_token);
/*************************************************/
//curlを使用してメッセージを返信する
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $access_token
));
$result = curl_exec($ch);
curl_close($ch);

?>

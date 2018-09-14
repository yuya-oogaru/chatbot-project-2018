<?php
//**********おうむ返しテキスト************
function textMessage($reply_token, $text){

//$response_text = responseText(1);
//error_log('response = '.json_encode($response_text).'');

return
[
	"replyToken" => $reply_token,
	"messages" => 	[
		[
			"type" => "text",
			"text" => $text
		],
		[
			"type" => "sticker",
			"packageId" => 1,
			"stickerId" => 1
		]
	]
];

}
//***********確認テンプレート*************
function confirmTemplate($reply_token){

$action = confirmTemplateAction(1);
error_log('action = '.json_encode($action).'');

return
[
	"replyToken" => $reply_token,
	"messages" => [
	 	[
			"type" => "template",
			"altText" => "this is a confirm template",
			"template" => [
				"type" => "confirm",
				"text" => "Are you sure?",
				"actions" => $action
			]
		]
	]
];

}
//確認アクションコンテンツ
function confirmTemplateAction($void){

return
[
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
];

}

//**********Flexテンプレート*************
function FlexTemplate($reply_token){

//$bubble = FlexTemplateBubble(1);
//error_log('bubble = '.json_encode($bubble).'');

return
[
	"replyToken" => $reply_token,
	"messages" => [
		[
			"type" => "flex",
			"altText" => "test",
			"contents" => FlexTemplateBubble(1)
		]
	]
];

}
//Flexバブル
function FlexTemplateBubble($void){

//$content = FlexTemplateContents(1);
//error_log('contents = '.json_encode($content).'');

return
[
	"type" => "bubble",
	"body" => [
    	"type" => "box",
    	"layout" => "vertical",
    	"contents" => FlexTemplateContents(1)
    ]
];

}
//Flexコンテンツ
function FlexTemplateContents($void){

//error_log('subContents = '.json_encode($subContent).'');

return
[
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => FlexTemplateContentsSub(1)
	]
];

}
//Flexサブコンテンツ
function FlexTemplateContentsSub($void){

return
[
	[
		"type" => "text",
		"text" => "内容確認",
		"weight" => "bold",
		"size" => "xxl",
		"margin" => "md"
	]
];

}
?>

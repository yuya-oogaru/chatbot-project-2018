<?php
//**********�����ޕԂ��e�L�X�g************
function textMessage($reply_token, $text){

return
[
	"replyToken" => $reply_token,
	"messages" => [
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
//***********�m�F�e���v���[�g*************
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
//�m�F�A�N�V�����R���e���c
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
//**********�{�^���e���v���[�g***********
function buttonTemplate($reply_token){

$action = buttonTemplateAction(1);
error_log('action = '.json_encode($action).'');

return
[
	"replyToken" => $reply_token,
	"messages" => [
		[
			"type" => "template",
			"altText" => "this is a button template",
			"template" => [
				"type" => "buttons",
				"text" => "test template",
				"actions" => $action
			]
		]
	]
];

}

function buttonTemplateAction($void){

return
[
	[
		"type" => "message",
		"label" => "a",
		"text" => "a"
	],
	[
		"type" => "message",
		"label" => "b",
		"text" => "b"
	],
	[
		"type" => "message",
		"label" => "c",
		"text" => "c"
	]
];

}
//**********Flex�e���v���[�g*************
function FlexTemplate($reply_token){

$bubble = FlexTemplateBubble(1);
error_log('bubble = '.json_encode($bubble).'');

return
[
	"replyToken" => $reply_token,
	"messages" => [
		[
			"type" => "flex",
			"altText" => "test",
			"contents" => $bubble
		]
	]
];

}
//Flex�o�u��
function FlexTemplateBubble($void){

$content = FlexTemplateContents(1);
error_log('contents = '.json_encode($content).'');

return
[
	"type" => "bubble",
	"body" => [
    	"type" => "box",
    	"layout" => "vertical",
    	"contents" => $content
    ]
];

}
//Flex�R���e���c
function FlexTemplateContents($void){

$subContent = FlexTemplateContentsSub(1);
error_log('subContents = '.json_encode($subContent).'');

return
[
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => $subContent
	]
];

}
//Flex�T�u�R���e���c
function FlexTemplateContentsSub($void){

return
[
	[
		"type" => "text",
		"text" => "���e�m�F",
		"weight" => "bold",
		"size" => "xxl",
		"margin" => "md"
	]
];

}
?>

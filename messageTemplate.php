<?php
//**********おうむ返しテキスト************
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
//**********ボタンテンプレート***********
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
//**********Flexテンプレート*************
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
//Flexバブル
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
//Flexコンテンツ
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
	],
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => [
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('乗車日', '9/20')
        	],
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('行先', 'OO精工株式会社')
        	],
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('経路', '京橋～天王寺')
        	],
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('往復の有無', 'あり')
        	],
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('合計運賃', '180円')
        	],
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('ユーザー請求額', '180円')
        	],
        	[
        		"type": "box",
				"layout": "horizontal",
				"contents": FlexTemplateContentsSubBox('備考', '往復有')
        	],
        	[
       			 "type" => "separator",
       			 "margin" => "md"
			]
        ]
	],
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => [
        	[
        		"type" => "text",
				"text" => "以上の内容で登録しますか？",
				"size" => "xxl",
				"color" => "#111111",
				"align" => "center"
        	],
        	[
            	"type": "button",
            	"height": "md",
            	"style": "primary",
            	"action": [
					"type" => "message",
					"label" => "はい",
					"text" => "はいが押された。"
              	]
        	],
        	[
            	"type": "button",
            	"height": "md",
            	"style": "secondary",
            	"action": [
					"type" => "message",
					"label" => "いいえ",
					"text" => "いいえが押された。"
              	]
        	]
        ]
	]
];

}
//Flexサブコンテンツ（項目）
function FlexTemplateContentsSubBox($column,$value){

return
[
	[
		"type" => "text",
		"text" => $column,
		"size" => "xxs",
		"color" => "#0000ff",
		"flex" => 0
	],
	[
		"type" => "text",
		"text" => $value,
		"size" => "xs",
		"color" => "#111111",
		"align" => "end"
	]
];

}
//Flexサブコンテンツ（タイトル）
function FlexTemplateContentsSub($void){

return
[
	[
		"type" => "text",
		"text" => "内容確認",
		"weight" => "bold",
		"size" => "xxl",
		"margin" => "md"
	],
	[
        "type" => "separator",
        "margin" => "md"
	]
];

}
?>

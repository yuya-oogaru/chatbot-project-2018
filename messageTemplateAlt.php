<?php
//**********Flexテンプレート*************
function FlexTemplate($reply_token){


return
[
	"replyToken" => $reply_token,
	"messages" => [
		[
			"type" => "flex",
			"altText" => "test",
			"contents" => [
				"type" => "bubble",
				"body" => [
    				"type" => "box",
    				"layout" => "vertical",
    				"contents" => FlexTemplateContents(1)
    			]
			]
		]
	]
];

}

//Flexコンテンツ
function FlexTemplateContents($void){

return
[
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => FlexTemplateContentsSub('内容確認')
	],
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => FlexTemplateContentsBuilder(1)
	],
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => FlexTemplateContentsSubButton('以上の内容を登録しますか？')
	]
];

}
//Flexサブコンテンツビルダ
function FlexTemplateContentsBuilder($void){


for($count = 0; $count < 10; $count++){
	$contents[] = FlexTemplateContentsSubBox('テスト', 'テスト');
}

error_log('contents = '.json_encode($contents).'');
return $contents;

}
//Flexサブコンテンツ（項目）
function FlexTemplateContentsSubBox($column,$value){

return
[
	"type"=> "box",
	"layout"=> "horizontal",
	"contents"=> [
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
		]
	]
];

}
//Flexサブコンテンツ（タイトル）
function FlexTemplateContentsSub($title){

return
[
	[
		"type" => "text",
		"text" => $title,
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
//Flexサブコンテンツ（ボタン）
function FlexTemplateContentsSubButton($text){

return
[
	[
		"type" => "text",
		"text" => $text,
		"size" => "md",
		"color" => "#111111",
		"align" => "center"
	],
	[
		"type"=> "button",
		"height"=> "md",
		"style"=> "primary",
		"action"=> [
			"type" => "message",
			"label" => "はい",
			"text" => "はいが押された。"
		]
    ],
    [
		"type"=> "button",
		"height"=> "md",
		"style"=> "secondary",
		"action"=> [
			"type" => "message",
			"label" => "いいえ",
			"text" => "いいえが押された。"
		]
	]
];

}
?>

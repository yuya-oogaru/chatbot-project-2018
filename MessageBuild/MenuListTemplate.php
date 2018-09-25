<?php
//**********Flexテンプレート*************
function MenuListFlexTemplate($reply_token, $userID){

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
    					"contents" => MenuListFlexTemplateContents($userID)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function MenuListFlexTemplateContents($userID){

	return
	[
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => FlexTemplateContentsTitle('機能メニュー')
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => DataListContentsBuilder($userID)
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => MenuListFlexTemplateButton('呼び出す機能を選択してください')
		]
	];
}

//Flexサブコンテンツ（ボタン）
function MenuListFlexTemplateButton($text){

	return
	[
		[
			"type" => "text",
			"text" => $text,
			"size" => "xs",
			"color" => "#111111",
			"align" => "center"
		],
    	[
			"type"=> "button",
			"height"=> "md",
			"style"=> "secondary",
			"action"=> [
				"type" => "message",
				"label" => "一件削除",
				"text" => "一件削除"
			]
		],
		[
			"type"=> "button",
			"height"=> "md",
			"style"=> "primary",
			"action"=> [
				"type" => "message",
				"label" => "申請",
				"text" => "申請"
			]
    	],
    	[
			"type"=> "button",
			"height"=> "md",
			"style"=> "secondary",
			"action"=> [
				"type" => "message",
				"label" => "キャンセル",
				"text" => "キャンセル"
			]
		]
	];
}

?>

<?php
//**********Flexテンプレート*************
function DataListFlexTemplate($reply_token){

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
    					"contents" => DataListFlexTemplateContents(1)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function DataListFlexTemplateContents($void){

	return
	[
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => FlexTemplateContentsSub('申請内容確認')
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => DataListFlexTemplateContentsBuilder(10)
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => FlexTemplateContentsSubButton('以上の内容を申請しますか？')
		]
	];
}
//Flexサブコンテンツ（項目）ビルダ
function DataListFlexTemplateContentsBuilder($loop){


	/*サブコンテンツ（項目）配列を指定回数分連結*/
	for($count = 0; $count < $loop; $count++){
		$contents[] = DataListFlexTemplateContentsSubBox('9/1', '株式会社OO','大阪～京橋','仮復','9,99円');
	}

	error_log('contents = '.json_encode($contents).'');
	return $contents;
}
//Flexサブコンテンツ（項目）
function DataListFlexTemplateContentsSubBox($date, $destination, $route, $icon ,$price){

	return
	[
		"type"=> "box",
		"layout"=> "horizontal",
		"contents"=> [
			[
				"type" => "text",
				"text" => $date,
				"size" => "xxs",
				"color" => "#555555",
				"flex" => 0
			],
			[
				"type" => "text",
				"text" => $destination,
				"size" => "xxs",
				"color" => "#555555",
				"flex" => 0
			],
			[
				"type" => "text",
				"text" => $route,
				"size" => "xxs",
				"color" => "#555555",
				"flex" => 0
			],
			[
				"type" => "text",
				"text" => $icon,
				"size" => "xxs",
				"color" => "#ff0000",
				"flex" => 0
			],
			[
				"type" => "text",
				"text" => $price,
				"size" => "xxs",
				"color" => "#111111",
				"align" => "end"
			]
		]
	];

}
?>

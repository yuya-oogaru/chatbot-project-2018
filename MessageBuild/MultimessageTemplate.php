<?php
//**********Flexテンプレート*************
function MultiFlexTemplate($reply_token){

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
    					"contents" => MultiFlexTemplateContents(1)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function MultiFlexTemplateContents($void){

	return
	[
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => FlexTemplateContentsTitle('内容確認')
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => MultiFlexTemplateContentsBuilder(10)
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
//Flexサブコンテンツ（項目）ビルダ
function MultiFlexTemplateContentsBuilder($loop){


	/*サブコンテンツ（項目）配列を指定回数分連結*/
	for($count = 0; $count < $loop; $count++){
		$contents[] = MultiFlexTemplateContentsSubBox('ループ', $count.'回');
	}

	//セパレータ
	$contents[] = array("type" => "separator","margin" => "md");
	
	error_log('contents = '.json_encode($contents).'');
	return $contents;
}
//Flexサブコンテンツ（項目）
function MultiFlexTemplateContentsSubBox($column,$value){

	return
	[
		"type"=> "box",
		"layout"=> "horizontal",
		"contents"=> [
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
	];

}
?>

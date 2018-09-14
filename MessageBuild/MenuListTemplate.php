<?php
//**********Flexテンプレート*************
function MenuListFlexTemplate($reply_token){

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
    					"contents" => MenuListFlexTemplateContents(1)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function MenuListFlexTemplateContents($void){

	return
	[
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => FlexTemplateContentsSub('機能メニュー')
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => MenuListFlexTemplateContentsBuilder(10)
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
//Flexサブコンテンツ（項目）ビルダ
function MenuListFlexTemplateContentsBuilder($loop){

	//リスト名表示
	$contents[] = array("type" => "text","text" => "登録済み経路一覧","weight"=>"bold","color"=>"#00a100","size"=>"md","margin"=>"md");
	
	/*サブコンテンツ（項目）配列を指定回数分連結*/
	for($count = 0; $count < $loop; $count++){
		$contents[] = DataListFlexTemplateContentsSubBox('9/1.', '株式会社OO.','大阪～京橋.','仮復.','9,999円');
	}
	
	//セパレータ
	$contents[] = array("type" => "separator","margin" => "md");
	
	error_log('contents = '.json_encode($contents).'');
	return $contents;
}
//Flexサブコンテンツ（ボタン）
function MenuListFlexTemplateButton($text){

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
			"style"=> "secondary",
			"action"=> [
				"type" => "message",
				"label" => "一件削除",
				"text" => "一件削除が押された。"
			]
		],
		[
			"type"=> "button",
			"height"=> "md",
			"style"=> "primary",
			"action"=> [
				"type" => "message",
				"label" => "申請",
				"text" => "申請が押された。"
			]
    	],
    	[
			"type"=> "button",
			"height"=> "md",
			"style"=> "secondary",
			"action"=> [
				"type" => "message",
				"label" => "キャンセル",
				"text" => "キャンセルが押された。"
			]
		]
	];
}
?>

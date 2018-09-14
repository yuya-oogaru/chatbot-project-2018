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

	//リスト名表示
	$contents[] = array("type" => "text","text" => "登録済み経路一覧","weight"=>"bold","color"=>"#00a100","size"=>"md","margin"=>"md");

	/*サブコンテンツ（項目）配列を指定回数分連結*/
	for($count = 0; $count < $loop; $count++){
		$contents[] = DataListFlexTemplateContentsSubBox($count,'9/1.', '株式会社OO.','大阪～京橋.','仮復.','9,999円');
	}

	//合計金額
	$contents[] = array("type"=>"text","text"=>"----------","size"=>"md","color"=>"#000000","align"=>"end");
	$contents[] = array("type"=>"text","text"=>"999,999,999円","size"=>"md","color"=>"#0000ff","align"=>"end");
	
	//セパレータ
	$contents[] = array("type" => "separator","margin" => "md");
	
	error_log('contents = '.json_encode($contents).'');
	return $contents;
}
//Flexサブコンテンツ（項目）
function DataListFlexTemplateContentsSubBox($no, $date, $destination, $route, $icon ,$price){

	//登録Noから経路までを結合
	$margeText = '['.($no + 1).']'.$date.''.$destination.''.$route.'';

	return
	[
		"type"=> "box",
		"layout"=> "horizontal",
		"contents"=> [
			[
				"type" => "text",
				"text" => $margeText,
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

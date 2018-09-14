/*******************************************************
         申請内容確認メッセージテンプレート





以下のfunctionは、それぞれFlexメッセージ表示用のJsonデータ構築に用います。

○function ApplyFlexTemplate($reply_token)

	:申請確認画面用Flexメッセージ構築用。
	申請確認画面を表示する際は、この関数を呼び出してください。

○function ApplyFlexTemplateContents($void)

	:申請確認画面用Flexメッセージを構成する
	各コンテンツを構築します。コンテンツは以下の通り構成されます。
 
	・タイトルコンテンツ （コンテンツ構築関数(外部) FlexTemplateContentsTitle）
	・項目コンテンツ     （コンテンツ構築関数 DataListFlexTemplateContentsBuilder）
	・ボタンコンテンツ   （コンテンツ構築関数（外部） FlexTemplateContentsSubButton）
 

○function DataListContentsBuilder($loop)

	:項目コンテンツ構築に用います。
	引数には、表示する項目数を与えてください。
	
○function DataListSubContents($no, $date, $destination, $route, $icon ,$price)

	:項目コンテンツを構成する、各項目を構築します。
	一回の関数呼び出しにつき、１項目構築します。
	引数にはそれぞれ以下の値を与えてください。
	
	・$no          :登録no
	・$date        :乗車日
	・$destination :行先
	・$route       :経路
	・$icon        :仮払い・往復の有無
	・$price       :合計運賃
	

********************************************************/
<?php
//**********Flexテンプレート*************
function ApplyFlexTemplate($reply_token){

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
    					"contents" => ApplyFlexTemplateContents(1)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function ApplyFlexTemplateContents($void){

	return
	[
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => FlexTemplateContentsTitle('申請内容確認')
		],
		[
			"type" => "box",
        	"layout" => "vertical",
        	"margin" => "xxl",
        	"spacing" => "sm",
        	"contents" => DataListContentsBuilder(10)
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

/*ToDo以下ファイル分け検討*/
//Flexサブコンテンツ（項目）ビルダ
function DataListContentsBuilder($loop){

	//リスト名表示
	$contents[] = array("type" => "text","text" => "登録済み経路一覧","weight"=>"bold","color"=>"#00a100","size"=>"md","margin"=>"md");

	/*サブコンテンツ（項目）配列を指定回数分連結*/
	for($count = 0; $count < $loop; $count++){
		$contents[] = DataLisSubContents($count,'9/1.', '株式会社OO.','大阪～京橋.','仮復.','9,999円');
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
function DataLisSubContents($no, $date, $destination, $route, $icon ,$price){

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

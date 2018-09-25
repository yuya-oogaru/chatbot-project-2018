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
function ApplyFlexTemplate($reply_token, $userID){

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
    					"contents" => ApplyFlexTemplateContents($userID)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function ApplyFlexTemplateContents($userID){

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
        	"contents" => DataListContentsBuilder($userID)
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
function DataListContentsBuilder($userID){

	//リスト名表示
	$contents[] = array("type" => "text","text" => "登録済み経路一覧","weight"=>"bold","color"=>"#00a100","size"=>"md","margin"=>"md");
	
	/*カウンタ変数・略号変数初期化*/
	$counter = 1;
	$icon = '　';
	$textColor = "#555555";
	

	/*登録済みのデータをすべて取得*/
	while($counter < getRouteDataCount($userID)){
	
		/*データベースから値を取得*/
		$routeno = getRouteNo($userID, $counter);         /*登録No*/
		$date = getRouteDate($userID, $counter);          /*乗車日*/
		$routes = getRoute($userID, $counter);            /*経路*/
		$price = getPrice($userID, $counter);             /*合計運賃*/
		$destination = getDestination($userID, $counter); /*行先*/
		$rounds = getRounds($userID, $counter);           /*往復の有無*/
		$userPrice = getUserPrice($userID, $counter);     /*ユーザー請求*/
		
		/*取得している登録Noが欠番の場合*/
		if($routeno == NULL){
			$counter++;
			continue;
		}
		
		/*ユーザー請求・往復の有無を略号に変換（メニュー選択機能の設計書を参照）*/
		if($userPrice > 0){
			$icon = $icon.'仮';
		}
		if($rounds == 1){
			$icon = $icon.'復';
		}
		
		/*申請済みデータは赤く塗る*/
		if(getApplyFlag($userID, $routeno) == 1){
			$textColor = "#ff0000";
		}
		
		$contents[] = DataLisSubContents($routeno, $date.'.', $destination.'.', $routes.'.', $icon, $price, $textColor);
		
		/*次のループに備えて変数調整*/
		$counter++;
		$icon = '　';
		$textColor = "#555555";
	}
	
	//合計金額算出
	$totalPrice = calcTotalPrice($userID);
	//文字列に変換
	$totalPrice = '￥'.number_format(strval($totalPrice));

	//合計金額
	$contents[] = array("type"=>"text","text"=>"----------","size"=>"md","color"=>"#000000","align"=>"end");
	$contents[] = array("type"=>"text","text"=>$totalPrice,"size"=>"md","color"=>"#0000ff","align"=>"end");
	
	//セパレータ
	$contents[] = array("type" => "separator","margin" => "md");
	
	error_log('contents = '.json_encode($contents).'');
	return $contents;
}

//Flexサブコンテンツ（項目）
function DataLisSubContents($no, $date, $destination, $route, $icon ,$price, $textColor){

	//登録Noから経路までを結合
	$margeText = '['.($no).']'.$date.''.$destination.''.$route.'';

	return
	[
		"type"=> "box",
		"layout"=> "horizontal",
		"contents"=> [
			[
				"type" => "text",
				"text" => $margeText,
				"size" => "xxs",
				"color" => $textColor,
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
				"text" => ('￥'.number_format(strval($price))),
				"size" => "xxs",
				"color" => $textColor,
				"align" => "end"
			]
		]
	];

}
?>

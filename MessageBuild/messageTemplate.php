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
			]
		]
	];
}
//***********確認テンプレート*************
//引数 = リプライトークン、確認メッセージの本文、選択肢文（肯定）、選択肢文（否定）＊ToDo後でちゃんと清書すること。

function confirmTemplate($reply_token, $confirmText, $yes, $no){

	$action = confirmTemplateAction($yes, $no);
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
					"text" => $confirmText,
					"actions" => $action
				]
			]
		]
	];
}
//確認アクションコンテンツ
function confirmTemplateAction($yes, $no){

	return
	[
		[
			"type" => "message",
			"label" => $yes,
			"text" => $yes
		],
	    [
			"type" => "message",
			"label" => $no,
			"text" => $no
		]
	];
}

//**********Flexテンプレート(経路データ削除)*************
function DeleteRouteFlexTemplate($reply_token, $message_text, $title, $userID, $RouteNo){


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
    					"contents" => DeleteRouteFlexTemplateContents($message_text, $title, $userID, $RouteNo)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ
function DeleteRouteFlexTemplateContents($message_text, $title, $userID, $RouteNo){

	/*一時記憶データベースから、データ取得*/
	
	$date = getRouteDate($userID, $RouteNo);         /*乗車日*/
	$routes = getRoute($userID, $RouteNo);           /*経路*/
	$price = getPrice($userID, $RouteNo);            /*合計運賃*/
	$destination = getDestination($userID, $RouteNo);/*行先*/
	$rounds = getRounds($userID, $RouteNo);          /*往復の有無*/
	$userPrice = getUserPrice($userID, $RouteNo);    /*ユーザー請求*/
	$comments = getComments($userID, $RouteNo);     /*備考*/
	
	if($rounds == 1){
		$rounds = 'あり';
	}else{
		$rounds = 'なし';
	}
	
	return
	[
		[
			"type" => "box",
	        "layout" => "vertical",
	        "margin" => "xxl",
	        "spacing" => "sm",
	        "contents" => FlexTemplateContentsTitle($title)
		],
		[
			"type" => "box",
	        "layout" => "vertical",
	        "margin" => "xxl",
	        "spacing" => "sm",
	        "contents" => [
	        	[
	        		"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('乗車日', strval($date))
	        	],
   		     	[
   		     		"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('行先', strval($destination))
    	    	],
    	    	[
    	    		"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('経路', strval($routes))
       	 		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('往復の有無', strval($rounds))
        		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('合計運賃', '￥'.number_format(strval($price)))
        		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('ユーザー請求額', '￥'.number_format(strval($userPrice)))
        		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('備考', strval($comments))
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
    	    "contents" => FlexTemplateContentsSubButton($message_text)
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
function FlexTemplateContentsTitle($title){

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
			"size" => "sm",
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
				"text" => "はい"
			]
    	],
    	[
			"type"=> "button",
			"height"=> "md",
			"style"=> "secondary",
			"action"=> [
				"type" => "message",
				"label" => "いいえ",
				"text" => "いいえ"
			]
		]
	];
}

//**********Flexテンプレート(登録確認専用)*************
function insertConfirmFlexTemplate($reply_token, $message_text, $title, $userID){

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
    					"contents" => insertConfirmFlexTemplateContents($message_text, $title, $userID)
    				]
				]
			]
		]
	];
}

//Flexコンテンツ(登録確認専用)
function insertConfirmFlexTemplateContents($message_text, $title, $userID){
	
	/*一時記憶データベースから、データ取得*/
	
	$date = getDateTemp($userID);              /*乗車日*/
	$routes = getRouteTemp($userID);           /*経路*/
	$price = getPriceTemp($userID);            /*合計運賃*/
	$destination = getDestinationTemp($userID);/*行先*/
	$rounds = getRoundsTemp($userID);          /*往復の有無*/
	$userPrice = getUserPriceTemp($userID);    /*ユーザー請求*/
	$comments = getCommentsTemp($userID);      /*備考*/
	
	if($rounds == 1){
		$rounds = 'あり';
	}else{
		$rounds = 'なし';
	}
	
	return
	[
		[
			"type" => "box",
	        "layout" => "vertical",
	        "margin" => "xxl",
	        "spacing" => "sm",
	        "contents" => FlexTemplateContentsTitle($title)
		],
		[
			"type" => "box",
	        "layout" => "vertical",
	        "margin" => "xxl",
	        "spacing" => "sm",
	        "contents" => [
	        	[
	        		"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('乗車日', strval($date))
	        	],
   		     	[
   		     		"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('行先', strval($destination))
    	    	],
    	    	[
    	    		"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('経路', strval($routes))
       	 		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('往復の有無', strval($rounds))
        		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('合計運賃', '￥'.number_format(strval($price)))
        		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('ユーザー請求額', '￥'.number_format(strval($userPrice)))
        		],
        		[
        			"type"=> "box",
					"layout"=> "horizontal",
					"contents"=> FlexTemplateContentsSubBox('備考', strval($comments))
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
    	    "contents" => FlexTemplateContentsSubButton($message_text)
		]
	];
}
?>

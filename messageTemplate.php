<?php

//確認テンプレート
function confirmTemplate($reply_token){

return [
	"replyToken" => $reply_token,
	"messages" => [
	  [
  		"type" => "template",
  		"altText" => "this is a confirm template",
  		"template" => [
			"type" => "confirm",
     	 	"text" => "Are you sure?",
     	 	"actions" => [
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
      		]
  		]
  	  ]
  	]
];

return $confirm;

}
//Flexテンプレート
function FlexTemplate($reply_token){

$flexmsg = [
	"replyToken" => $reply_token,
	"messages" => [
		[
			"type" => "flex",
			"altText" => "test",
			"contents" => []
		]
	]
];

error_log('fxTemp = '.json_encode($flexmsg).'');

return $flexmsg;

}
//Flexバブル
function FlexTemplateBubble($void){

return[
];

}
//Flexコンテンツ
function FlexTemplateContents($void){

return[
	[
	],
	[
	],
];

}

?>

<?php

//�m�F�e���v���[�g
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
//Flex�e���v���[�g
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
//Flex�o�u��
function FlexTemplateBubble($void){

return[
];

}
//Flex�R���e���c
function FlexTemplateContents($void){

return[
	[
	],
	[
	],
];

}

?>

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

$bubble = FlexTemplateBubble(1);
error_log('bubble = '.json_encode($bubble).'');

return
[
	"replyToken" => $reply_token,
	"messages" => [
		[
			"type" => "flex",
			"altText" => "test",
			"contents" => $bubble
		]
	]
];

}
//Flex�o�u��
function FlexTemplateBubble($void){

$content = FlexTemplateContents(1);
error_log('contents = '.json_encode($content).'');

return
[
	"type" => "bubble",
	"styles" => [
    	"footer" => [
    		"separator" => true
    	]
  	],
	"body" => [
    	"type" => "box",
    	"layout" => "vertical",
    	"contents" => $content
    ]
];

}
//Flex�R���e���c
function FlexTemplateContents($void){

return
[
	[
		"type" => "box",
        "layout" => "vertical",
        "margin" => "xxl",
        "spacing" => "sm",
        "contents" => [
        	[
        		"type" => "text",
            	"text" => "���e�m�F",
            	"weight" => "bold",
            	"size" => "xxl",
            	"margin" => "md"
        	],
        	[
        		"type" => "separator",
            	"margin" => "md"
        	]
		]
	]
];

}

?>

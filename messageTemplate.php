<?php

//�m�F�e���v���[�g
function confirmTemplate($reply_token){

error_log('reply_token = '.$reply_token.'');

$confirm = [
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

error_log('cfTemp = '.$confirm.'');

return $confirm;

}
//Flex�e���v���[�g
function FlexTemplate($reply_token){

error_log('reply_token = '.$reply_token.'');

$flex = [
	"replyToken" => $reply_token,
	"messages" => [
	[
		"type" => "flex",
		"altText" => "test",
		"contents" => [
			"type"=> "bubble",
			"styles"=> [
				"footer"=> [
					"separator"=> true
				]
  			],
  			"body"=> [
				"type"=> "box",
    			"layout"=> "vertical",
    			"contents"=> [
      				[
        				"type"=> "box",
        				"layout"=> "vertical",
        				"margin"=> "xxl",
        				"spacing"=> "sm",
        				"contents"=> [
          					[
            					"type"=> "text",
            					"text"=> "���e�m�F",
            					"weight"=> "bold",
            					"size"=> "xxl",
            					"margin"=> "md"
          					],
          					[
            					"type"=> "separator",
            					"margin"=> "md"
          					]
        				]
      				],
      				[
        				"type"=> "box",
        				"layout"=> "vertical",
        				"margin"=> "xxl",
        				"spacing"=> "sm",
        				"contents"=> [
          					[
            					"type"=> "box",
            					"layout"=> "horizontal",
            					"contents"=> [
              						[
                						"type"=> "text",
                						"text"=> "��ԓ�",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "9/20",
                						"size"=> "xs",
                						"color"=> "#111111",
                						"align"=> "end"
              						]
            					]
          					],
          					[
            					"type"=> "box",
            					"layout"=> "horizontal",
            					"contents"=> [
              						[
                						"type"=> "text",
                						"text"=> "�s��",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "OO���H�������",
                						"size"=> "xs",
                						"color"=> "#111111",
                						"align"=> "end"
              						]
            					]
          					],
          					[
            					"type"=> "box",
            					"layout"=> "horizontal",
            					"contents"=> [
              						[
                						"type"=> "text",
                						"text"=> "�o�H",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "���`�V����",
                						"size"=> "xs",
                						"color"=> "#111111",
                						"align"=> "end"
              						]
            					]
          					],
          					[
            					"type"=> "box",
            					"layout"=> "horizontal",
            					"contents"=> [
              						[
                						"type"=> "text",
                						"text"=> "���v�^��",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "140�~",
                						"size"=> "xs",
                						"color"=> "#111111",
                						"align"=> "end"
              						]
            					]
          					],
          					[
            					"type"=> "box",
            					"layout"=> "horizontal",
            					"contents"=> [
              						[
                						"type"=> "text",
                						"text"=> "���l",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "����",
                						"size"=> "xs",
                						"color"=> "#111111",
                						"align"=> "end"
              						]
            					]
          					],
          					[
            					"type"=> "separator",
            					"margin"=> "md"
          					]
        				]
      				],
      				[
        				"type"=> "box",
        				"layout"=> "vertical",
        				"margin"=> "xxl",
        				"spacing"=> "sm",
        				"contents"=> [
          					[
            					"type"=> "text",
            					"text"=> "�ȏ�̓��e�œo�^���܂����H",
            					"size"=> "md",
            					"color"=> "#111111",
            					"align"=> "center"
          					],
          					[
            					"type"=> "button",
           						"height"=> "md",
            					"style"=> "primary",
            					"action"=> [
           							"type"=> "uri",
              						"label"=> "�͂�",
              						"uri"=> "https://example.com"
            					]
          					],
          					[
            					"type"=> "button",
            					"height"=> "md",
            					"style"=> "secondary",
            					"action"=> [
              						"type"=> "uri",
              						"label"=> "������",
              						"uri"=> "https://example.com"
            					]
          					]
        				]
      				]
    			]
  			]
		]
	]
	]
];

error_log('fxTemp = '.json_encode($flex).'');

return $flex;

}
?>


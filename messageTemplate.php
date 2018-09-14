<?php

//確認テンプレート
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
//Flexテンプレート
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
            					"text"=> "内容確認",
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
                						"text"=> "乗車日",
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
                						"text"=> "行先",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "OO精工株式会社",
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
                						"text"=> "経路",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "大阪～天王寺",
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
                						"text"=> "合計運賃",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "140円",
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
                						"text"=> "備考",
                						"size"=> "xxs",
                						"color"=> "#0000ff",
                						"flex"=> 0
              						],
              						[
                						"type"=> "text",
                						"text"=> "往復",
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
            					"text"=> "以上の内容で登録しますか？",
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
              						"label"=> "はい",
              						"uri"=> "https://example.com"
            					]
          					],
          					[
            					"type"=> "button",
            					"height"=> "md",
            					"style"=> "secondary",
            					"action"=> [
              						"type"=> "uri",
              						"label"=> "いいえ",
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


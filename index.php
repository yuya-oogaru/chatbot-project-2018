/**************************************************************
*           ** LINE TEST BOT Project(2018/08/03)**
*
*
*                      �e�X�g�v���O�����I�I
*                      �{�ԂŎg�p���Ȃ�����
*
*
*************************************************************/

<?php

// Composer�ŃC���X�g�[���������C�u�������ꊇ�ǂݍ���
require_once __DIR__ . '/vendor/autoload.php';

// �����ė���JSON�f�[�^���擾
$json_string = file_get_contents('php://input');
error_log(file_get_contents('php://input'));
$json = json_decode($json_string);

/****�����F��****/

// �A�N�Z�X�g�[�N�����g��CurlHTTPClient���C���X�^���X��
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
// CurlHTTPClient�ƃV�[�N���b�g���g��LINEBot���C���X�^���X��
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
// LINE Messaging API�����N�G�X�g�ɕt�^�����������擾
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
// �������������`�F�b�N�B�����ł���΃��N�G�X�g���p�[�X���z���
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

/****************/

/*��M���b�Z�[�W���o*/
$getMessage = $json->events[0]->message->text;


/*���v���C�g�[�N���i�ԐM�ؖ��j�擾*/
$replyToken = $json->events[0]->replyToken;

/*�W�����_���̃��b�Z�[�W���ǂ������f*/
$startPos = mb_strpos($getMessage, '--------------------');

/*�K�v���̒��o*/
$routeNamePos = strpos($getMessage, '  ');
//$transitTimePos = mb_strpos($getMessage, '�@');

$preSendMessage = 'default text';
/*�ԐM*/
if($startPos != 'false'){
	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($startPos),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('���͂��ꂽ�o�H��['. substr($getMessage, 0, $routeNamePos). ']�ł��B'),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('���t��['. substr($getMessage, $routeNamePos, 12). ']�ł��B'),
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('�抷�񐔂�['. substr($getMessage, $transitTimePos, 12). ']�ł��B')
			//new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('�^�����v��['. substr($getMessage, ($transitTimePos + 12), 12). ']�ł��B')
		);
	}
}else{
	/*���b�Z�[�W�ɑ΂��ĕԐM��ς���*/
	switch($getMessage){
		case '�e�X�g':
			$preSendMessage = '�e�X�g�����I';
			$stickerType = 114;
			break;
		case '��y':
			$preSendMessage = '�̑�ȊJ���҂̖��O';
			$stickerType = 119;
			break;
		case '���邳��':
			return;
		default :
			$preSendMessage = $json->events[0]->message->text;
			$stickerType = 113;
			break;
	}

	foreach ($events as $event) {
		replyMultiMessage($bot, $replyToken, 
			new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($preSendMessage)
			//new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, $stickerType)
		);
	}
}

/******���b�Z�[�W�����`��******/
function replyMultiMessage($bot, $replyToken, ...$msgs) {
  // MultiMessageBuilder���C���X�^���X��
  $builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
  // �r���_�[�Ƀ��b�Z�[�W��S�Ēǉ�
  foreach($msgs as $value) {
    $builder->add($value);
  }
  $response = $bot->replyMessage($replyToken, $builder);
	
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

?>

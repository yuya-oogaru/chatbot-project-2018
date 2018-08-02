<?php

//composer�ŃC���X�g�[���������C�u�����ǂݍ���
require_onec__DIR__ . '/vendor/autoload.php';

// �A�N�Z�X�g�[�N�����g��CurlHTTPClient���C���X�^���X��
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
// CurlHTTPClient�ƃV�[�N���b�g���g��LINEBot���C���X�^���X��
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
// LINE Messaging API�����N�G�X�g�ɕt�^�����������擾
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

// �������������`�F�b�N�B�����ł���΃��N�G�X�g���p�[�X���z���
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
// �z��Ɋi�[���ꂽ�e�C�x���g�����[�v�ŏ���
foreach ($events as $event) {
	$bot->replyText($event->getReplyToken(), 'TextMessage');
	}
?>

<?php
require_once __DIR__ . '/vendor/autoload.php';

$jsonString = file_get_contents('php://input');
error_log($jsonString);
$jsonObj = json_decode($jsonString);


// �擾���b�Z�[�W�Ƒ���Ԃ���̎w��
$message = $jsonObj->{"events"}[0]->{"message"};
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
$messages =  $message->{"text"}

$messageData = [
'type' => 'text',
'text' => "���M�������b�Z�[�W : $messages"
];

// �ԑ����̍쐬�Ƒ��M
$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData,$messageData2]  // �������M���́A�����𑝂₷����
];

?>

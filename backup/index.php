<?php

//composer�ŃC���X�g�[���������C�u�����ǂݍ��� 
require_onec__DIR__ . '/vendor/autoload.php';

$inputString = file_get_contents('php://input');
error_log($inputString);

?>

<?php

/*�W�����_���t�H�[�}�b�g�̌o�H�f�[�^���擾*/
function GetRouteData($message, &$routes, &$Date, &$price){

	/*******************************
	$routeEndPos      :�o�H�̋L�q�ӏ��i�����j
	$dateEndPos        :��ԓ��̋L�q�ӏ��i�����j
	$transitTimePos    :�抷�񐔂̋L�q�ӏ��i�擪�j*$totalPricePos�����ʒu�擾�̂��߂̂ݎg�p
	$totalPricePos     :�^�����v�̋L�q�ӏ��i�擪�j
	$totalPriceEndPos  :�^�����v�̋L�q�ӏ��i�����j
	********************************/
	
	$routeEndPos = mb_strpos($message, ' ',1 , "UTF-8");
	$dateEndPos = mb_strpos($message, ')',$routeNamePos , "UTF-8");
	$transitTimePos = mb_strpos($message, '�抷', 1, "UTF-8");
	$totalPricePos = mb_strpos($message, '�@', $transitTimePos, "UTF-8");
	$totalPricePos += 1;/*�ςł���*/
	$totalPriceEndPos = mb_strpos($message, '�~', $totalPricePos, "UTF-8");

	/*�o�H�擾*/
	$routes = mb_substr($message, 0, $routeEndPos, "UTF-8");

	/*��ԓ��擾*/
	$Date = mb_substr($message, ($routeEndPos + 1), (($dateEndPos - $routeEndPos) + 1), "UTF-8");

	/*���v�^���擾*/
	$price = mb_substr($message, $totalPricePos, ($totalPriceEndPos - $totalPricePos), "UTF-8");

}


?>

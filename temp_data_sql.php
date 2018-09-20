<?php
//define('LINE_STATUS');

/***************************************************/
/*                  �ꎞ�f�[�^�X�V                 */
/***************************************************/

/************************��ԓ�*********************/
function updateDateTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUTEDATE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/************************�o�H**********************/
function updateRouteTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUTE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
	
}
/*********************���v�^��*********************/
function updatePriceTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET PRICE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
	
}
/************************�s��**********************/
function updateDestinationTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET DESTINATION_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/********************�����̗L��********************/
function updateRoundsTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUNDS_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/****************���[�U�[������******************/
function updateUserPriceTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET USERPRICE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/************************���l**********************/
function updateCommentsTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET COMMENTS_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/************************�폜No**********************/
function updateDeleteNoTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET DELETENO = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/**************************************************/
?>

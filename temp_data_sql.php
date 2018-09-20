<?php
//define('LINE_STATUS');

/***************************************************/
/*                  êf[^XV                 */
/***************************************************/

/************************æÔú*********************/
function updateDateTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUTEDATE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/************************oH**********************/
function updateRouteTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUTE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
	
}
/*********************v^À*********************/
function updatePriceTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET PRICE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
	
}
/************************sæ**********************/
function updateDestinationTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET DESTINATION_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/********************ÌL³********************/
function updateRoundsTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUNDS_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/****************[U[¿ÂÛ******************/
function updateUserPriceTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET USERPRICE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/************************õl**********************/
function updateCommentsTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET COMMENTS_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/************************íNo**********************/
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

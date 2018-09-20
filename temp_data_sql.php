<?php
//define('LINE_STATUS');

/***************************************************/
/*                  一時データ更新                 */
/***************************************************/

/************************乗車日*********************/
function updateDateTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUTEDATE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/************************経路**********************/
function updateRouteTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUTE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
	
}
/*********************合計運賃*********************/
function updatePriceTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET PRICE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
	
}
/************************行先**********************/
function updateDestinationTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET DESTINATION_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/********************往復の有無********************/
function updateRoundsTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET ROUNDS_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/****************ユーザー請求可否******************/
function updateUserPriceTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET USERPRICE_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/************************備考**********************/
function updateCommentsTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET COMMENTS_TEMP = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_STR);
	
	$sth->execute();
}
/************************削除No**********************/
function updateDeleteNoTemp($userID, $tempValue){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET DELETENO = :tempValue WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':tempValue', $tempValue, PDO::PARAM_INT);
	
	$sth->execute();
}
/**************************************************/

/*****一時記憶中の合計運賃を確認*****/
function getPriceTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT PRICE_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
?>

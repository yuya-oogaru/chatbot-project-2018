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
	
	/*金額につく','を省いて登録します。*/
	$sth->bindValue(':tempValue', (intval(str_replace(',', '', $tempValue))), PDO::PARAM_INT);
	
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

/***************************************************/
/*                  一時データ取得                 */
/***************************************************/


/************************乗車日*********************/
function getDateTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUTEDATE_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************経路**********************/
function getRouteTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUTE_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/*********************合計運賃*********************/
function getPriceTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT PRICE_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************行先**********************/
function getDestinationTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  DESTINATION_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/********************往復の有無********************/
function getRoundsTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUNDS_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/****************ユーザー請求可否******************/
function getUserPriceTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  USERPRICE_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************備考**********************/
function getCommentsTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  COMMENTS_TEMP FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************削除No**********************/
function getDeleteNoTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  DELETENO FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/**************************************************/

/***************************************************/
/*                  一時データ全削除               */
/***************************************************/

function deleteTempData($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'DELETE FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
}

?>

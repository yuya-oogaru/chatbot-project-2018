<?php
//define('LINE_ROUTES_TR');

/***************************************************/
/*                  登録データ取得                 */
/***************************************************/

/*以下関数の引数: (ユーザーID, 確認する登録No)*/

/************************登録No*********************/
function getRouteNo($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUTENO FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/************************乗車日*********************/
function getRouteDate($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUTEDATE FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************経路**********************/
function getRoute($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUTE FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/*********************合計運賃*********************/
function getPrice($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT PRICE FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************行先**********************/
function getDestination($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  DESTINATION FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/********************往復の有無********************/
function getRounds($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  ROUNDS FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/****************ユーザー請求可否******************/
function getUserPrice($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  USERPRICE FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************備考**********************/
function getComments($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  COMMENTS FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************申請フラグ**********************/
function getApplyFlag($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT APPLY FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/************************削除No**********************/
function getDeleteNo($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  DELETENO FROM LINE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
	
}
/***************************************************/
/*                  登録データ更新                 */
/***************************************************/

/******登録Noを更新する*******/
function updateRouteNo($userID, $oldno, $newno){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_ROUTES_TR SET ROUTENO = :newno WHERE userID = :userID AND routeno = :oldno';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':newno', $newno, PDO::PARAM_INT);
	$sth->bindValue(':oldno', $oldno, PDO::PARAM_INT);
	
	$sth->execute();
}

?>

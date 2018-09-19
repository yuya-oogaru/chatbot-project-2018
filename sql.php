<?php
//define('LINE_STATUS');

/******ステータス更新*******/
function updateStatus($userID, $status){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET status = :status WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':status', $status, PDO::PARAM_STR);
	
	$sth->execute();
}
/******temp更新*******/
function updateTemp($userID, $temp){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET tempData = :temp WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':temp', $temp, PDO::PARAM_STR);
	
	$sth->execute();
}
/*****すてーたす*****/
function searchStatus($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT status FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*****temp*****/
function searchTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT tempdata FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*****DBに既存データがあるかどうか*****/
function searchUserID($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT userID FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*******ＤＢにユーザーステータスを追加する関数*******/

function registerUser($userID, $status, $tempData){
	$dbh = dbConnection::getConnection();
	$sql = 'insert into LINE_STATUS (userID, status) values (:userID, :status)';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*登録者ID（ラインアカウントID）*/
	$sth->bindValue(':status', $status, PDO::PARAM_STR);            /*状態*/
	//$sth->bindValue(':tempData', $tempData, PDO::PARAM_STR);        /*一時データ*/
	
	$sth->execute();
}
?>

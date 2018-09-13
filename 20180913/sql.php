<?php

/******ステータス更新*******/
function updateStatus($userID, $status){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE status SET status = :status WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':status', $status, PDO::PARAM_STR);
	
	$sth->execute();
}
/******temp更新*******/
function updateTemp($userID, $temp){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE status SET tempData = :temp WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':temp', $temp, PDO::PARAM_STR);
	
	$sth->execute();
}
/*****すてーたす*****/
function searchStatus($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT status FROM status WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*****temp*****/
function searchTemp($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT tempdata FROM status WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*****DBに既存データがあるかどうか*****/
function searchUserID($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT userID FROM status WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*******ＤＢにユーザーステータスを追加する関数*******/

function registerUser($userID, $status, $tempData){
	$dbh = dbConnection::getConnection();
	$sql = 'insert into status (userID, status, tempData) values (:userID, :status, :tempData)';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*登録者ID（ラインアカウントID）*/
	$sth->bindValue(':status', $status, PDO::PARAM_STR);            /*状態*/
	$sth->bindValue(':tempData', $tempData, PDO::PARAM_STR);        /*一時データ*/
	
	$sth->execute();
}
?>

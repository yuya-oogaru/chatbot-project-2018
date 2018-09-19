<?php
//define('LINE_STATUS');

/******�X�e�[�^�X�X�V*******/
function updateStatus($userID, $status){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET status = :status WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':status', $status, PDO::PARAM_STR);
	
	$sth->execute();
}
/******temp�X�V*******/
function updateTemp($userID, $temp){

	$dbh = dbConnection::getConnection();
	$sql = 'UPDATE LINE_STATUS SET tempData = :temp WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':temp', $temp, PDO::PARAM_STR);
	
	$sth->execute();
}
/*****���ā[����*****/
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
/*****DB�Ɋ����f�[�^�����邩�ǂ���*****/
function searchUserID($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT userID FROM LINE_STATUS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}
/*******�c�a�Ƀ��[�U�[�X�e�[�^�X��ǉ�����֐�*******/

function registerUser($userID, $status, $tempData){
	$dbh = dbConnection::getConnection();
	$sql = 'insert into LINE_STATUS (userID, status) values (:userID, :status)';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*�o�^��ID�i���C���A�J�E���gID�j*/
	$sth->bindValue(':status', $status, PDO::PARAM_STR);            /*���*/
	//$sth->bindValue(':tempData', $tempData, PDO::PARAM_STR);        /*�ꎞ�f�[�^*/
	
	$sth->execute();
}
?>

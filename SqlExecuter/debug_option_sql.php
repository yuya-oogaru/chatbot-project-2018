<?php

/******選択されたデータを削除する******/
function deleteRouteData($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'DELETE FROM LINE_ROUTES_TR WHERE userID = :userID';
	$sth = $dbh->prepare($sql);

	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);

	$sth->execute();
}

?>

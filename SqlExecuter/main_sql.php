<?php

/***************************************************************
                   DB操作SQL実行処理関数（メイン）


経路データとインサート先テーブルおよびカラム
---------------------------+---------------+---------------------------------------------
        データ名           |  カラム名     |    インサート先テーブル名
---------------------------+---------------+---------------------------------------------
ユーザーＩＤ（LINE user ID) USERID          LINE_USERINFO_MS・LINE_ROUTES_TR・LINE_DOCS_MS
ユーザー名（LINEuser　名）  USERNAME        LINE_USERINFO_MS
登録Ｎｏ                    ROUTENO         LINE_ROUTES_TR
乗車日                      ROUTEDATE       LINE_ROUTES_TR
行先                        DESTINATION     LINE_ROUTES_TR
経路                        ROUTE           LINE_ROUTES_TR
往復の有無                  ROUNDS          LINE_ROUTES_TR
合計運賃                    PRICE           LINE_ROUTES_TR
ユーザー請求額              USERPRICE       LINE_ROUTES_TR
備考                        COMMENTS        LINE_ROUTES_TR
申請フラグ                  APPLY           LINE_ROUTES_TR
清算書ＩＤ                  DOCSID          LINE_DOCS_MS
申請日                      APPLYDATE       LINE_DOCS_MS
清算書＿最終発効日          ISSUEDATE       LINE_DOCS_MS
清算書＿管理者発効日        ADMINISSUEDATE  LINE_DOCS_MS
----------------------------------------------------------------------------------------
*LINE_USERINFO_MS・LINE_DOCS_MSに関しては、当該ユーザーの既存データがある場合、登録の必要は無し。
*登録Ｎｏは、’１’から順に数え、使用されていない最も若い数字を、新規データに割り当てること。

***************************************************************/

/*LINE_ROUTES_TRへインサート*/
function insertDataToRoutesTr($userID, 
	$routeno,
	$date, 
	$routes, 
	$price, 
	$destination, 
	$rounds, 
	$userPrice, 
	$comments
){

	$dbh = dbConnection::getConnection();
	$sql = 'insert into LINE_ROUTES_TR (userID, routeno, routedate, destination, route, rounds, price, userprice, comments, apply)'.
	'values ( :userID, :routeno, :routedate, :destination, :route, :rounds, :price, :userprice, :comments, :apply)';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*登録者ID（ラインアカウントID）*/
	$sth->bindValue(':routeno', $routeno, PDO::PARAM_INT);
	$sth->bindValue(':routedate', $date, PDO::PARAM_STR);
	$sth->bindValue(':destination', $destination, PDO::PARAM_STR);
	$sth->bindValue(':route', $routes, PDO::PARAM_STR);
	$sth->bindValue(':rounds', $rounds, PDO::PARAM_INT);
	$sth->bindValue(':price', $price, PDO::PARAM_INT);
	$sth->bindValue(':userprice', $userPrice, PDO::PARAM_INT);
	$sth->bindValue(':comments', $comments, PDO::PARAM_STR);
	$sth->bindValue(':apply', 0, PDO::PARAM_INT);
	
	$sth->execute();

}
/*LINE_USERINFO_MSへインサート（同ユーザーの既存データがある場合は、インサートしない）*/
function insertDataToUserInfoMs($userID, $username){

	$dbh = dbConnection::getConnection();
	$sql = 'insert into LINE_USERINFO_MS (userID, username) values ( :userID, :username)';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*登録者ID（ラインアカウントID）*/
	$sth->bindValue(':username', $username, PDO::PARAM_STR);

	$sth->execute();
	
}
/*LINE_USERINFO_MSにユーザーの既存データがあるかどうか確認*/
function getUserInfoMsData($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  USERID FROM LINE_USERINFO_MS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];

}
/*LINE_USERINFO_MSの割り当て済み「登録No」確認（未割当の場合はNULLを返す）*/
/*引数: (ユーザーID, 確認する登録No)*/
function getRouteNo($userID, $RouteNo){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  USERID FROM INE_ROUTES_TR WHERE userID = :userID AND routeno = :routeno';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	$sth->bindValue(':routeno', $RouteNo, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];
}

/*LINE_DOCS_MSへインサート（同ユーザーの既存データがある場合は、インサートしない）*/
function insertDataToDocsMs($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'insert into LINE_DOCS_MS (userID, docsid) values ( :userID, :docsid)';
	
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);            /*登録者ID（ラインアカウントID）*/
	$sth->bindValue(':docsid', 0, PDO::PARAM_INT);
	
	$sth->execute();

}
/*LINE_DOCS_MSにユーザーの既存データがあるかどうか確認*/
function getDocsMsData($userID){

	$dbh = dbConnection::getConnection();
	$sql = 'SELECT  USERID FROM LINE_DOCS_MS WHERE userID = :userID';
	$sth = $dbh->prepare($sql);
	
	$sth->bindValue(':userID', $userID, PDO::PARAM_INT);
	
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_NUM);
	
	return $result[0];

}

?>

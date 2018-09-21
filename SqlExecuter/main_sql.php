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
	$sql = 'insert into LINE_STATUS (userID, routeno, routedate, destination, route, rounds, price, userprice, comments, apply)'.
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



}
/*LINE_DOCS_MSへインサート（同ユーザーの既存データがある場合は、インサートしない）*/
function insertDataToDocsMs($userID){



}


?>

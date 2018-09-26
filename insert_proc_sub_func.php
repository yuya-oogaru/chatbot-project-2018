<?php

/*ジョルダンフォーマットの経路データを取得（android版）*/
function GetRouteData($message, &$routes, &$Date, &$price){

	/*******************************
	$routeEndPos      :経路の記述箇所（末尾）
	$dateEndPos        :乗車日の記述箇所（末尾）
	$transitTimePos    :乗換回数の記述箇所（先頭）*$totalPricePos検索位置取得のためのみ使用
	$totalPricePos     :運賃合計の記述箇所（先頭）
	$totalPriceEndPos  :運賃合計の記述箇所（末尾）
	********************************/
	
	$routeEndPos = mb_strpos($message, ' ',1 , "UTF-8");
	$dateEndPos = mb_strpos($message, '(', 1, "UTF-8");
	$transitTimePos = mb_strpos($message, '乗換', 1, "UTF-8");
	$totalPricePos = mb_strpos($message, '　', $transitTimePos, "UTF-8");
	$totalPricePos += 1;/*ぱでぃんぐ*/
	$totalPriceEndPos = mb_strpos($message, '円', $totalPricePos, "UTF-8");

	/*経路取得*/
	$routes = mb_substr($message, 0, $routeEndPos, "UTF-8");

	/*中継地点を省く(動作不完全)*/
	//$routes = removeTransitPoint($routes);
	
	/*乗車日取得*/
	$Date = mb_substr($message, ($routeEndPos + 1), (($dateEndPos - $routeEndPos) - 1), "UTF-8");

	/*合計運賃取得*/
	$price = mb_substr($message, $totalPricePos, ($totalPriceEndPos - $totalPricePos), "UTF-8");
}

/*ジョルダンフォーマットの経路データを取得(iOS版)*/
function GetRouteDataOniOS($message, &$routes, &$Date, &$price){

	/*******************************
	$routeEndPos      :経路の記述箇所（末尾）
	$dateEndPos        :乗車日の記述箇所（末尾）
	$transitTimePos    :乗換回数の記述箇所（先頭）*$totalPricePos検索位置取得のためのみ使用
	$totalPricePos     :運賃合計の記述箇所（先頭）
	$totalPriceEndPos  :運賃合計の記述箇所（末尾）
	********************************/
	
	$routeEndPos = mb_strpos($message, "\n",1);
	$dateEndPos = mb_strpos($message, '(', 1, "UTF-8");
	$transitTimePos = mb_strpos($message, '乗換', 1, "UTF-8");
	$totalPricePos = mb_strpos($message, '　', $transitTimePos, "UTF-8");
	$totalPricePos += 1;/*ぱでぃんぐ*/
	$totalPriceEndPos = mb_strpos($message, '円', $totalPricePos, "UTF-8");

	/*経路取得*/
	$routes = mb_substr($message, 0, $routeEndPos, "UTF-8");

	/*中継地点を省く（動作不完全）*/
	//$routes = removeTransitPoint($routes);
	
	/*乗車日取得*/
	$Date = mb_substr($message, ($routeEndPos + 1), (($dateEndPos - $routeEndPos) - 1), "UTF-8");

	/*合計運賃取得*/
	$price = mb_substr($message, $totalPricePos, ($totalPriceEndPos - $totalPricePos), "UTF-8");
}

/*入力されたデータをデータベースに登録*/
function insertRouteData($userID){

	$username = 'default name';
	/*ラインのユーザー名取得(するつもり)*/
	//$profile = $bot->getProfile($userID)->getJSONDecodedBody();
	//$username = $profile['displayName'];
	
	/*一時記憶データベースから、データ取得*/
	
	$date = getDateTemp($userID);              /*乗車日*/
	$routes = getRouteTemp($userID);           /*経路*/
	$price = getPriceTemp($userID);            /*合計運賃*/
	$destination = getDestinationTemp($userID);/*行先*/
	$rounds = getRoundsTemp($userID);          /*往復の有無*/
	$userPrice = getUserPriceTemp($userID);    /*ユーザー請求*/
	$comments = getCommentsTemp($userID);      /*備考*/
	
	
	/*経路データの登録Noを取得*/
	$routeno = getUnusedRouteNo($userID);
	
	insertDataToRoutesTr($userID, $routeno, $date, $routes, $price, $destination, $rounds, $userPrice, $comments);
	
	/**データベースLINE_DOCS_MSへの登録がない場合（初回登録時のみの操作）*/
	if(getDocsMsData($userID) == NULL){
		insertDataToDocsMs($userID);
	}

}

/*経路データの登録Noを取得する。（登録Noについては、テーブル定義書参照）*/
function getUnusedRouteNo($userID){

	$getNo = 1; /*登録No候補*/
	
	/*未割当の番号が見つかるまで繰り返す*/
	while(getRouteNo($userID, $getNo) != NULL){
		$getNo++;
	}

	/*取得した登録Noを返す*/
	return $getNo;
}

/*ジョルダンから取得した経路から中継地点を省く*/
function removeTransitPoint($routes){

	/*～は経路文字列中に必ず一つ残す*/
	$noRemoveIcon = mb_strrpos($routes, '～', "UTF-8");
	
	while(1){
		
		$removePos = mb_strpos($routes, '～', ($noRemoveIcon), "UTF-8");
		
		if($removePos != FALSE){
			$routes = substr_replace($routes, '',($noRemoveIcon), ($removePos - $noRemoveIcon));
			continue;
		}
		break;
	}
	return $routes;
}
?>

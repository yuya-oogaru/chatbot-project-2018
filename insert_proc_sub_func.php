<?php

/*ジョルダンフォーマットの経路データを取得*/
function GetRouteData($message, &$routes, &$Date, &$price){

	/*******************************
	$routeEndPos      :経路の記述箇所（末尾）
	$dateEndPos        :乗車日の記述箇所（末尾）
	$transitTimePos    :乗換回数の記述箇所（先頭）*$totalPricePos検索位置取得のためのみ使用
	$totalPricePos     :運賃合計の記述箇所（先頭）
	$totalPriceEndPos  :運賃合計の記述箇所（末尾）
	********************************/
	
	$routeEndPos = mb_strpos($message, ' ',1 , "UTF-8");
	$dateEndPos = mb_strpos($message, ')',$routeNamePos , "UTF-8");
	$transitTimePos = mb_strpos($message, '乗換', 1, "UTF-8");
	$totalPricePos = mb_strpos($message, '　', $transitTimePos, "UTF-8");
	$totalPricePos += 1;/*ぱでぃんぐ*/
	$totalPriceEndPos = mb_strpos($message, '円', $totalPricePos, "UTF-8");

	/*経路取得*/
	$routes = mb_substr($message, 0, $routeEndPos, "UTF-8");

	/*乗車日取得*/
	$Date = mb_substr($message, ($routeEndPos + 1), (($dateEndPos - $routeEndPos) + 1), "UTF-8");

	/*合計運賃取得*/
	$price = mb_substr($message, $totalPricePos, ($totalPriceEndPos - $totalPricePos), "UTF-8");
}


?>

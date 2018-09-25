<?php

/*********番号の振り直し*********/
function resetRouteNo($userID){
	
	$count = 1; /*参照回数*/
	$preCount = 1;/*割り当て番号候補*/
	
	/*登録データの総数を取得*/
	$dataCount = getRouteDataCount($userID);
	
	while($count <= $dataCount){
		
		/*登録Noのヌケがあった場合*/
		if(getRouteNo($userID, $count) == NULL){
			$count++;
			$dataCount++;
			continue;
		}
		
		/*登録Noが順になっていなかった場合*/
		if(getRouteNo($userID, $count) != $preCount){
			updateRouteNo($userID, $count, $preCount);
		}
		
		$preCount++;
		$count++;
	}
}

?>

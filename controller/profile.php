<?php
if(empty(strong::$infoUser))header("Location: index.php?p=login");
if($_GET['act']=='myorder'){
	$order = strong::loadModel("order");
	$myorder = $order->getOrder();
}
?>
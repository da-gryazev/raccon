<?
$catalog = strong::loadModel("catalog");
$idproduct = (int)$_GET['idproduct'];
$product = $catalog->getProduct(array('id'=>$idproduct));

?>
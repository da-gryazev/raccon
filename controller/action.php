<?
$id = (int)$_GET['id'];
switch($_GET['act']){
	case "addbasket":
		$basket = strong::loadModel("basket");
		$basket->addBasket($_GET['idproduct'],$_GET['amount']);
		$yes = "yes";
	break;
	
	case "findproduct":
		$catalog = strong::loadModel("catalog");
		$module_title = "slideshow_best";
		$_GET['q'] = strong::secure_query(strong::secure_message($_GET['q']));
		$data = $catalog->searchProduct(0,$_GET['q']);		
	break;
	
	case "addcatalog":
		$catalog = strong::loadModel("catalog");
		
		$title = strong::secure_query($_GET['title']);
		$price = strong::secure_query($_GET['price']);
		
		$catalog->addGoods($title,$price);
		header("Location: index.php?p=catalog&mes=add");die;
	
	break;

	case "adduserproduct":
		$m_catalog = strong::loadModel("catalog");
		$m_basket = strong::loadModel("basket");
		foreach ($_GET as $key => $value) {
			$get[$key] = strong::secure_query($value);
		}
		switch ($get['idcategory']){
				case '11':
					$profile = 0.9;
					$weight = 30;
					$img = 29;
				break;
			
				case '12':
					$profile = 1.2;
					$weight = 40;
					$img = 30;
				break;

				case '13':
					$profile = 1.6;
					$weight = 45;
					$img = 31;
				break;
		}
		$array['price'] = ($get['width']+$get['height'])*$profile;
		$array['title'] = "Подрамник ".(int)$get['width']."x".(int)$get['height'];
		$array['category'] = $get['idcategory'];

		$lastid = $m_catalog->addProductUser($array);
		$m_catalog->addProductParametrs(array('idparametr'=>1,'value'=>(int)$get['width'],'idproduct'=>$lastid,'productcategory'=>$array['category']));
		$m_catalog->addProductParametrs(array('idparametr'=>2,'value'=>(int)$get['height'],'idproduct'=>$lastid,'productcategory'=>$array['category']));
		$m_catalog->addProductParametrs(array('idparametr'=>9,'value'=>$weight,'idproduct'=>$lastid,'productcategory'=>$array['category']));
		$m_catalog->addProductParametrs(array('idparametr'=>11,'value'=>80,'idproduct'=>$lastid,'productcategory'=>$array['category']));
		$m_catalog->addProductParametrs(array('idparametr'=>10,'value'=>"Российская федерация",'idproduct'=>$lastid,'productcategory'=>$array['category']));

		$m_catalog->addProductImage($lastid,$img);
		$m_basket->addBasket($lastid,1);
		
		die(header("Location: ".$_SERVER['HTTP_REFERER']));
	break;

	case "login":
		$users = strong::loadModel("users");
		$sessionid = strong::loadModel("sessionid");
		
		$user = strong::secure_query($_POST["login"]);
		$password = md5("raccon_".strong::secure_query($_POST["password"]));//ЗАМЕНИТЬ НА SHA1
		
		$u = $users->getUser(0,$user,$password);
		if($u){
			$sessionid->addSessionId($u[0]["id"]);
			header("Location: index.php?p=index&login=success");die;
		}
		header("Location: index.php?p=login&error=enter");die;
	break;
	
	case "order":	
		foreach ($_POST as $key => $value) {
			$post[$key] = strong::secure_message($value);
		}
	break;

	case "exit":
		$sessionid = strong::loadModel("sessionid");
		$sessionid->closeSession();
		header("Location: index.php");
	break;
	
	case "deletebasket":
		$basket = strong::loadModel("basket");
		$basket->deleteBasket($id);
		die(header("Location: ".$_SERVER['HTTP_REFERER']));
	break;
	
	case "deletebaza":
		$warehouse = strong::loadModel("warehouse");
		$warehouse->deleteGoods($id);
	break;
	
	case "changeamount":
		$warehouse = strong::loadModel("warehouse");
		$good = (int)$_GET['good'];
		$amount = (int)$_GET['amount'];
		$limit = (int)$_GET['limit'];
		$warehouse->changeAmount($good,$amount);
		$warehouse->changeLimit($good,$limit);
		header("Location: index.php?p=baza");
	break;
	
	case "changestatus":
		$order = strong::loadModel("order");
		$id = (int)$_GET['id'];
		$status = (int)$_GET['status'];
		$order->changeStatus($id,$status);
	break;
	
	case "printorder":
		$order = strong::loadModel("order");
		$id = (int)$_GET['id'];
		$printord = $order->getOrder(0,0,$id);
	break;

	case "showmodule":
		$module_title 	= $_GET['module'];
		$data['idcategory'] 	= $_GET['idcategory'];
	break;
	
	case "searchcountry":
		$city = strong::loadModel("city");
		$cities = $city->getCountry($_GET['idcountry'],$_GET['qcountry']);
	break;

	case "registration":
		$m_users = strong::loadModel("users");
		if(!$m_users->getUserIsset($_POST['email'])){
			$m_users->addUser($_POST);
			header("Location: index.php?p=login&reg=1");
		}else header("Location: index.php?p=registration&error=1");

	break;

}
?>
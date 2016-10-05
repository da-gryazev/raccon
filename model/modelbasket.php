<?class modelbasket{
	private function getTable(){
		return "basket";
	}

	public function addBasket($idproduct,$amount,$table=false){
		$model = &strong::$model;

		$user = $this->getBasketId($idproduct,strong::$infoUser['id']);

		if(!$user){
			$model->insert($this->getTable(),array('idproduct'=>$idproduct,'iduser'=>strong::$infoUser['id'],'amount'=>$amount));
		}else{
		 	$model->update($this->getTable(),array("amount"=>$amount),array('idproduct'=>$idproduct,'iduser'=>strong::$infoUser['id'],'operator'=>array("AND")));
		}
	}

	public function getBasketId($idproduct,$iduser){
		$model = &strong::$model;
		if($idproduct AND $iduser){
			$exec['idproduct'] = $idproduct;
			$exec['iduser'] = $iduser;
			$exec['operator'][0] = "AND";
		} 
		return $model->select($this->getTable(),$exec);
	}

	public function getBasketUser($iduser){		
		$model = &strong::$model;
		$catalog = strong::loadModel("catalog");
		if($iduser)$exec['iduser'] = $iduser;else $exec['iduser'] = strong::$infoUser['id'];
		$return = $model->select($this->getTable(),$exec);
		for($i=0;$i<count($return);$i++){
			$return[$i]['info'] = $catalog->getProductMini(array("id"=>$return[$i]['idproduct']));
		}
		return $return;

	}
	public function getBasketUserFull($iduser){		
		$model = &strong::$model;
		$catalog = strong::loadModel("catalog");
		if($iduser)$exec['iduser'] = $iduser;
		$return = $model->select($this->getTable(),$exec);
		for($i=0;$i<count($return);$i++){
			$a = $catalog->getProductMini(array("id"=>$return[$i]['idproduct']));
			$return[$i]['info'] = $a;
		}
		return $return;

	}

	public function deleteBasket($idproduct=false){
		$model = &strong::$model;
		if(!$idproduct)$model->delete($this->getTable(),array("iduser"=>strong::$infoUser['id']));else $model->delete($this->getTable(),array("iduser"=>strong::$infoUser['id'],"idproduct"=>$idproduct,"operator"=>array("AND")));
	}

	public function sumWeight(){
		foreach (strong::$infoUser['basket'] as $key => $value) {
						$sum += $value['info'][0]['weight'];
		}
		return $sum;
	}

	//Функции с сайта http://russianpostcalc.ru/api-devel.php
	public function russianpostcalc_api_communicate($request){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://russianpostcalc.ru/api_beta_077.php");
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false)
	    {
		return "10000 server error";
	    }
	    
	    $js = json_decode($data, $assoc=true);
	    return $js;
	}

	public function russianpostcalc_api_calc($apikey, $password, $from_index, $to_index, $weight, $ob_cennost_rub){
	    $request = array("apikey"=>$apikey, 
	                        "method"=>"calc", 
	                        "from_index"=>$from_index,
	                        "to_index"=>$to_index,
	                        "weight"=>$weight,
	                        "ob_cennost_rub"=>$ob_cennost_rub
	                    );

	    if ($password != "")
	    {
	        //если пароль указан, аутентификация по методу API ключ + API пароль.
	        $all_to_md5 = $request;
	        $all_to_md5[] = $password;
	        $hash = md5(implode("|", $all_to_md5));
	        $request["hash"] = $hash;
	    }

	    $ret = $this->russianpostcalc_api_communicate($request);

	    return $ret;
	}

	public function calcSumDelivery($to_index){
		$return = $this->russianpostcalc_api_calc("c50e2a0826719602390206f33d33e1d2", "DeNi89117", "659325", $to_index, ($this->sumWeight())/1000,0);
    
	   	return $return;
	}

}?>
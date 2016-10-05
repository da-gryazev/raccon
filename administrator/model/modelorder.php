<?class modelorder{
	private function getTable(){
		return "order";
	}

	public function addOrder($exec){
		$model = &strong::$model;
		$exec['iduser'] = strong::$infoUser['id'];

		$sql = $model->insert($this->getTable(),$exec);
		
		$n = count(strong::$infoUser['basket']);

		for($i=0;$i<$n;$i++)$this->addBasketOrder($sql,strong::$infoUser['basket'][$i]['idproduct'],strong::$infoUser['basket'][$i]['amount']);

		if($sql)return true;return false;
	}

	public function getOrder($id=false){
		$model = &strong::$model;
		$city = strong::loadModel("city");
		if($id){
			$return = $model->select($this->getTable(),array('id'=>$id));
			if($return[0]['iduser']!=strong::$infoUser['id'])die("Очень не хорошо с твоей стороны это делать. Это не твой заказ идентификаторы не совпадают:(");
		}else $return = $model->select($this->getTable(),array('iduser'=>strong::$infoUser['id']));

		for($i=0;$i<count($return);$i++){
			$return[$i]['basket'] = $this->getOrderBasket($return[$i]['id']);
			$a = $city->getCountry($return[$i]['country']);
			$return[$i]['country'] = $a = $a[0];

			$a = $city->getCities($return[$i]['city']);
			$return[$i]['city'] =  $a[0];
		}
		return $return;
	}

	private function addBasketOrder($idorder,$idproduct,$amount){
		$model = &strong::$model;
		if($idorder AND $idproduct AND $amount){
			$exec['idproduct'] = $idproduct;
			$exec['idorder'] = $idorder;
			$exec['amount'] = $amount;
			$model->insert("order_basket",$exec);
		}
		
	}

	public function getOrderBasket($idorder=false){
		$model = &strong::$model;
		$catalog = strong::loadModel("catalog");
		if($idorder){
			$exec['idorder'] = $idorder;
			$return = $model->select("order_basket",$exec);
		}else{

		}
		for($i=0;$i<count($return);$i++){
			$a = $catalog->getProductMini(array('id'=>$return[$i]['idproduct']));
			$return[$i]['info'] = $a[0];
		}
		return $return;
		
	}
}?>
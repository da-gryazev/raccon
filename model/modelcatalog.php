<?class modelcatalog{
	private function getTable($value){
		return "catalog_".$value;
	}

	public function getProduct($exec=false){
		$model = &strong::$model;

		
			$return = $model->select($this->getTable("product"),$exec);
			

			for($i=0;$i<count($return);$i++){
				#$return[$i]['price'] *= 64;
				#categroy
					$a = $this->getCategoriiInfo($return[$i]['category']);
					$return[$i]['category'] = $a[0];
				#image
					$a = $this->getAllImage($return[$i]['id']);
					$return[$i]['image'] = $a[0];
				#parametrs_product
					$a = $this->getParametrsProduct($return[$i]['id']);
					$return[$i]['parametrs_product'] = $a;
				#response
					$a = $this->getResponse($return[$i]['id']);
					$return[$i]['responses'] = $a;
				#rating
					$a = $this->getRating($return[$i]['id']);
					$return[$i]['rating'] = $a;
				#basket
					$a = $this->getBasket($return[$i]['id']);
					$return[$i]['basket'] = $a;
				#weight
					$a = $this->getParametrsProduct($return[$i]['id'],0,4);
					$return[$i]['weight'] = $a;

			}

			$n = count($return);
			for($i=0;$i<$n;$i++){				
				if($return[$i]['rating'][0]['score']<$return[($i+1)]['rating'][0]['score']){
					$a = $return[$i]['rating'][0]['score'];
					$return[$i]['rating'][0]['score'] = $return[($i+1)]['rating'][0]['score'];
					$return[($i+1)]['rating'][0]['score'] = $a;
					if($i<$n)$i=0;
				}
			}
		return $return;
	}

	public function cmp($a, $b) {
		    if ($a['rating'][0]['score'] == $b['rating'][0]['score']) {
		        return 0;
		    }
		    return ($a['rating'][0]['score'] < $b['rating'][0]['score']) ? -1 : 1;
	}

	public function getProductMini($exec){
		$model = &strong::$model;
		
		if($exec) {
			$return = $model->select($this->getTable("product"),$exec);
		}
			for($i=0;$i<count($return);$i++){
				#$return[$i]['price'] *= 64;
				#categroy
					$a = $this->getCategoriiInfo($return[$i]['category']);
					$return[$i]['category'] = $a[0];
				#image
					$a = $this->getAllImage($return[$i]['id']);
					$return[$i]['image'] = $a[0];
				#basket
					$a = $this->getBasket($return[$i]['id']);
					$return[$i]['basket'] = $a;
				#weight
					$a = $this->getParametrsProduct($return[$i]['id'],0,4);
					$return[$i]['weight'] = $a[0]['value'];
				#rating
					$a = $this->getRating($return[$i]['id']);
					$return[$i]['rating'] = $a;
			}
			$n = count($return);
			for($i=0;$i<$n;$i++){				
				if($return[$i]['rating'][0]['score']<$return[($i+1)]['rating'][0]['score']){
					$a = $return[$i]['rating'][0]['score'];
					$return[$i]['rating'][0]['score'] = $return[($i+1)]['rating'][0]['score'];
					$return[($i+1)]['rating'][0]['score'] = $a;
					if($i<$n)$i=0;
				}
			}
		return $return;
	}

	public function getCategoriiInfo($id=false,$title=false,$parent=false){
		$model = @strong::$model;
		if($id) $exec['id'] = $id;
		if($title) $exec['title'] = $title;
		if($parent!==false) $exec['parent'] = $parent;
		$return = $model->select($this->getTable('categorii'),$exec);
		return $return;
	}

	private function getAllImage($idproduct){
		$model = &strong::$model;
		$image = strong::loadModel("image");
		if($idproduct) $exec['idproduct'] = $idproduct;
		$return = $model->select($this->getTable("image"),$exec);
			for($i=0;$i<count($return);$i++){
				$a = $image->getImage($return[$i]['idimage']);
				$return[$i]['info'] = $a[0];
			}
		return $return;
	}

	public function getParametrsProduct($idproduct=false,$productcategory=false,$idparametr=false){
		$model = &strong::$model;

		if($idproduct) $exec['idproduct'] = $idproduct;
		if($productcategory AND $idparametr){

			$exec['productcategory'] = $productcategory;
			$exec['idparametr'] = $idparametr;
			$exec['operator'] = array("AND");
			$return = $model->select($this->getTable("parametrs_product"),$exec);
			return $return;
		}
		if($idproduct AND $idparametr){
			$exec['idproduct'] = $idproduct;
			$exec['idparametr'] = $idparametr;
			$exec['operator'] = array("AND");
			$return = $model->select($this->getTable("parametrs_product"),$exec);
			return $return;
		}

		$return = $model->select($this->getTable("parametrs_product"),$exec);

			for($i=0;$i<count($return);$i++){				
				$a = $this->getParametrs($return[$i]['idparametr'],0,1);				
				$return[$i]['parametr'] = $a[0];
				unset($return[$i]['idparametr']);
				unset($return[$i]['idproduct']);
				unset($return[$i]['id']);
			}
			
		return $return;
	}


	public function getParametrs($idparametr=false,$productcategory=false,$bool=false){
		$model = &strong::$model;
		if($idparametr)$exec['id'] = $idparametr;
		$return = $model->select($this->getTable("parametrs"),$exec);
		if($bool)return $return;
			for($i=0;$i<count($return);$i++){
				$return[$i]['value'] = $this->getParametrsProduct(0,$productcategory,$return[$i]['id']);
			}
		return $return;
	}


	public function searchProduct($parametrvalue=false,$query=false){
		$model = &strong::$model;
		if($parametrvalue){
			$q = "SELECT * from `catalog_parametrs_product` WHERE ";
			$exec['v'] = explode(";", $parametrvalue);$i=0;
			foreach ($exec['v'] as $key => $value) {
				if($value)$value = explode(",", $value);else continue;
				if($value[1]=='...')continue;
				if($i!==0)$q .=" AND ";
				$q .=" (`idparametr`=".$value[0]." AND `value`='".$value[1]."') ";
				$i++;
			}
			$return = $model->query($q);
			for($i=0;$i<count($return);$i++){
				$a = $this->getProductMini(array("id"=>$return[$i]['idproduct']));
				$ret[$return[$i]['idproduct']] = $a[0];
				
			}
			#echo $q;
			return $ret;

		}
		if($query){
			$exec['title'] = strong::secure_query($query);
		}
		$return = $model->query("SELECT * from `".$this->getTable('product')."` WHERE `title` LIKE '%".$exec['title']."%'");
		for($i=0;$i<count($return);$i++){
			$a = $this->getProductMini(array('id'=>$return[$i]['id']));
			$return[$i] = $a[0];
		}
		return $return;
	}

	private function getResponse($idproduct){
		$model = &strong::$model;
		if($idproduct) $return = $model->select($this->getTable("responses"),array('idproduct'=>$idproduct));
		return $return;
	}

	private function getRating($idproduct){
		$model = &strong::$model;
		if($idproduct) $return = $model->select($this->getTable("rating"),array('idproduct'=>$idproduct));
		
		@$return[0]['score'] = round(($return[0]['buy']*5)-($return[0]['visit']*0.1));
		return $return;

	}

	private function getBasket($idproduct){
		$model = &strong::$model;
		$basket = strong::loadModel("basket");
		$r = $basket->getBasketId($idproduct,strong::$infoUser['id']);
		return $r[0];
	}

	public function addProductParametrs($array){
		$model = &strong::$model;
		$model->insert($this->getTable('parametrs_product'),$array);
		return true;
	}

	public function addProductUser($array){
		$model = &strong::$model;
		$array['user'] = 1;

		return $model->insert($this->getTable('product'),$array);
		
	}

	public function addProductImage($idproduct,$image){
		$model = &strong::$model;
		if($idproduct AND $image){
			$exec['idproduct'] = $idproduct;
			$exec['idimage'] = $image;
			$model->insert($this->getTable("image"),$exec);
		}
	}


}?>
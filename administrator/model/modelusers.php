<?class modelusers{
	private function getTable(){
		return "users";
	}

	public function getUser($id=false,$user=false,$password=false){
		
			$model = &strong::$model;
				if($user AND $password){
					$exec['email'] = $user;
					$exec['password'] = $password;
					$exec['operator'][0] = "AND";

					$return = $model->select($this->getTable(),$exec);	

					if($return)return $return;else return false;
				}

				if($id){
					$exec['id']=$id;
					$return = $model->select($this->getTable(),$exec);

					return $return;
				}

			
			$sessionid = strong::loadModel("sessionid");
			$m_basket = strong::loadModel("basket");
			$city = strong::loadModel("city");
			$return = $sessionid->getSessionId();
			
			if($return[0]['city']){
				$a = $city->getCities($return[0]['city']);
				$return[0]['city'] =  $a[0];
			}

			if($return[0]['country']){
				$a = $city->getCountry($return[0]['country']);
				$return[0]['country'] =  $a[0];
			}

			if(!$return) return false;

			if($_GET['p']!="profile")$return[0]['basket'] = $m_basket->getBasketUser($return[0]['id']);else $return[0]['basket'] = $m_basket->getBasketUserFull($return[0]['id']);
			$return[0]['password'] = "Хрен";
			#print_r($return);

			return $return[0];

	}

	public function addUser($exec){
		$model = &strong::$model;

		if($exec['lname'] && $exec['fname'] && $exec['email']  && $exec['password']  && $exec['country'] && $exec['city']){
			$exec['password'] = md5("raccon_".strong::secure_query($_POST["password"]));
			$exec['rule'] = 3;
			$model->insert($this->getTable(),$exec);
		}

	}


	public function getUserIsset($email){
		$model = &strong::$model;

		if($email) return $model->select($this->getTable(),array("email"=>$email));

	}


}?>
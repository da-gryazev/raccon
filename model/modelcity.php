<?class modelcity{
	private function getTable(){
		return "cities";
	}

	public function getCountry($id=false,$like=false){
		$model = &strong::$model;
		if($id)$exec['country_id'] = $id;
		if($like AND $id){
			$like = strong::secure_query($like);
			$id = (int)($id);
			return $model->query("SELECT * FROM  `cities` WHERE `country_id`=".$id." AND  `city` LIKE  '%".$like."%' LIMIT 0,250");
		}
			$return = $model->select("countries",$exec,0,"0,250");
			#print_R($return);die;
			if(!$id)return $return;
			
			#$return['cities'] = $this->getCities(0,$id);
			return $return;
	}

	public function getCities($idcity=false,$idcountry=false){
		$model = &strong::$model;
		if($idcity)$exec['id'] = $idcity;
		if($idcountry)$exec['country_id'] = $idcountry;
			return $model->select("cities",$exec,0,"0,100000");
	}
}?>
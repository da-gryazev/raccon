<?class modeltemplate_info{
	private function getTable(){
		return "template_info";
	}

	public function getInfo($idtemplate=false,$titletemplate=false){
		$model = &strong::$model;
		$page = strong::loadModel("page");

		if($idtemplate) $exec['id'] = $idtemplate;
		if($titletemplate) $exec['template_title'] = $titletemplate;
		return $model->select($this->getTable(),$exec);

	}


}?>
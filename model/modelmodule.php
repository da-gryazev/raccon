<?class modelmodule{
	private function getTable(){
		return "module";
	}

	public function getModule($idmodule=false,$titlemodule=false){

		$model = &strong::$model;
		$modelpage_module = strong::loadModel("page_module");
		if($idmodule)	$exec['id'] = $idmodule;
		if($titlemodule)	$exec['title'] = $titlemodule;

		$return =  $model->select('module',$exec);
		return $return;
	}


}?>
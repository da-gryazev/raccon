<?class modelpage_module{
	private function getTable(){
		return "page_module";
	}

	public function getModuleInfo($idmodule){
		$model = &strong::$model;
		if($idmodule)	$exec['idmodule'] = $idmodule;
		$return =  $model->select('page_module',$exec);
		return $return;
	}

	public function getModuleAll($idtemplate){
		$model = &strong::$model;
		if($idtemplate)	$exec['idtemplate'] = $idtemplate;
		$return =  $model->select('page_module',$exec," `idmodule` DESC");

			for($i=0;$i<count($return);$i++){
				if($return[$i]['id']!=$i){
					$return[$return[$i]['id']] = $return[$i];
					unset($return[$i]);
				}
			}

		return $return;
	}



}?>
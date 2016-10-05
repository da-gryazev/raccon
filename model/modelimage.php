<?class modelimage{
	private function getTable(){
		return "image";
	}

	public function getImage($id){
		$model = &strong::$model;
		if($id)return $model->select($this->getTable(),array("id"=>$id));
	}


}?>
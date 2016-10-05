<?class modelpage{
	private function getTable(){
		return "page";
	}

	public function getPage($title){
		$model = &strong::$model;
		return $model->select($this->getTable(),array("title"=>$title));
	}


}?>
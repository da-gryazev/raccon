<?class modelsite_info{
	private function getTable(){
		return "site_info";
	}

	public function getInfo(){
		$model = &strong::$model;
		return $model->select(self::getTable(),array());
	}

}?>
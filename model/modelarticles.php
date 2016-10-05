<?class modelarticles{
	private function getTable(){
		return "articles";
	}

	public function getArticle($where){
		$model = &strong::$model;
		return $model->select($this->getTable(),$where);
	}
}?>
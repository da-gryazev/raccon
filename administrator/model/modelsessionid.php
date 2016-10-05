<?class modelsessionid{
	private $hash;

	function modelsessionid(){
		$this->hash = $_COOKIE['sessionid'];
	}

	private function getTable(){
		return "sessionid";
	}

	public function getSessionId(){
		$model = &strong::$model;
		$user = strong::loadModel("users");
		if(!$this->hash)return false;

		$sid = $model->select(self::getTable(),array("hash"=>$this->hash));
		if($sid)$info = $user->getUser($sid[0]["user"]);else return false;
		return $info;
	}

	public function addSessionId($user=false){
		$model = &strong::$model;
		$hash = uniqid(0, true);
		$model->insert(self::getTable(),array("user"=>$user,"hash"=>$hash));
		setcookie("sessionid",$hash,mktime(0, 0, 0, 3, 0, 2016));
	}

	public function closeSession(){
		$model = &strong::$model;
		$model->query("DELETE FROM `".self::getTable()."` WHERE `hash`='".$this->hash."'");
		setcookie("sessionid",$hash,time()-3600);
	}
	
	public function checkAccess(){
		if(!self::getSessionId()){
			header("Location: index.php");
			die;
		}
		
	}
}?>
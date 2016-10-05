<?
class model{
	private $host="localhost";
	private $dbname = "gorizontal";
	private $user = "root";
	private $pass = "";
	public $DB;
	public $main;
	
	function model(){
		$this->DB = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->pass);
		$this->DB->query("set names utf8");
		$this->main = @strong;/*ЕСЛИ ЧТО ИЗМЕНИТЬ НА $this->main =  new strong*/
	}
	
	#Обычный запрос
	public function query($q,$where=false){
		$STH = $this->DB->query($q); 
		$STH->setFetchMode(PDO::FETCH_ASSOC);  
		$return = array();
		while($ret=$STH->fetch())$return[] = $ret;
		return $return;
	}
	
	#INSERT IN SQL DB
	public function insert($table,$array,$debug = 'NONE'){
		//$db->insert("posts",array("theme"=>38,"user"=>2,"message"=>"[b]Ок[/b]","data"=>"2013-06-20 03:58:22"));
		
		/*D*/if($debug==':DEBUG'){
		/*E*/	echo "Таблица: ".$table."<br />";
		/*B*/	print_r($array);			
		/*U*/	
		/*G*/}
		
		if(!is_array($array))return false;
			$keyarray = array_keys($array);
			$key = implode("`,`",$keyarray);		
			for($i=0;$i<count($keyarray);$i++)$val[$i] = ":".$keyarray[$i];
			$val = implode(",",$val);
			$STH = $this->DB->prepare("INSERT INTO `".$table."` (`".$key."`) values (".$val.")");  
			if($debug==':DEBUG')die("<br />INSERT INTO `".$table."` (`".$key."`) values (".$val.")");else $STH->execute($array);

			if($STH)return $this->DB->lastInsertId();else return false;
	}
	
	#SELECT IN SQL DB
	public function select( $table , $where=false , $order='' ,$limit=false , $debug='NONE' ){
		/*
		|$where = array(
		|	'login'=>'admin',
		|	'avatar'=>'120
		|	'operator'=>array(
		|		0=>and
		));
		*/
		/*DEBUG*/if($debug==':DEBUG'){
		/*E*/	echo "Таблица: ".$table."<br />";
		/*B*/	print_r($where);			
		/*U*/	
		/*G*/}
		if(!$table)return false;
			$q = "SELECT * from `".$table."`";
			if($where)$q .= " WHERE ";
			$i=0;
			if($where){
				foreach($where as $key=>$value){

					if($key=='operator')continue;
					$value = strong::secure_query($value);
					$q .= " `".$key."`='".$value."' ".$where['operator'][$i];
					$i++;
				}

			}

			if($order)$q .= " ORDER BY ".$order." ";

			if($limit)$q .= " LIMIT ".$limit;	
			$STH = $this->DB->query($q); 
			if($debug==':DEBUG')echo $q; 

			$STH->setFetchMode(PDO::FETCH_ASSOC);  
			$return = array();
			while($ret=$STH->fetch())$return[] = $ret;
			 if($debug==':DEBUG'){
				echo "<br /><b>Ответ: </b><pre>";print_r($return);echo "</pre>";
				die("<br /><b>".$q."</b>");
			}
			
			return $return;

	}
	
	public function update( $table , $set=false , $where=false , $debug='NONE' ){

		/*DEBUG*/if($debug==':DEBUG'){
		/*E*/	echo "Таблица: ".$table."<br />";
		/*B*/	print_r($where);			
		/*U*/	
		/*G*/}
		if(!$table)return false;
			$q = "UPDATE `".$table."` SET";
			$i=0;
			if($set){
				foreach($set as $key=>$value){
					$value = strong::secure_query($value);
				
					if(($i+1)==count($set))$q .= " `".$key."`='".$value."' ";else $q .= " `".$key."`='".$value."' , ";
					$i++;
				}
			}
			if($where){
				$q .= " WHERE ";
				$i=0;
				foreach($where as $key=>$value){
					if($key=='operator')continue;
					$value = strong::secure_query($value);
					$q .= " `".$key."`='".$value."' ".$where['operator'][$i];
					$i++;
				}
			}
			$STH = $this->DB->query($q);  
			@$STH->setFetchMode(PDO::FETCH_ASSOC);  
			$return = array();
			while($ret=$STH->fetch())$return[] = $ret;
			 if($debug==':DEBUG'){
				echo "<br /><b>Ответ: </b><pre>";print_r($return);echo "</pre>";
				die("<br /><b>".$q."</b>");
			}
			
			return $return;

	}

	public function delete( $table , $where=false , $debug='NONE' ){
		/*
		|$where = array(
		|	'login'=>'admin',
		|	'avatar'=>'120
		|	'operator'=>array(
		|		0=>and
		));
		*/
		/*DEBUG*/if($debug==':DEBUG'){
		/*E*/	echo "Таблица: ".$table."<br />";
		/*B*/	print_r($where);			
		/*U*/	
		/*G*/}
		if(!$table)return false;
			$q = "DELETE  from `".$table."`";
			if($where)$q .= " WHERE ";
			$i=0;
			if($where){
				foreach($where as $key=>$value){

					if($key=='operator')continue;
					$value = strong::secure_query($value);
					$q .= " `".$key."`='".$value."' ".$where['operator'][$i];
					$i++;
				}

			}

			

			$STH = $this->DB->query($q); 
			if($debug==':DEBUG')echo $q; 

			$STH->setFetchMode(PDO::FETCH_ASSOC);  
			$return = array();
			while($ret=$STH->fetch())$return[] = $ret;
			 if($debug==':DEBUG'){
				echo "<br /><b>Ответ: </b><pre>";print_r($return);echo "</pre>";
				die("<br /><b>".$q."</b>");
			}
			
			return $return;

	}


	
}
?>

<?
/* файл с главным классом */
$execution_time = microtime();
defined("GLife_path") or define("GLife_path", dirname(__FILE__)."/../");
defined("GLife_src") or define("GLife_src","http://".$_SERVER['SERVER_NAME']."/gorizontal/");#Поменять


class strong{

	static public $model;
	static public $template;
	static public $infosite;
	static public $infoUser;

	function strong(){
		#Constructor
	}
	
	#Получает версию игры
	public static function getVersion(){
		return "0.0.1";
	}
	
	public static function Exception($m){
		die($m);
	}
	#Метод защиты от SQL-иньекции
	public static function secure_query($q){
		if(!is_int($q))return mysql_escape_string($q);else return (int)$q;
	}
	
	#Защита от XSS атак
	public static function secure_message($m){
		return htmlspecialchars($m);
	}
	
	public static function secure_file($f){
		return $sfile = preg_replace("/[\.\/]/"," ",$f);		
		
	}

	public function translitlang($str){

        $translit = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
        );
        return strtr($str,$translit);
    }
 
	
	#Загрузка модели
	public static function loadModel($m){
		$model = "model".$m;
		require_once(GLife_path.'model/'.$model.'.php');
		return new $model;
	}
	
	#Запуск отображения
	public static function createWebApplication(){
		require dirname(__FILE__).'/model/model.php';
		require dirname(__FILE__).'/template.php';
		self::$model = new model;
		self::$template = new template;


		$session = self::loadModel("sessionid");
		$users = self::loadModel("users");
		$m_site_info = self::loadModel("site_info");
		$p = trim(self::secure_file($_GET['p']));
		if($p=='')die(header("Location: index.php?p=index"));

		$a = $m_site_info->getInfo();self::$infosite['info'] = $a[0];
		self::$infosite['page']['title'] = $p;

		self::$infosite['template'] = self::$template->getInfoModuleAll(0,self::$infosite['info']['template']); #self::$infosite['template']['module'] - массив с модулями
		self::$infoUser = $users->getUser();
		
			if(!empty(self::$infoUser)){
				$b = &self::$infoUser['basket'];
				self::$infoUser['bsumprice'] = 0;
				self::$infoUser['bamount'] = 0;
				for($i=0;$i<count($b);$i++){
					self::$infoUser['bsumprice'] 	+= $b[$i]['info'][0]['price'];
					self::$infoUser['bamount']++;
				}
			}
		
			foreach(self::$infosite['template']['module'] as $key => $value) {	
				self::$infosite['load']['css'][] = 	self::$template->includeModule(false,0,$value['id'],"css");
				self::$infosite['load']['js'][] = 	self::$template->includeModule(false,0,$value['id'],"js");
			}
		if(!include GLife_path."controller/".$p.".php" ) 		header("HTTP/1.0 404 Not Found"); #Контроллер
		if(!include GLife_path."view/".$p.".html" ) 	header("HTTP/1.0 404 Not Found"); #Отображение

	}

	public static function returnModel(){return @$_GLOBALS['model'];}
	#Доступ к профилю
	public static function accessProfile(){
		$gs = self::loadModel("gsessionid");
		if($gs->getGSid()=='Not Found') return false;else return true;
	}
	#Получить дату
	public static function getDate(){
		return date("Y-m-d H:i:s");
	}
	#Разница между датами
	public static function changeDate($data_till){
		$data_from = date("Y-m-d");
        $data_from = explode('-', $data_from);
        $data_till = explode('-', $data_till);
 
        $time_from = mktime(0, 0, 0, $data_from[1], $data_from[2], $data_from[0]);
        $time_till = mktime(0, 0, 0, $data_till[1], $data_till[2], $data_till[0]);
        
        $diff['d'] = floor(abs(($time_till - $time_from)/60/60/24));
        if($diff['d']>30)$diff['m'] = floor($diff['d']/30);
        if($diff['m']>12)$diff['y'] = floor($diff['m']/12);
 
        return $diff;
	}


}
?>

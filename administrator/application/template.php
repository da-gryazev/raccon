<?
class template{

	public function getSiteTitle($title){
		return strong::$infosite['info']['title_site']." - ".$title;
	}

	public function getInfoModuleAll($idtemplate=false,$titletemplate=false){
		$template_info = strong::loadModel("template_info");
		$module = strong::loadModel("module");
		$page_module = strong::loadModel("page_module");
		if($idtemplate)    $a =  $template_info->getInfo($idtemplate);
		if($titletemplate) $a =  $template_info->getInfo(0,$titletemplate);
		$return = $a[0];
		
		$return['module'] = $page_module->getModuleAll($return['id']);		

			foreach ($return['module'] as $key => $value) {	
				$a = $module->getModule($value['idmodule']);
				$return['module'][$value['id']]['info'] = $a[0];
			}
		return $return;		
	}

	public function includeModule($title=false,$data = false,$id=false,$type="php"){ //type = тип фалйа (css, js, php)
		$module = strong::loadModel("module");
		$title = strong::secure_query($title);
		
		if($title)$infoModule = $module->getModule(0,$title);
		if($id)$infoModule = $module->getModule($id);
		if($type=="php")$src ="./controller/module/".$title."/index.php";
		if($type=="css"){
			if(is_file('./controller/module/'.$infoModule[0]['title'].'/css/main.css'))	return '<link rel="stylesheet" type="text/css" href="./controller/module/'.$infoModule[0]['title'].'/css/main.css">'; else return false;
		}
		if($type=="js"){
			if(is_file('./controller/module/'.$infoModule[0]['title'].'/js/main.js'))	return '<script src="./controller/module/'.$infoModule[0]['title'].'/js/main.js"></script>'; else return false;
		}
		if(is_file($src)) include($src); else echo ("Модуль <b>".$src."</b> отсутсвует. Обратитесь в службу поддержки.");
		return false;
    }

}
?>
<?
	/*
	*Загрузка модулей
	*/
	
	require_once("tmp/temp.php");

template('Загрузка модуля');
	
	if($_FILES['userfile']){
	/* Загрузка архмва на сервер*/	
require_once('module/pclzip/pclzip.lib.php');
	chdir('..');
	$uploaddir = 'module/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

echo 'Некоторая отладочная информация:';
print_r($_FILES);

print "</pre>";
	
	
	
chdir('module/');		
$archive = new PclZip($_FILES['userfile']['name']);

if ($archive->extract() == 0) {
die("Error : ".$archive->errorInfo(true));
 

}
$delete = unlink($_FILES['userfile']['name']);
$dir = substr($_FILES['userfile']['name'], 0, -4); 

	chdir($dir);	
	/*Прочие Действия*/	
	
		$openSQL = fopen('sql.sql','r+');
		
			if($openSQL){
			$readOpenSQL = fread($openSQL,999999);
				$sql = mysql_query($readOpenSQL);
			
				
			}else{
				$sql = mysql_query("INSERT INTO `module`(`name`,`URL`) VALUES('".$dir."','module/".$dir."/index.php') ");              
			}
			
				
		
	
	}
	
?>

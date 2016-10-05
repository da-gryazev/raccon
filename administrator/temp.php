
<?php

	require_once("tmp/temp.php");

template('Менеджер шаблонов');

if($_GET['skill'] == 'edit'){		
		

?>
<h3>Редактирование шаблона</h3>
<form method=GET>
<?
	@include('../'.$row['option']);
	include("../conf/option_temp.php");
?>

<input type=submit name=submit>
</form>
<?	
	die;
		}
	


if($_GET['skill'] == 'upload'){
	?>
<div class=upload_block>
<form enctype="multipart/form-data" action=upload_temp.php method="POST">
    
   
  
   <input class=upload_input_file size=90 name="userfile" type="file" /><br>
    <input value="Сохранить" type="submit" class=upload_input_submit  />
</form>

</div>
<?
die;
	
}

?>

<div class=block_mini_all><div class=block_mini><a class=block_mini_a href='?skill=upload'><img src="tmp/img/add.png">Загрузить шаблон</a></div><?


if($_GET['id_temp']){
	$_GET['id_temp'] = trim($_GET['id_temp']);
chdir('..');
$string = '$temp';
	$str = "<?$string= '".$_GET['id_temp']."';?>";
		$fopen = fopen("tmp/temp.php",'w+');
			$fwrite = fwrite($fopen,$str);
	fclose($fopen);
	chdir('administrator/');
}
			

$sql = mysql_query("SELECT * from `tmp`");
		$num = mysql_num_rows($sql);
			
			echo '<div id=point_block>';
			echo '<div class=materials_title>Просмотр шаблонов</div>';
			chdir('..');
					require_once "tmp/".$temp."/temp.php"; 

		for($i=0;$i<$num;$i++){		
			$row = mysql_fetch_assoc($sql);
				echo '<div class=module_name><a class=module_name_a href="?skill=edit&id='.$row['id'].'">'.$row['title'].'<SUP><KBD>('.$row['name'].')</KBD></SUP></a>';
					
					if(trim($row['name']) == trim($temp)){
						echo '<img class=img_star src="tmp/img/star.png" alt="Установлен">';
					}else echo '<form class=form_star><input type=hidden name=id_temp value="'.$row['name'].'"><input class=button_star type=submit value=""></form>';
				echo '</div>';
			}
			echo '</div>';
?>







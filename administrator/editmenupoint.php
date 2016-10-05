<?php
require_once("tmp/temp.php");

template('Редактирование пунктов меню');
   
   if(isset($_GET['id'])){
	if(isset($_GET['name-link']) and isset($_GET['url-link'])){
		if($_GET['name-link'] == ''){$error1 = "Вы не ввели название ссылки";}
		if($_GET['name-link'] == ''){$error2 = "Вы не ввели url ссылки";}
		

		$nameLink = addslashes(htmlspecialchars($_GET['name-link']));
	$urlLink = addslashes(htmlspecialchars($_GET['url-link']));


	$sql = mysql_query("UPDATE `point_menu` SET `name-link` = '".$nameLink."',
`url-link` = '".$urlLink."' WHERE `id-point` = '".$_GET['id']."'");

if($sql){
	echo "<h4 align=center>Пункт меню успешно изменен!</h4>";
}
		
	}
   $id = addslashes(htmlspecialchars($_GET['id']));
   
		$sql = mysql_query("SELECT * from `point_menu` where `id-point`=".$id.""); 
		@ $num = mysql_num_rows($sql);
		@ $row = mysql_fetch_assoc($sql);
			if($num == 0){
				echo "Непредвиденная ошибка!";
			}
			
			?>
			
			<form class=form align=center>
			<h3>Редактирование Пункта меню</h3>
			<input type=hidden name=id value=<?echo $_GET['id'];?>>
			Название ссылки: <input type=text name=name-link value="<?echo $row['name-link'];?>"><br /><?echo $error1;?><br />
			URL ссылки: <input type=text name=url-link value="<?echo $row['url-link'];?>"><br /><?echo $error2;?> <br />
			<input type=submit>
			</form>
			<?

			
		}

?>
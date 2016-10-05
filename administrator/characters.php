<?
 require_once("tmp/temp.php");

template('Менеджер характеристик');
if($_GET['skill'] == 'delete')
{
	$sql = mysql_query("DELETE FROM `characters` WHERE `id`=".$_GET['id']."");
	$alias = $_GET['alias'];
		$sqlALTER = mysql_query("ALTER TABLE `characters_materials` DROP `".$alias."`");
		echo '<script>location.href="characters.php"</script>';
}
	if($_GET['skill'] == 'add'){
	if(isset($_GET['submitClose'])){
		$name = addslashes(htmlspecialchars($_GET['name']));
		$alias = addslashes(htmlspecialchars($_GET['alias']));
		$sql = mysql_query("INSERT INTO `characters`(`name`,`alias`) VALUES('".$name."','".$alias."')");
			$sqlALTER = mysql_query("ALTER TABLE `characters_materials` ADD `".$alias."` TEXT");
			if($sql){
				echo "Добавлено!";
			}
	}
		?><br/>
		<a href=characters.php><-Назад</a>
		<div style="padding:15px;">
		<h3>Новая характеристика</h3>
		
		<form method=GET>
		<input type=hidden name=skill value=add>
		Имя:<input type=text name=name value=''><br />
		Алиас:<sup>Английское название</sup><input type=text name=alias value=''><br/>
		<input type=submit name=submitClose>
		</form>
		</div>
		<?
		die;
	}
			if(isset($_GET['alias'])){
				$sqlInsert = mysql_query("UPDATE `characters` SET `name` = '".$_GET['chr']."' WHERE `id`=".$_GET['id']."");
					
				if($sqlInsert){
				$trueText = 'Ок!<script>location.href="characters.php"</script>';
				}else $trueText = 'Ошибка! Попробуйте позже.<script>location.href="characters.php"</script>';
			}
			echo '<div class=block_mini_all><div class=block_mini><a class=block_mini_a href="?skill=add"><img src="tmp/img/add.png">Добваить</a></div>';
			echo '<div id=point_block>';
			echo '<div class=materials_title>Просмотр характеристик</div>';
			$sql = mysql_query("SELECT * from `characters`");
		$num = mysql_num_rows($sql);
		echo $trueText;
			for($i=0;$i<$num;$i++){		
			$row = mysql_fetch_assoc($sql);
			
		echo '<div class=module_name style="float:left;width:100%;">
				<form>
					<input type=hidden name=alias value='.$row['alias'].'>
					<input type=hidden name=id value='.$row['id'].'>
					<input style="float:left;" type=text name=chr value='.$row['name'].'>
						
					<input type=submit value="" class=users_edit_point_submit>
					<br /><br />id: '.$row['id'].'
					<br />alias: '.$row['alias'].'
				</form>
				<form method=GET>
						<div style="float:left;">
							<input type=hidden name=id value='.$row['id'].'>
							<input type=hidden name=alias value='.$row['alias'].'>
							<input type=hidden name=skill value="delete">
							<input type=hidden name=id value='.$row['id'].'>
							<input class=button_delete type=submit value="">
							<input type="hidden" name=skill value=delete>
						</div>
						</form>
			</div>';																
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			}
			echo '</div>';
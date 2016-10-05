<?php

require_once("tmp/temp.php");

template('Добавление меню');

   if($_GET['name'] and $_GET['idmenu']){
	$SQL = mysql_query("UPDATE `menu` SET `name` ='".$_GET['name']."' WHERE `id` =".$_GET['idmenu']."");
	
	
	echo "<script>location.href='?skill=edit&id=".$_GET['idmenu']."'</script>";
   die;
   }
   if($_POST['name']){
	$SQL = mysql_query("INSERT INTO `menu` (`name`) VALUES('".$_POST['name']."')");
	
	
	echo "<script>location.href='addmenu.php'</script>";
   die;
   }
  
   
		if($_GET['skill'] == 'add'){
			?>
				<form name=addmenu method=POST>
					<input type=text name=name value="Название меню">
					<input type=submit value=Добавить>
				</form>
			<?
		die;
		}
		
			if($_GET['skill'] =='edit'){
			$doGET = "?skill=edit";
				$sql = mysql_query("SELECT * from `menu`");
				$num = mysql_num_rows($sql);
echo 'Выбрать меню:<br />';		
		for($i=0;$i<$num;$i++){	
				
			$row = mysql_fetch_assoc($sql);
					
					echo '<a href='.$doGET.'&id='.$row['id'].'>'.$row['name'].'</a><br>';
			
			}
			if($_GET['id']){	
			
			$sql = mysql_query("SELECT * from `menu` where id=".$_GET['id']."");
			
			$rowmenu = mysql_fetch_assoc($sql);
				if($rowmenu['id'] == ''){
					echo '<p align=center>К сожелению такого меню удалено</p>';
					
					die;
				
				}
				
				echo '<form name=editmenu  method=GET align=center>';
				?>
				
					Название меню: 
					<input type=text size=30 name=name value="<?echo $rowmenu['name'];?>">
					<? 
					echo '<input type=hidden name=idmenu value='.$rowmenu['id'].'>'; 
					?>
					<input type=submit>
					
				</form>
				
				
				<?
			
			
			die;			
			}else{die;}			}
		?>
			<a href="?skill=add">Добавить меню</a>
			<a href="?skill=edit">Редактировать меню</a>
			
		
		<?
		

?>
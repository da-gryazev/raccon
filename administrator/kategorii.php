<?php
require_once("tmp/temp.php");
include("includes/resize.php");

template('Менеджер категорий');
   
 
	if($_GET['skill'] == 'add'){
	

	
	if(isset($_GET['title']) and isset($_GET['desc'])){
	print_r($_FILES);
	if($_GET['title'] == ''){$error1 = "Название категории не заполнено!";}
	if($_GET['desc'] == ''){$error2 = "Описание категории не заполнено!";}
		if(!isset($error1) and !isset($error2)){
			$title = $_GET['title'];
			$desc = $_GET['desc'];
			
				$sql = mysql_query("INSERT into `catalog_categorii` (`title`,`desc`) VALUES('".$title."','".$desc."')");
				
					if($sql){
						echo "Категория успешно добавлена";
					}
				}
		
		}
	
		/*Добавление новой категории*/
		?>
			<form name=add class=form align=center enctype="multipart/form-data">
			<input type=hidden name=skill value=add>
				Название категории: <input type=text name='title'><br /><?echo $error1;?><br />
				Описание категории:<br /> <TEXTAREA name=desc cols=60 rows=10></TEXTAREA><br /><?echo $error2;?><br />
				Иконка:<input type="file" name="filename"><br> 
		
      
			<input type=submit value='Добавить'>
			</form>
		
		<?
	
	
	die;
	}
 
	if(isset($_GET['id'])){
	/*Изменение имеющейся категории*/
	
	if(isset($_GET['title']) and isset($_GET['desc'])){
	
		if($_GET['title'] == ''){$error1 = " <i>Вы не ввели название категории!</i>";}
		if($_GET['desc'] == ''){$error2 = " <i>Вы не ввели описание категории!</i>";}
		
		if(!isset($error2) and !isset($error1)){
		
			$title = $_GET['title'];
			$desc = $_GET['desc'];
			
			$sql = mysql_query("UPDATE `catalog_categorii` SET `title`  =  '".$title."', `desc` ='".$desc."' WHERE id=".$_GET['id']." ");
			if($sql){
			echo "Категория успешно изменена!";
			}
		}
	
	}
	
		$sql = mysql_query("SELECT * from `catalog_categorii` where id=".$_GET['id']."");
		$row = mysql_fetch_assoc($sql);
		
		
			?>
			<form align=center class=form>
			<input type=hidden name=id value="<?echo $_GET['id'];?>">
			Название категории: <input type=text name='title' value="<?echo $row['title'];?>"><br />
			Описание категории:<br /> <TEXTAREA name=desc cols=60 rows=10><?echo $row['desc'];?></TEXTAREA><br />
			
			<input type=submit value=Изменить>
			</form>
			<?
		die;
	}
		$sql = mysql_query("SELECT * from `catalog_categorii`");
		
		$num = mysql_num_rows($sql);
		echo '<div class=block_mini_all><div class=block_mini><a class=block_mini_a href=?skill=add><img src="tmp/img/add.png">Добавить категорию</a></div>';
		
		echo '<div id=point_block><div class=materials_title>Просмотр категорий</div>';
		for($i=0;$i<$num;$i++){
			$row = mysql_fetch_assoc($sql);
			
			echo "<a style='float:left;padding:10px;' class=materials href=?id=".$row['id'].">".$row['title']."</a><br>";
		
		}
		echo '</div>';
		
		
		
   
   
   
   
   
   

   
   
   
   
   
   
   
   
   
   
   
   
   ?>
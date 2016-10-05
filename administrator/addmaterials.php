<?php
	require_once("tmp/temp.php");
	template('Добавление материала');
 ?>
 <style>
 input{
	margin:20px;
 }
 select{
	margin:20px;
 }
 </style>
 <?
 //Функция взята с http://forum.php.su/topic.php?forum=71&topic=4385 (спасибо lamozavrik)
function getCats($res){   
   			$levels = array();
		    $tree = array();
		    $cur = array();		   
		    while($rows = mysql_fetch_assoc($res)){		       
		        $cur = &$levels[$rows['id']];
		        #$cur['parent'] = $rows['parent'];
		        $cur['id'] = $rows['id'];
		        $cur['title'] = $rows['title'];		       
		        if($rows['parent'] == 0){
		            $tree[$rows['id']] = &$cur;
		        }
		        else{
		            $levels[$rows['parent']]['children'][$rows['id']] = &$cur;
		        }		       
		    }
		    return $tree;
		}

//Проверка вводимых значений
	if(!isset($_POST['name'])  or !isset($_POST['textbig'])) $erfile=1;

	if($erfile != 1){

		if($_POST['name'] == ''){$error1 = " <i>Вы не ввели название материала!</i>";}
		if(!(int)$_POST['money']){$error4 = " <i>Неверный формат!</i>";}
		if($_POST['textsmall'] == ''){$error2 = " <i>Вы не ввели краткий текст материала!</i>";}
		if($_POST['textbig'] == ''){$error3 = " <i>Вы не ввели полный текст материала!</i>";}
		if(!isset($error1) and !isset($error2) and !isset($error3)){
		$name = addslashes(htmlspecialchars($_POST['name']));
		$textsmall = $_POST['textsmall'];
		$textbig = $_POST['textbig'];
	}
  if($erfile !== 1){

	if($_FILES['userfile']['size'] !== 0){
		if($_FILES['userfile']['type'] == 'image/jpeg' OR $_FILES['userfile']['type'] == 'image/gif' OR $_FILES['userfile']['type'] == 'image/jpg' OR $_FILES['userfile']['type'] == 'image/png' OR $_FILES['userfile']['type'] == 'image/bmp'){
			if($row['image'] !== ''){
				$filename = $row['image'];			
				@unlink($filename);
			}
				$den = "img_".uniqid(rand(100000,999990)).".jpg";
				move_uploaded_file($_FILES["userfile"]["tmp_name"], "../image/".$den);
				$img = $_FILES['userfile']['name'];
		}
	}
	}else{
	
		echo '<h1 align=center>Закаченный файл не явлется изображением</h1>';
	}
		
		$sql_user = mysql_query("SELECT `id` from `users` WHERE `login`='".$_SESSION['login']."'");		
		$row_user = mysql_fetch_assoc($sql_user);
		$data = date("Y-m-d H:i:s");
		$name = addslashes(htmlspecialchars($_POST['name']));
		$textsmall = $_POST['textsmall'];
		$textbig = $_POST['textbig'];
	if(!$img){

		$sql = mysql_query("INSERT INTO `materials`(`image`,`name`,`id_kategorii`,`textsmall`,`textbig`,`money`,`author`,`date`) VALUES('','".$name."',".$_POST['kategorii'].",'".$textsmall."','".$textbig."','".$_GET['money']."','".$row_user['id']."','".$data."')");
		$sql1 = "INSERT INTO `catalog_product`(`title`,`desc`,`category`,`price`) VALUES('".$name."','".$textbig."','".$_POST['kategorii']."','".$_POST['money']."')";
		mysql_query($sql1);
		$idproduct = mysql_insert_id();
		mysql_query($sql2);
		$sql3 = "INSERT INTO `catalog_image`(`idproduct`,`idimage`) VALUES('".$idproduct."',10)";
		mysql_query($sql3);
		echo $sql1."<br />".$sql2."<br />".$sql3;
		foreach ($_POST['parametrs'] as $key => $value) {
			if(!$value)continue;
			mysql_query("INSERT INTO `catalog_parametrs_product`(`value`,`idproduct`,`idparametr`,`productcategory`) VALUES('".$value."','".$idproduct."','".$key."','".$_POST['kategorii']."')");
		}
		
		
	}else {

	$sql = mysql_query("INSERT INTO `materials`(`image`,`name`,`id_kategorii`,`textsmall`,`textbig`,`money`,`author`,`date`) VALUES('','".$name."',".$_POST['kategorii'].",'".$textsmall."','".$textbig."','".$_GET['money']."','".$row_user['id']."','".$data."')");
		$sql1 = "INSERT INTO `catalog_product`(`title`,`desc`,`category`,`price`) VALUES('".$name."','".$textbig."','".$_POST['kategorii']."','".$_POST['money']."')";
		mysql_query($sql1);
		$idproduct = mysql_insert_id();
		$sql2 = "INSERT INTO `image`(`src`,`alt`)  VALUES('".$den."','".$name."') ";
		mysql_query($sql2);
		$sql3 = "INSERT INTO `catalog_image`(`idproduct`,`idimage`) VALUES('".$idproduct."','".mysql_insert_id()."')";
		mysql_query($sql3);
		echo $sql1."<br />".$sql2."<br />".$sql3;
		foreach ($_POST['parametrs'] as $key => $value) {
			if(!$value)continue;
			mysql_query("INSERT INTO `catalog_parametrs_product`(`value`,`idproduct`,`idparametr`,`productcategory`) VALUES('".$value."','".$idproduct."','".$key."','".$_POST['kategorii']."')");
		}
	}
	}

		echo '<h3>Добавление материала</h3>';
		$sqlCat = mysql_query("SELECT * from `catalog_categorii`");
		$categorii = getCats($sqlCat);
		$m=0;
		function catPrint($array,$m=0){
			if(!is_array($array))return;
			foreach ($array as $key => $value) {
					#print_r($value['title']);echo "<br />";
					echo "<OPTION VALUE=".$value['id'].">";for($i=0;$i<$m;$i++){echo "-";}
					echo $value['title']."</OPTION>";
				
				if($value['children']){$m++;catPrint($value['children'],$m);}else $m--;

			}
		}

			
		/*for($i=0;$i<$numCat;$i++){
				$row[$i] = mysql_fetch_assoc($sqlCat);
				for($k=0;$k<$row[$i];$k++){
					$row[$i][$k] = mysql_query("SELECT * from `catalog_categorii` WHERE `parent` = ".$row[$i]);
				}
				
			
		}
		print_r($row);*/
		$numCat = mysql_num_rows($sqlCat);
		if($numCat==0){
			echo "<p align=center>У вас еще нет ни одной категории!<br /><a href=addkategorii.php>Добавить категории</a></p>";
			
		}

		$sql = mysql_query("SELECT * from `catalog_parametrs`");
		$num = mysql_num_rows($sql);
?>
	<form name=add method=POST  enctype="multipart/form-data">
	<div style="width:100%;padding:15px;"><input style="width:100px;height:100px;" type=submit value="Сохранить"></div>
	<div style="padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:left;width:45%;border:0.1em solid #ccc;">
		Название материала:<input type=text name=name value="<?echo $_POST['name'];?>"><?echo $error1;?><br />
		Категория: <SELECT  name=kategorii>
		<?
		catPrint($categorii);
		?>		
		</SELECT><br />
		Полный текст материала <?echo $error3;?><br /><TEXTAREA name=textbig cols=90 rows=15><?echo $_POST['textbig'];?></TEXTAREA>
		
	</div>
	<div style="padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:right;width:45%;border:0.1em solid #ccc;">
			Цена: <input name="money" value="<?=$_POST['money']?>" type="text" />$<?echo $error4;?><br />
			Картинка: <input name="userfile" type="file" /><br />
		</div>
		
		<div style="margin-top:15px;padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:right;width:45%;border:0.1em solid #ccc;"><div style="margin-top:-25px;">Необязательные параметры</div>
			<?echo $error5;	?>
			<?
			for($i=0;$i<$num;$i++){
				$row = mysql_fetch_array($sql);
				echo $row['title'].'<input type="text" name="parametrs['.$row['id'].']">'.$row['unit']."<br />";
			}
			?>
			
		</div>
	</form>
	<?
		
		
	?>
	
<?
?>
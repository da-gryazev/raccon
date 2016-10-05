<?
 //Функция взята с http://forum.php.su/topic.php?forum=71&topic=4385 (спасибо lamozavrik)
require_once("application/main.php");

strong::createWebApplication();
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

		function translitlang($str){

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
    function catPrint($array,$m=0,$cat){
			if(!is_array($array))return;
			foreach ($array as $key => $value) {
					#print_r($value['title']);echo "<br />";
					if($value['category'] !== $cat ){
							echo "<OPTION VALUE='".$value['id']."'>";
						}else echo "<OPTION SELECTED VALUE=".$value['id'].">";
					}
					for($i=0;$i<$m;$i++){echo "-";}
					echo $value['title']."</OPTION>";
				
				if($value['children']){$m++;catPrint($value['children'],$m,$cat);}else $m--;

			}
		

require_once("tmp/temp.php");

template('Редактирование материала');
 

 
   
   
 if(isset($_POST['name']) or isset($_POST['textsmall']) or isset($_POST['textbig'])){

 if($_FILES['userfile']['error'] == 0){
	if($_FILES['userfile']['type'] == 'image/jpeg' OR $_FILES['userfile']['type'] == 'image/gif' OR $_FILES['userfile']['type'] == 'image/jpg' OR $_FILES['userfile']['type'] == 'image/png' OR $_FILES['userfile']['type'] == 'image/bmp'){
		chdir('..');
			$filename = $row['image'];			
			@unlink($filename);
			
			
		$den = uniqid(rand(100000,999990));
		 move_uploaded_file($_FILES["userfile"]["tmp_name"], "img/img_".$den.'.jpg');
		
		$img = 'img_'.$den.'.jpg';
		
	}else{
	
	echo '<h1 align=center>Закаченный файл не явлется изображением</h1>';
	}
}
 
 
   if($_POST['name'] == ''){$error1 = " <i>Вы не ввели название материала!</i>";}
    
	if(!(int)$_POST['money']){$error4 = " <i>Неверный формат!</i>";}
   if(!isset($error1) and !isset($error2) and !isset($error3) and !isset($error4)){
   $name = addslashes($_POST['name']);
   $textsmall = addslashes($_POST['textsmall']);
   $textbig = addslashes($_POST['textbig']);
   $money = $_POST['money'];
   $kategorii = htmlspecialchars(addslashes($_POST['kategorii']));
   
   if(isset($img)){   
  $sql = mysql_query("UPDATE `materials` SET `name`  =  '".$name."', `money`  =  ".$money.", `image`  =  'img/".$img."',  `id_kategorii`  =  ".$kategorii.",  `textsmall` = '".$textsmall."',  `textbig` ='".$textbig."' WHERE id=".$_GET['id']." ");
 }else {$sql = mysql_query("UPDATE `materials` SET `name`  =  '".$name."', `money`  =  ".$money.",  `id_kategorii`  =  ".$kategorii.",  `textsmall` = '".$textsmall."',  `textbig` ='".$textbig."' WHERE id=".$_GET['id']." ");}

  }
 }
  if(isset($_GET['id'])){
	echo "<a href=edit.php>Назад</a>";
				$catalog = strong::loadModel('catalog');
				$row = $catalog->getProduct(array('id'=>$_GET['id']));
				$row = $row[0];

		print_r($row);
		
		
		
		
	
		$sqlCat = mysql_query("SELECT * from `catalog_categorii`");
		$numCat = mysql_num_rows($sqlCat);
		$categorii = getCats($sqlCat);

		
	?>
		<form name=add method=POST  enctype="multipart/form-data">
	<div style="width:100%;padding:15px;"><input name=submit style="width:100px;height:100px;" type=submit value="Сохранить"></div>
	<div style="padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:left;width:45%;border:0.1em solid #ccc;">
		<input type=hidden name=id value="<?php echo $_GET['id'];?>">
		Название материала:<input type=text name=name value="<?echo $row['name'];?>"><?echo $error1;?><br />
		
		Категория: <SELECT  name=kategorii>
		<?
		
	
		catPrint($categorii,0,$row['category']);
		
		?>
		
		</SELECT><br />
		Краткий текст материала <?echo $error2;?><br />
		<TEXTAREA name=desc cols=60 rows=15><?echo $row['desc'];?></TEXTAREA>
		Полный текст материала <?echo $error3;?><br /><TEXTAREA name=desc cols=90 rows=15><?echo $row['desc'];?></TEXTAREA>
	</div>
	
		
		
   
    
   <div style="padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:right;width:45%;border:0.1em solid #ccc;">
			
			Цена: <input name="price" value="<?=$row['price']?>" type="text" />руб.<?echo $error4;?><br />
			<input type="hidden" name="MAX_FILE_SIZE" value="99999999999999" />
			Картинка: <input name="userfile" type="file"><?if($row['image'] !== ''){?><a href="<?='http://'.$_SERVER['HTTP_HOST'].'/'.$row['image']['info']['src']?>" target=blank>Просмотр</a><?}?><br />
		
		<?
		
		?></div>
		   <div style="margin-top:15px;padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:right;width:45%;border:0.1em solid #ccc;"><div style="margin-top:-25px;">Дополнительные характеристики</div>
			<?
				/*
				*
				*Список Характеристик
				*
				*/
			
					$sqlCharacters = mysql_query("SELECT * from `catalog_parametrs`");
					$sqlCharactersMaterials = mysql_query("SELECT * from `catalog_parametrs_product` WHERE id=".$_GET['id']."");
						
						$numCharacters = mysql_num_rows($sqlCharacters);
						$rowCharactersMaterials = mysql_fetch_assoc($sqlCharactersMaterials);
						
			for($i=0;$i<$numCharacters;$i++){
				$rowCharacters = mysql_fetch_assoc($sqlCharacters);	
				print_r($rowCharacters);
				if(isset($_POST['submit'])){

							if($_POST['chr_'.$rowCharacters['alias']]){$sql_characters = mysql_query("UPDATE `characters_materials` SET `".$rowCharacters['alias']."` = '".$_POST['chr_'.$rowCharacters['alias']]."' WHERE id=".$_GET['id']."");
							echo "<SCRIPT>location.href='editmaterials.php?id=".$_GET['id']."';</SCRIPT>";
							}
							
				}				
					?>	
						<?=$rowCharacters['name']?> : <input type=text name="parametrs[]" value="<?=$rowCharacters['title']?>"><br/>
					<?
			}	
		
						
			?>
			
			
			
			
		</div>
    <?//=date("Y-m-d H:i:s");?>
	
	<br />
	
	</form>
	<?
	
	}
	?>
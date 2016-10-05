<?php

require_once("tmp/temp.php");

template('Менеджер материалов');
	if($_GET['id_mat']){
		$id_mat = addslashes(htmlspecialchars($_GET['id_mat']));
			$sql = mysql_query("DELETE from `catalog_product` WHERE id=".$id_mat);
			$sql = mysql_query("DELETE from `catalog_parametrs_product` WHERE idproduct=".$id_mat);
				if($sql){
					popup("Удаление выполнено успешно!",'edit.php');
				}
	}

		
	 
	 echo '<div class=block_mini_all><div class=block_mini><a class=block_mini_a href=addmaterials.php><img src="tmp/img/add.png">Добавить материал</a></div>';
	 echo '<div id=point_block><div class=materials_title>Просмотр материалов</div>';
	 $sql = mysql_query("SELECT * from `catalog_product`");
	$num = mysql_num_rows($sql);
	
	for($i=0;$i<$num;$i++){
	$row = mysql_fetch_array($sql);
		$sql_kategorii = mysql_query("SELECT * from `catalog_categorii` where `id`=".$row['category']."");
		$row_kategorii = mysql_fetch_assoc($sql_kategorii);
			

		echo "<div class=materials><a class=materials href='editmaterials.php?id=".$row['id']."'>".$row['title']."</a><form style='float:left;' class=form_star><input type=hidden name=id_mat value='".$row['id']."'><input class=button_delete type=submit value=''></form></div>
		<div class=kategorii>Категория: <a class=kategorii href='kategorii.php?id=".$row_kategorii['id']."'>".$row_kategorii['title']."</a></div>
		<hr color=#cccccc><br /></div></div>";
	
	}
		
	

?>
</div>



























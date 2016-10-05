<?php
	require_once("tmp/temp.php");

template('Менеджер меню');
		?>
			
					<div class=block_mini_all>
						<div class=block_mini><a class=block_mini_a href='addmenu.php?skill=add'><img src="tmp/img/add.png">Добавить меню</a></div>
						<div class=block_mini><a class=block_mini_a href='menupoint.php'><img src="tmp/img/add.png">Добавить пункт меню</a></div>
					</div>	
						
						<?
													function go(){
echo '<script>var hp = confirm("Вы точно хотите удалить пункт меню!");</script>';						
						$hp = '<script>document.write(hp);</script>';
								
					
						if ($hp == 'true') { 
  $sql = mysql_query("DELETE FROM `point_menu` WHERE `id-point` =".$_POST['id']."");
  if($sql == TRUE){
			echo '<script>alert("Пункт меню успешно удален");location.href="menupoint.php"</script>';  
			
}
  
 } else echo '<script>location.href="menupoint.php"</script>';
 
  
 
 

		
		  
}
	$sqlMenu = mysql_query('SELECT * FROM `menu`');	
	$numMenu = mysql_num_rows($sqlMenu);
		$rowMenu = mysql_fetch_assoc($sqlMenu);
		
		
  
    $sqlMenu = mysql_query("SELECT * from `menu` ");
				
					$numMenu_one = mysql_num_rows($sqlMenu);
	 					$sqlMenu = mysql_query("SELECT * from `menu` ");
					$numMenu = mysql_num_rows($sqlMenu);
					for($i=0;$i<$numMenu;$i++){
					$rowMenu = mysql_fetch_assoc($sqlMenu);
					$sqlPoint = mysql_query("SELECT * from `point_menu` where `id-menu` =".$rowMenu['id']."");
					
					$numPoint = mysql_num_rows($sqlPoint);
						echo '<div id=point_block><hr color=#cccccc>Меню: <a href=addmenu.php?skill=edit&id='.$rowMenu['id'].'>'.$rowMenu['name'].'</a><hr color=#cccccc>';
						


if (isset( $_POST['button_pressed'] )) {  
   go();
}  

							for($r=0;$r<$numPoint;$r++){
								$rowPoint = mysql_fetch_assoc($sqlPoint);
								
								?>
								<form class=point  action="<?=$_SERVER['REQUESR_URI']?>" method="GET"> 
<input type=hidden name=id value="<? echo $rowPoint['id-point'];?>">	
<input type=hidden name=name-link value="<? echo $rowPoint['name-link'];?>">							
  <input type="submit" value="Удалить ->" name="button_pressed">  

<?
							echo  "<a class=point href=editmenupoint.php?id=".$rowPoint['id-point'].">- ".$rowPoint['name-link']."</a><br />";
							}
							?></form><?
					}
				?>
						
					</body>
			</html>
		
		<?

?>
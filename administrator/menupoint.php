<?php
require_once("tmp/temp.php");

template('Редактирование материала');

	
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
   
   ?>

   <style>
   .point{
   padding:5px;
	padding-left:50px;
	color:gray;
   }
   
   </style>
   <?
   





	$sqlMenu = mysql_query('SELECT * FROM `menu`');	
	$numMenu = mysql_num_rows($sqlMenu);
		$rowMenu = mysql_fetch_assoc($sqlMenu);
		
		
 if(isset($_POST['hid']))  
	if($_POST['url-link'] and $_POST['name-link']){
	    $nameLink = htmlspecialchars($_POST['name-link']);
		$urlLink = htmlspecialchars($_POST['url-link']);
		$idMenu = $_POST['id-menu']; 
		  $nameLink = addslashes($nameLink);
		  $urlLink = addslashes($urlLink);	
			
				
				$sql = mysql_query("INSERT INTO `point_menu`(`id-menu`,`name-link`,`url-link`) VALUES(".$idMenu.",'".$nameLink."','".$urlLink."')");
				
				if($sql == TRUE){
				
				   echo "<script>alert('Пункт добавлен в меню');
				   location.href='menupoint.php';
				   </script>";
				}
		}
    $sqlMenu = mysql_query("SELECT * from `menu` ");
				
					$numMenu_one = mysql_num_rows($sqlMenu);
	 ?>
	 <html>
		<head>
			<title></title>
		</head>
				<body>
				<form name=menuedit method=POST style="padding:25px;">
				<input type=hidden name=hid>
				<input type=text name=name-link value="Название пункта меню" onFocus="if(value == 'Название пункта меню'){value=''}" onBlur="if(value == ''){value='Название пункта меню'}">
				<input type=text name=url-link value="URL пункта меню" onFocus="if(value == 'URL пункта меню'){value=''}" onBlur="if(value == ''){value='URL пункта меню'}">
				<SELECT name=id-menu>
				<OPTION >...</OPTION>
				<?php
				
					for($i=0;$i<$numMenu_one;$i++)
				{
				$rowMenu_one = mysql_fetch_assoc($sqlMenu);
					echo '<OPTION VALUE='.$rowMenu_one['id'].'>'.$rowMenu_one['name'].'</OPTION>';
				 }
				?>
				</SELECT>
				<input type=submit value=Добавить>
				</form>
				
				
				<?php
					$sqlMenu = mysql_query("SELECT * from `menu` ");
					$numMenu = mysql_num_rows($sqlMenu);
					for($i=0;$i<$numMenu;$i++){
					$rowMenu = mysql_fetch_assoc($sqlMenu);
					$sqlPoint = mysql_query("SELECT * from `point_menu` where `id-menu` =".$rowMenu['id']."");
					
					$numPoint = mysql_num_rows($sqlPoint);
						echo '<hr color=#cccccc>Меню: <a href=addmenu.php?skill=edit&id='.$rowMenu['id'].'>'.$rowMenu['name'].'</a><hr color=#cccccc>';
						


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
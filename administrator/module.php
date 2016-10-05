<?
require_once("tmp/temp.php");

template('Менеджер модулей');

if($_GET['skill'] == 'upload'){
	?>
<div class=upload_block>
<form enctype="multipart/form-data" action=upload_module.php method="POST">
    
   
  
   <input class=upload_input_file size=90 name="userfile" type="file" /><br>
    <input value="Сохранить" type="submit" class=upload_input_submit  />
</form>

</div>
<?
die;
	
}
if($_GET['skill'] == 'add'){
?>
Создание модуля:
<div style="width:100%;float:left;"><br><input name=submit type=submit value=Сохранить></div>
				<div style="margin-top:15px;padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:left;width:45%;border:0.1em solid #ccc;"><div style="margin-top:-25px;">Основные параметры</div>
		<div class=module_block>
		
<form method=POST>
Название модуля<input style="margin:7px;" type=text name=name value=""><br/>
Располжения модуля:  <SELECT style="margin:7px;" name=position>
						<?
						$sql_position = mysql_query("SELECT * from `position_tmp`");
		$num_position = mysql_num_rows($sql_position);
							for($i=0;$i<$num_position;$i++){
							$row_position = mysql_fetch_assoc($sql_position);
								echo $row_position['position'] .' == '. $row_module_position['position'].'<br>';
									$sql = mysql_query("SELECT * from `module_position` where position='".$row_position['position']."'");
										$num = mysql_num_rows($sql);
										
								if(trim($row_position['position']) == trim($row_module_position['position'])){
								
								echo '<OPTION  value='.$row_position['position'].' SELECTED="">'.$row_position['position'].'</OPTION>';
							}else{ if($num == 0){
							echo '<OPTION value='.$row_position['position'].'>'.$row_position['position'].'</OPTION>';
							}
									}
							}
						?>
						</SELECT><br/>
						<script>
						function hide(val){
							
							document.getElementById("hide").style.overflow = "visible";
							
						}
						</script>
						Тип:<SELECT style="margin:7px;">
						<OPTION onClick="hide('Меню');">Меню</OPTION>
						
						</SELECT>
						<div id="hide" style="width:0px; height:0px; overflow:hidden;">
						<script>document.write(val);</script>:<SELECT style="margin:7px;">
						<option>123</option>
						
						
						
						</SELECT>
						</div>
						
						
</form>
<?

	return;
}
if($_GET['skill'] == 'edit'){
	if($_GET['id'] !== NULL){
		//Проверка число ли это
		if((int)$_GET['id']){
			if($_GET['submit']){
				$position = addslashes(htmlspecialchars($_GET['position']));
				$_GET['id'] = addslashes(htmlspecialchars($_GET['id']));
			$sql = mysql_query("SELECT * from `module_position` where `id_module`=".$_GET['id']."");
			$num = mysql_num_rows($sql);
			
				if($num !== 0){
					$sql = mysql_query("UPDATE `module_position` SET `position`  =  '".$position."' where id_module=".$_GET['id']."");
					}else  $sql = mysql_query("INSERT INTO `module_position` (`id_module`,`position`) VALUES('".$_GET['id']."','".$position."')");
					
					if($sql){
						popup("Ок!",'module.php?skill=edit&id='.$_GET['id'].'');
					}
			}
		$sql = mysql_query("SELECT * from `module` WHERE id=".$_GET['id']." ");
		$num = mysql_num_rows($sql);
		$row = mysql_fetch_assoc($sql);
				$sql_module_position = mysql_query("SELECT * from `module_position` WHERE id_module=".$_GET['id']." ");
				$row_module_position = mysql_fetch_assoc($sql_module_position);
					
		$sql_position = mysql_query("SELECT * from `position_tmp`");
		$num_position = mysql_num_rows($sql_position);

		?>
				<form name=editmodule method=GET>
				
				<div style="width:100%;float:left;"><br><input name=submit type=submit value=Сохранить></div>
				<div style="margin-top:15px;padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:left;width:45%;border:0.1em solid #ccc;"><div style="margin-top:-25px;">Основные параметры</div>
		<div class=module_block>Модуль: <b><?php echo $row['name'];?></b><br>
		
				<div class=module_input_option>
				<input type=hidden name=skill value=edit>
				<input type=hidden name=id value=<?echo $_GET['id'];?>>
				<?

				?>
					Позиция:  <SELECT name=position>
						<?
						
							for($i=0;$i<$num_position;$i++){
							$row_position = mysql_fetch_assoc($sql_position);
								echo $row_position['position'] .' == '. $row_module_position['position'].'<br>';
									$sql = mysql_query("SELECT * from `module_position` where position='".$row_position['position']."'");
										$num = mysql_num_rows($sql);
										
								if(trim($row_position['position']) == trim($row_module_position['position'])){
								
								echo '<OPTION  value='.$row_position['position'].' SELECTED="">'.$row_position['position'].'</OPTION>';
							}else{ if($num == 0){
							echo '<OPTION value='.$row_position['position'].'>'.$row_position['position'].'</OPTION>';
							}
									}
							}
						?>
						</SELECT>
						</div>
					</div>
				</div>
						<div style="margin-top:15px;padding:5px;border-radius:5px 5px 5px 5px;padding-top:15px;float:right;width:45%;border:0.1em solid #ccc;"><div style="margin-top:-25px;">Дополнительные параметры</div>
						<?
						@include('../'.$row['option']);
						?>		
</div>						
					
					
					</div>
				</form>
		</div>	
			<?
			
	die;
	
		}
	}else{
	//Если не найден $_GET['id'] 
	}
}
	$sql = mysql_query("SELECT * from `module`");
		$num = mysql_num_rows($sql);
			echo '<div class=block_mini_all><div class=block_mini><a class=block_mini_a href="?skill=upload"><img src="tmp/img/add.png">Загрузить модуль</a></div>';
			echo '<div class=block_mini_all style="width:50%;"><div class=block_mini><a class=block_mini_a href="?skill=add"><img src="tmp/img/add_mod.png">Создать модуль</a></div></div>';
			echo '<div id=point_block>';
			echo '<div class=materials_title>Просмотр модулей</div>';
			for($i=0;$i<$num;$i++){		
			$row = mysql_fetch_assoc($sql);
				echo '<div style="float:left;width:100%;" class=module_name><a style="float:left;" class=module_name_a href="?skill=edit&id='.$row['id'].'">'.$row['name'].'</a></div>';
			}
			echo '</div>';
   ?> 
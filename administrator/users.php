

<style type="text/css">
#content > div {display: none;}
#content{
	position:absolute;
	margin:-20px;
	
	
}
</style>

<script type='text/javascript'>

function show(id) {
document.getElementById(id).style.display='block';
}
function hide(id) {
document.getElementById(id).style.display='none';
	
	
	
}

</script>
<?
 /*
 *
 ******Менеджер пользователей****
 *
 */
 require_once("tmp/temp.php");

template('Менеджер пользователей');
@$row = mysql_fetch_assoc(mysql_query('SELECT  `id`,`login`,`lname`,`lname`,`rule`,`email` from `users` WHERE id='.$_GET['id'].''));
	function window($lname,$input){
	?>
<div class="bubek">      
	  <a onclick="show('<?=$lname;?>');document.form.<?=$input?>.focus();" href="#hide"><?=$lname;?></a>    

</div>

<div id='content'>
    <div id="<?=$lname?>" style="">
	<form lname=form method=GET>
	<input type=hidden name=skill value=edit>
	<input type=hidden name=id value=<?=$_GET['id']?>>
	<input type=hidden name=act value='POST'>
	<input type=hidden name=type value='<?=$input?>'>
	<input type=text name=title value=<?=$lname;?> onMouseLeave="hide('<?=$lname?>')" onfocus="if (value == 'Ссылка') {value =''}">
	</form>
	</div>
    
</div>

<?
		
	}

	$sql = mysql_query("SELECT  `id`,`login`,`lname`,`lname`,`rule`,`email` from `users`");
	$num = mysql_num_rows($sql);
if($_GET['skill'] == 'edit'){
	if($_GET['act'] === 'POST'){
		$sql_rule = mysql_query("SELECT * from `users` where `rule`='1'");
		$num_rule = mysql_num_rows($sql_rule);

		if($_GET['rule']){		

			$sql = mysql_query("UPDATE `users` SET `rule` = '".$_GET['rule']."' WHERE id=".$_GET['id']."");
		
		}else {
			$sql = mysql_query("UPDATE `users` SET `".$_GET['type']."` = '".$_GET['title']."' WHERE id=".$_GET['id']."");
		}

			
		
	}
		if((int)$_GET['id']){
		$row = mysql_fetch_assoc(mysql_query('SELECT  `id`,`login`,`lname`,`fname`,`rule`,`email` from `users` WHERE id='.$_GET['id'].''));
			
			$lname = addslashes(htmlspecialchars($row['lname']));
			?>
			<div class=users_edit_block>
				<div class="users_edit_point_one">Имя:</div><div class="users_edit_point_two"><?=window($row['fname'],'fname');?></div>
				<div class="users_edit_point_one">Фамилия:</div><div class=users_edit_point_two><?=window($row['lname'],'lname');?></div>
				<div class="users_edit_point_one">E-mail:</div><div class=users_edit_point_two><?=window($row['email'],'email');?></div>
				<div class="users_edit_point_one">Группа:</div>
				<form>
				<input type=hidden name=skill value=edit>
	<input type=hidden name=id value=<?=$_GET['id']?>>
	<input type=hidden name=act value='POST'>
				<SELECT name=rule class=users_edit_point_two>
				<?
					if($row['rule'] !== '1'){?><option value="1"><div class="users_edit_point_two">admin</div></option><?}else{?><option value="1" SELECTED><div class="users_edit_point_two">admin</div></option><?}?>
				<?if($row['rule'] !== '3'){?><option value="3"><div class="users_edit_point_two">user</div></option><?}else{?><option value="3" SELECTED><div class="users_edit_point_two">user</div></option><?}?>
				
				</SELECT>
				<input value='' class=users_edit_point_submit type=submit>
				</form>
				
			</div>
			
			<?
		}
	die;
}	
		
 //echo '<div class=block_mini_all><div class=block_mini><a class=block_mini_a href=addmaterials.php><img src="tmp/img/add.png">Добавить материал</a></div>';
	 
	 echo '<div id=point_block><div class=materials_title>Просмотр пользователей</div>';
		?>
		<div class=users_block>
		<?
	for($i=0;$i<$num;$i++){
$row = mysql_fetch_assoc($sql);	
	if($row['rule'] == 'admin'){
			$rule = '<div style=color:red;font-size:9pt;>Админинистратор</div>';
		}else $rule = '<div style=color:black;font-size:9pt;>Пользователь</div>';
	
		echo "<div class=users_lname_".$row['rule']."><a class=materials  href='users.php?skill=edit&id=".$row['id']."'>".$row['lname']." ".$row['fname']."</a><div style='color:gray;margin-left:150px;'>Логин:<b>".$row['login']."</b></div></div>
		".$rule."
		<hr color=#cccccc><br />";
		}
		?>
		
		
		
		
		</div>
<?

?>
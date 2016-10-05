<?
require_once("tmp/temp.php");

template('Общие настройки');

$sql = mysql_query("SELECT * from `site_info`");
$row = mysql_fetch_assoc($sql);

if(isset($_GET['CHECKED'])){
	$site_name = addslashes($_GET['site_name']);
	
	$sql = mysql_query("UPDATE `site_info` SET `title_site`='".$site_name."'");
	if($sql){
		popup("Настройки успешно сохранены",'option.php');
	}
}
?>
<div class=option_block>
<form method=GET>
	<div class="option_pt">Название сайта</div><div class="option_input"><input name="site_name" type="text" value="<?echo htmlspecialchars($row['title_site'])?>"></div><br><br>
	<br>
	<input name="CHECKED" class="option_input_submit" type=submit value='Сохранить'>
</form>
</div>
<?
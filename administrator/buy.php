<?php
	 require_once("tmp/temp.php");

template('Менеджер покупок');
if($_GET['id']){
	if((int)$_GET['id']){
		if(!$_GET['time']){
		$sqlCom = mysql_query("SELECT * from `mod_basket_buy_commande` WHERE `id_user`=".$_GET['id']."");
		$numCom = mysql_num_rows($sqlCom);
		for($i=0;$i<$numCom;$i++){
		$rowCom = mysql_fetch_assoc($sqlCom);
			echo '<a href="buy.php?id='.$_GET['id'].'&time='.$rowCom['date_time'].'">'.$rowCom['date_time'].'</a><br />';
		
		}
			exit;
		}
?>

	<?$sqlUser = mysql_query("SELECT * from `users` WHERE `id`=".$_GET['id']."");
				$row_users = mysql_fetch_assoc($sqlUser);
					$sqlPhone = mysql_query("SELECT * from `mod_basket_buy_commande` WHERE `id_user`=".$_GET['id']." and `date_time`='".$_GET['time']."'");
					$rowPhone = mysql_fetch_assoc($sqlPhone);
				?>
				Заказчик: <b><?=$row_users['name']?> <?=$row_users['family']?></b><br />
				Контактный телефон: <b><?=$rowPhone['phone']?></b><br />
				Адрес: <b><?=$rowPhone['adress']?></b>
				<?
		$sqlCom = mysql_query("SELECT * from `mod_basket_buy_commande` WHERE `id_user`=".$_GET['id']." and `date_time`='".$_GET['time']."'");
		$numCom = mysql_num_rows($sqlCom);
		?><table class=table_buy CELLPADDING=5px>
<tr><td><b>Номер(id):</b><hr></td><td><b>Товар:</b><hr></td><td><b>Цена(за 1 шт.) руб.:</b><hr></td><td><b>Кол-во в шт.:</b><hr></td><td><b>Сумма руб.:</b><hr></td>
<?
		for($i=0;$i<$numCom;$i++){
		$rowCom = mysql_fetch_assoc($sqlCom);
		
			
			
			
				
				$sqlMat = mysql_query("SELECT * from `materials` WHERE `id`=".$rowCom['id_goods']."");				
				$row_materials = mysql_fetch_assoc($sqlMat);
			
			?>
			
			<div class=buy_block>
				
			<tr>
			
			<td>
			<div style="text-align:center;"><?=$rowCom['id']?></div><hr color="#cccccc">
			</td>
					<td>
					<a href="../index.php?layer=materials&id=<?=$row_materials['id']?>" target=blank><?=$row_materials['name']?><br><hr color="#cccccc">
					</td>
					<td>
					<?=$row_materials['money']?><br><hr color="#cccccc">
					</td>
					<td>
					<?=$rowCom['amount']?><br><hr color="#cccccc">
					</td>
					<td>
					
					<?=$row_materials['money']*$rowCom['amount']?><br><hr color="#cccccc">
					</td>
			</tr>
				
			</div>
			<?
				$sum += $row_materials['money']*$rowCom['amount'];
			}
			
			
	?>
	<tr><td colspan=100%><div style="text-align:right;font-weight:bold;">Итого руб.:</div></td></tr>
	<tr><td colspan=100%><div style="text-align:right;"><?=$sum?></div></td></tr>
</table>

<?
	}else echo "Неправильный формат";
}else{

$sql = mysql_query("SELECT * from `mod_basket_buy_commande`");
$num = mysql_num_rows($sql);
for($i=0;$i<$num;$i++){
$row = mysql_fetch_assoc($sql);
$countar = count($ArrayUSER);
	$ArrayUSER[$countar+1] = $row['id_user'];  	
$ArrayUSER = array_unique($ArrayUSER);
	}
	echo "<div class=buy_block>Заказы:<br />";
	if($num == 0){
		echo "<b>Заказов нет!</b>";
	}
  
	for($i=0;$i<count($ArrayUSER);$i++){
		$sqlUser = mysql_query("SELECT * from `users` WHERE `id`=".$ArrayUSER[count($ArrayUSER)-$i]."");
		$rowUser = mysql_fetch_assoc($sqlUser);
		echo "<a href='buy.php?id=".$rowUser['id']."'>".$rowUser['name']." ".$rowUser['family']."</a><br />";
	}
	
	
	

		


}
?>
<?
//index.php - главный файл модуля который инклудиться

?>
<div class="boxradius">

			<div class="select">
				Название товара <input type="text" class="priceform" value="" id="querysearch" > 
			</div>
			<div style="text-align:right;"><button class="filter-button" onClick="ajaxRequest('findproduct',0,0,0,0,$('#querysearch').val(),0,0)">искать</button></div>
			
</div>
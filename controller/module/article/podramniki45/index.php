</div>
<div class="ui grid">
		<div class="four wide column" >
			<div class="htext">
			<a id="catalogajax" onclick="switch_module('search');" class="nonelink">КАТАЛОГ</a> \ 
			<a id="searchajax" 	onclick="switch_module('catalog');" class="link">ПОИСК</a></div>
			<div id="leftblock">
				<div id="filter"><?strong::$template->includeModule("filter",array('idcategory'=>1));?></div>
				<div id="search" class="nonevisible"><?strong::$template->includeModule("search");?></div>
			</div>
		</div>
				

		<div class="ten wide column">
			<div class="ui grid">
	   			<div class="sixteen wide column">
	   				<div style="margin-left:75px;"><img src="image/<?=$product[0]['image']['info']['src']?>" width="250px"></div>
	   			</div>
	   			<div class="sixteen wide column">
	   				<div class="ui grid">
	   					<div class="six wide column">
	   						
	   					</div>

	   					<div class="ten wide column">
							<p><b>Материал:</b> сосна цельная высшего сорта</p>
							<p><b>Производитель:</b> Собственное производство, Россия;</p>
							<p><b>Ширина:</b> 45мм</p>
							<p><b>Толщина:</b> 19 мм</p>
	   					</div>
	   					<form method="GET">
	   						<input type="hidden" name="p" value="action">
	   						<input type="hidden" name="act" value="adduserproduct">
		   					<input type="hidden" name="idcategory" value="13">
			   				Длина:<input type="text" id="wnumber" name="width" size=3/>
			   				Ширина:<input type="text" id="hnumber" name="height" size=3/><br/ >
			   				<p align='center'><b>Цена:</b> <span id="numbersum">0</span> руб.</p><br />
			   				<input type="submit" value="Заказать">
		   				</form>
	   				</div>

	   			</div>
	   		</div>
		</div>
		<div class="ten wide column">
			<div class="sixteen wide column">
				<h1 style="margin-bottom:25px;"><?=$product[0]['title']?></h1>
			</div>
			<div class="sixteen wide column">
				<div class="ui grid">
				
				
			</div>
		</div>



	</div>
<script>
	$("#wnumber").keyup(function(){$("#numbersum").html( Math.ceil( ( Number($("#wnumber").val()) + Number($("#hnumber").val()) )*(1.6)) )})
	$("#hnumber").keyup(function(){$("#numbersum").html( Math.ceil( ( Number($("#wnumber").val()) + Number($("#hnumber").val()) )*(1.6)) )})
</script>

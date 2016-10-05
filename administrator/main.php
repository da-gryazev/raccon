<?php
	require_once("tmp/temp.php");

template('Панель управления');

   ?>
     <html>
	 <head><title></title></head>
		<body>
					
			
			<div class=admin_block><a href=addmaterials.php class=admin_block_a><img src="tmp/img/icon_addmaterials.png">Добавить материал</a></div>
			<div class=admin_block><a href=edit.php class=admin_block_a><img src="tmp/img/icon_materials.png">Менеджер материалов</a></div>
			<div class=admin_block><a href=menu.php class=admin_block_a><img src="tmp/img/icon_menu.png">Менеджер меню</a></div>
			<div class=admin_block><a href=kategorii.php class=admin_block_a><img src="tmp/img/icon_kategorii.png">Менеджер категорий</a></div>
			<div class=admin_block><a href=module.php class=admin_block_a><img src="tmp/img/icon_module.png">Менеджер модулей</a></div>
			<div class=admin_block><a href=temp.php class=admin_block_a><img src="tmp/img/icon_temp.png">Менеджер шаблонов</a></div>
			<div class=admin_block><a href=users.php class=admin_block_a><img src="tmp/img/icon_users.png">Менеджер пользователей</a></div>
			<div class=admin_block><a href=characters.php class=admin_block_a><img src="tmp/img/icon_chr.png">Менеджер характеристик</a></div>
			<div class=admin_block><a href=buy.php class=admin_block_a><img src="tmp/img/icon_buy.png">Менеджер покупок</a></div>
			
		    
		 
		</body>
	</html>
   
   <?

?>
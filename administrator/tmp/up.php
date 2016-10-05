<?php
   function up($title){
  
   ?>
   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
   <html>
   <head>
   
   <link rel="stylesheet" type="text/css" href="tmp/style/style.css">
   <link rel="stylesheet" type="text/css" href="tmp/style/menu.css">
  
   <title><? echo $title; ?></title>
   <?
   require_once('function/function.php');
	TinyMCE();
   ?>
	
   
   </head>
   <body>
   <div id=container>
   <div class=logo-txt><a href=main.php><img src="tmp/img/logo.png"></a><div class=logininfo><?php
   if(isset($_SESSION['login'])){
   echo 'Вы вошли под именем: <div style="font-weight:bold; float:right;">'.$_SESSION['login'].'</div><br>';
   echo '<a href=?skill=exit>Выход</a>';
	
   }else{ header("Location:index.php");}
   ?></div>
	<ul id="cssmenu">
	<li><a href="#">Сайт</a>
                <ul>
                        <li><a href=".." target="_blank">Перейти на сайт</a></li>
                        <li><a href="option.php">Общие настройки</a></li>
                        
                </ul>
        </li>
        <li><a href="kategorii.php">Менеджер категорий</a>
                <ul>
                        <li><a href="kategorii.php?skill=add"><img src="tmp/img/plus.png" >Добавить</a></li>
                        <li><a href="kategorii.php">Редактировать</a></li>
                </ul>
        </li>
        <li><a href="edit.php">Менеджер материалов</a>
                <ul>
                        <li><a href="addmaterials.php"><img src="tmp/img/plus.png" >Добавить</a></li>
                        <li><a href="editmaterials.php">Редактировать</a></li>
                        
                </ul>
        </li>
         <li><a href="menu.php">Менеджер меню</a>
                <ul>
                        <li><a href="addmenu.php?skill=add"><img src="tmp/img/plus.png" >Добавить</a></li>
                        <li><a href="addmenu.php?skill=edit">Редактировать</a></li>
                        
                </ul>
        </li>
		<li><a href="module.php">Менеджер модулей</a>
                <ul>
                        <li><a href="module.php?skill=upload"><img src="tmp/img/plus.png" >Загрузить</a></li>
                        
                        
                </ul>
        </li>
		<li><a href="temp.php">Менеджер шаблонов</a>
                <ul>
                        <li><a href="temp.php?skill=upload"><img src="tmp/img/plus.png" >Загрузить</a></li>
                        
                        
                </ul>
        </li>
		<li><a href="users.php">Менеджер пользователей</a>
                <ul>
                        <li><a href="users.php">Пользователи</a></li>
                        
                        
                </ul>
        </li>
		<li><a href="characters.php">Менеджер характеристик</a>
                <ul>
                        <li><a href="characters.php?skill=add"><img src="tmp/img/plus.png">Добавить</a></li>
                        
                        
                </ul>
        </li>
		
</ul>

</div>
   
   
   
   
   <?
   
   }
?>
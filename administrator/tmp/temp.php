<?php
 
 //Главный шаблон страницы состоящий из блоков up.php || footer.php || menu.php

   function template($title){
  
@ session_start();
   require_once "conf/conf.php";
   require_once "conf/function.php";
   require_once "up.php";
  
  @$db = mysql_connect($db_host,$db_name,$db_pass);
   if(!$db){
   echo '<h1 align=center>Извините! Непридвиденная ошибка с базой данных!</h1>';
   die;
   }
   mysql_query("SET NAMES utf8");
   mysql_select_db($table_name);
   if($_GET['skill'] == 'exit'){
	session_unset('login');
   }
  #$sqlMain = mysql_query("SELECT * from `html_info`");
  #$rowMain = mysql_fetch_assoc($sqlMain);
   if(!isset($_SESSION['login'])){
	?>
	<script>location.href="index.php";</script>
   <?
   }
  
  up($rowMain['site_name']." - ".$title);
 echo '<div class=body_file>';
 echo '<div class=title>'.$title.'</div>';
  

  
  
 
  
  }
  
  

?>
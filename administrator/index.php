<?
session_start();
	if(isset($_SESSION['login']) and isset($_SESSION['pass'])){
		header("Location: main.php");
	}
  require_once "conf/function.php";
  
  ?>


<html>
	<head>
	<link rel="stylesheet" type="text/css" href="tmp/style/style.css">
   <link rel="stylesheet" type="text/css" href="tmp/style/menu.css">
	<title>Администрирование</title></head>
		<body>
		<div class=logo-txt style="margin-bottom:25px;">Панель управления</div>
		<NOSCRIPT><?php popup('Для использования панели управления включите поддержку JavaScript','');?></NOSCRIPT>
			<form name=admform align=center method=POST action=reg.php>
			<input type=text name=login value=Логин >
			<input type=password name=pass value=Пароль>
			<input type=submit value=Вход>
			</form>
		</body>
</html>
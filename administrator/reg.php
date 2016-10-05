<?php
 session_start();
   

 require_once "conf/conf.php";
	
	
$db = mysql_connect($db_host,$db_name,$db_pass);

if(!$db){die;}

   mysql_select_db($table_name);
   
   
   if($_POST['login'] and $_POST['pass']){
   $login = $_POST['login'];
   $pass = md5("raccon_".$_POST["pass"]);
  
     //Проверка вводимых пары логин-пароль
        $sql = mysql_query("SELECT * from `users` where `login` = '".$login."' AND `password`='".$pass."' AND `rule`=1");  
        echo "SELECT * from `users` where `login` = '".$login."' AND `password`='".$pass."' AND `rule`=1";
		$num = mysql_num_rows($sql);
		echo $num;
		if($num==0)$error="Ошибка";else{
			$_SESSION['login'] = $_POST['login'];
			$_SESSION['pass'] = $_POST['pass'];	
			header("Location: main.php");
		}

		if($error == 'Ошибка'){
			header("Location: index.php");
		}  
  }

?>
<?php 
session_start();
setcookie("name","",time()-3600);
session_destroy();

header("location:login.php");

?>
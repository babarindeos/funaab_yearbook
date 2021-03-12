<?php

// after is_login_auth
// is_login_auth has session_start() in it

if(!(isset($_SESSION['myLogin']) && $_SESSION['myLogin']=='student1989')){
  header("location:{$baseUrl}signin.php");
}
 ?>

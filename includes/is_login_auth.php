<?php
      session_start();

      if(!(isset($_SESSION['ulogin_state']) && $_SESSION['ulogin_state']!='')){
        header("location:{$baseUrl}index.php");
      }
?>

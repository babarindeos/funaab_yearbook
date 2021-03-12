<?php
    $link = "../config/init_wp.php";
    $config_path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"students_clearance")+5)))));

    // require_once("../".$config_path);
    require_once($link);

 ?>

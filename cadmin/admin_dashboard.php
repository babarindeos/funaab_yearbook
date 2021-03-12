<?php
    $page_title = 'Admin Dashboard';

    $link = "../core/wp_config.php";
    $core_path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"siwes")+5)))));

    require("../core/wp_config.php");
    require_once("../nav/admin_nav.php");







?>




<?php
    //footer.php
    require('../includes/footer.php');
 ?>

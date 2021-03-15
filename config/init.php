<?php
  // Website configuration without login session

  // Base Url
  require_once("baseurl.php");

  // Functions - Includes directory
  require_once("functions/FieldSanitizer.php");
  require_once("functions/Alerts.php");

  // Interfaces - Interface directory
  require_once("interface/AuthInterface.php");
  require_once("interface/DBInterface.php");
  require_once("interface/CollectionInterface.php");
  require_once("interface/PaymentInterface.php");
  require_once("interface/ApplicantInterface.php");
  require_once("interface/AcademicSessionInterface.php");
  require_once("interface/RegistrationInterface.php");
  require_once("interface/MailInterface.php");
  require_once("interface/UserInterface.php");

  // Abstract - Abstract directory
  require_once("abstract/Database.php");
  require_once("abstract/User.php");

  // Class Autoload
  spl_autoload_register('classAutoLoader');

  function classAutoLoader($class){
      $path = "classes/";
      $class = "{$path}{$class}.php";
      include_once($class);
  }

 ?>

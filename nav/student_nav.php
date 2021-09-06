<?php
    $studentData = $_SESSION['studentData'];

    $user_photo = '';
    if ($studentData['photo']==''){
      $user_photo = $baseUrl."images/avatars/avatar-2.jpg";
    }else{
      $user_photo = substr($studentData['photo'],1);
      $user_photo = "https://portal.unaab.edu.ng{$user_photo}";
    }






 ?>
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark lighten-1" style="background-color:#006600;">
  <a class="navbar-brand" href="#" id="logged-in-header-title"><img width='15%' src="<?php echo $baseUrl; ?>assets/images/FUNAAB-Logosm.png" class="d-inline-block align-middle">FUNAAB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
    aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>




  <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
    <ul class="navbar-nav mr-auto">

            <!-- Profile Update //-->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $baseUrl.'student/profile_update.php'; ?>">My YearBook Data
                  <!-- <span class="sr-only">(current)</span> //-->
                </a>
            </li>
            <!-- end of Profile Update //-->





    </ul>



  </div>



  <ul class="navbar-nav ml-auto nav-flex-icons">
    <!--
    <li class="nav-item">
      <a class="nav-link waves-effect waves-light">
        <i class="fas fa-envelope"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link waves-effect waves-light">
        <i class="fas fa-comments"></i>
      </a>
    </li>
    //-->

    <li class="nav-item avatar dropdown notification-bar-item">
          <a class="nav-link dropdown-toggle dropdown-menu-right" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <!--<img src="<?php // echo $baseUrl."images/avatars/avatar-2.jpg";  ?>" class="img-fluid rounded-circle z-depth-0"
              alt="My Avatar" > //-->

            <img src="<?php echo $user_photo  ?>" class="img-fluid rounded-circle z-depth-0"
              alt="My Avatar" >
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left dropdown-success"
            aria-labelledby="navbarDropdownMenuLink-55">
            <a class="dropdown-item" href="<?php echo $baseUrl.'student/my_profile.php'; ?>"> <i class="far fa-user"></i> Profile</a>
            <!--<a class="dropdown-item" href="#"> <i class="fas fa-key"></i> Change Password</a> //-->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $baseUrl.'logout.php'; ?>" > <i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
    </li>
  </ul>




</nav>
<!--/.Navbar -->

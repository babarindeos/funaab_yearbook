
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark lighten-1" style="background-color:#006600;">
  <a class="navbar-brand" href="#" id="logged-in-header-title"><img width='15%' src="<?php echo $baseUrl; ?>assets/images/FUNAAB-Logosm.png" class="d-inline-block align-middle">FUNAAB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
    aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>




  <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
    <ul class="navbar-nav mr-auto">
      <!-- Home Sample
      <li class="nav-item active">
        <a class="nav-link" href="#">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <!-- end of Home Sample //-->

      <!-- Office menu
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">Personnel Record
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php //echo $baseUrl.'staff/records/personal_info.php'; ?>"> <i class="fas fa-users"></i> Personal</a>
          <a class="dropdown-item" href="<?php //echo $baseUrl.'staff/records/professional_info.php'; ?>"> <i class="fas fa-list-ol"></i> Professional</a>
          <a class="dropdown-item" href="#"> <i class="far fa-list-alt"></i> Training</a>
          <a class="dropdown-item" href="#"> <i class="far fa-list-alt"></i> Leave </a>
        </div>
      </li>
      <!-- end office menu //-->


      <!-- Dashboard //-->
      <li class="nav-item">
        <a href="<?php echo $baseUrl.'staff/unit_dashboard.php'; ?>" class="nav-link" id="navbarDropdownMenuLink-555" 
          aria-haspopup="true" aria-expanded="false">Dashboard
        </a>

      </li>
      <!-- end of dashboard //-->


      <!-- Dashboard //-->
      <li class="nav-item">
        <a href="<?php echo $baseUrl.'staff/clearing_division.php'; ?>" class="nav-link" id="navbarDropdownMenuLink-555"
          aria-haspopup="true" aria-expanded="false">Clearance Division
        </a>

      </li>
      <!-- end of dashboard //-->

      <!-- Projects menu
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">  APER
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php //echo $baseUrl.'staff/aper/aper_form.php'; ?>"> <i class="fas fa-suitcase"></i> Fill form</a>
          <a class="dropdown-item" href="#"> <i class="far fa-comments"></i> History</a>
        </div>
      </li>
      <!-- end projects menu //-->

      <!-- Projects menu
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">  Career
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="#"> <i class="fas fa-suitcase"></i> Job history</a>

        </div>
      </li>
      <!-- end projects menu //-->

      <!-- Message menu //-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">  Messages
        </a>
        <div class="dropdown-menu dropdown-success" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php echo $baseUrl.'staff/messaging/message_inbox.php'; ?>" > <i class="far fa-envelope"></i> Inbox</a>
          <a class="dropdown-item" href="#"> <i class="far fa-comments"></i> Send Message</a>

        </div>
      </li>
      <!-- end projects menu //-->


    </ul>



  </div>



  <ul class="navbar-nav ml-auto nav-flex-icons">
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
    <li class="nav-item avatar dropdown notification-bar-item">
          <a class="nav-link dropdown-toggle dropdown-menu-right" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo $baseUrl."images/avatars/avatar_100.jpg";  ?>" class="img-fluid rounded-circle z-depth-0"
              alt="My Avatar" >
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left dropdown-success"
            aria-labelledby="navbarDropdownMenuLink-55">
            <a class="dropdown-item" href="<?php echo $baseUrl.'staff/profile/my_profile.php?q='.mask($_SESSION['ulogin_userid']); ?>"> <i class="far fa-user"></i> Profile</a>
            <a class="dropdown-item" href="<?php echo $baseUrl.'staff/profile/change_password.php?q='.mask($_SESSION['ulogin_userid']); ?>"> <i class="fas fa-key"></i> Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $baseUrl.'logout.php'; ?>"> <i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
    </li>
  </ul>




</nav>
<!--/.Navbar -->

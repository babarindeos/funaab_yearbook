
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark primary-color lighten-1">
  <a class="navbar-brand" href="#" id="logged-in-header-title">WorkForce</a>
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
          aria-haspopup="true" aria-expanded="false">Records
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php echo $baseUrl.'/records/personal_info.php'; ?>"> <i class="fas fa-users"></i> Personnel</a>
          
        </div>
      </li>
      end office menu //-->

      <!-- Projects menu //-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">  APER
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php echo $baseUrl.'hod/aper/personnels.php'; ?>"> <i class="fas fa-suitcase"></i> Forms</a>
          <a class="dropdown-item" href="#"> <i class="far fa-comments"></i> History</a>
        </div>
      </li>
      <!-- end projects menu //-->

      <!-- Projects menu //-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">  Analytics
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="#"> <i class="fas fa-suitcase"></i> Individual Statistics</a>
          <a class="dropdown-item" href="#"> <i class="fas fa-suitcase"></i> Group Statistics</a>
          
        </div>
      </li>
      <!-- end projects menu //-->

      <!-- Projects menu //-->
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
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="#"> <i class="fas fa-suitcase"></i> Send Message</a>
          <a class="dropdown-item" href="#"> <i class="far fa-comments"></i> Inbox</a>
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
            <img src="<?php echo $baseUrl."images/avatars/avatar-2.jpg";  ?>" class="img-fluid rounded-circle z-depth-0"
              alt="My Avatar" >
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left dropdown-secondary"
            aria-labelledby="navbarDropdownMenuLink-55">
            <a class="dropdown-item" href="#"> <i class="far fa-user"></i> Profile</a>
            <a class="dropdown-item" href="#"> <i class="fas fa-key"></i> Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
    </li>
  </ul>




</nav>
<!--/.Navbar -->

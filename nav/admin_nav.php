
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark lighten-1" style="background-color:#006600;">
  <a class="navbar-brand" href="<?php echo $baseUrl.'cadmin/admin_dashboard.php'; ?>" id="logged-in-header-title"><img width='15%' src="<?php echo $baseUrl; ?>assets/images/FUNAAB-Logosm.png" class="d-inline-block align-middle"> FUNAAB</a>
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

      <li class="nav-item">
        <a class="nav-link" id="navbarDropdownMenuLink-555"
          aria-haspopup="true" aria-expanded="false" href="<?php echo $baseUrl.'cadmin/admin_dashboard.php'; ?>"> Dashboard
        </a>
      </li>

      <!-- Office menu //-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"> Staff
        </a>

        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php echo $baseUrl.'cadmin/staff/create_staff.php'; ?>" > <i class="fas fa-user-plus"></i> Create Staff</a>
          <a class="dropdown-item" href="<?php echo $baseUrl.'cadmin/staff/staff_records.php'; ?>" > <i class="fas fa-users"></i> Staff Records</a>

        </div>
      </li>
      <!-- end office menu //-->

      <!-- Project menu //-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"> Students
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="<?php echo $baseUrl.'cadmin/student/submissions.php'; ?>"> <i class="fas fa-suitcase"></i> Submissions</a>
          


        </div>
      </li>
      <!-- end project menu //-->



      <!-- Message menu //-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-555" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">Messages
        </a>
        <!-- comment out
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink-555">
          <a class="dropdown-item" href="#"> <i class="far fa-edit"></i> Compose </a>
          <a class="dropdown-item" href="#"> <i class="far fa-envelope"></i> Inbox (0)</a>
          <a class="dropdown-item" href="#"> <i class="far fa-envelope-open"></i> Outbox (0)</a>
          <a class="dropdown-item" href="#"> <i class="far fa-trash-alt"></i> Trash (0)</a>
        </div>
      </li>
      <!-- end message menu //-->





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
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs-right dropdown-menu-sm-right dropdown-menu-lg-left dropdown-secondary"
            aria-labelledby="navbarDropdownMenuLink-55">
            <a class="dropdown-item" href="#"> <i class="far fa-user"></i> Profile</a>
            <a class="dropdown-item" href="#"> <i class="fas fa-key"></i> Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $baseUrl ?>admin_login.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
    </li>
  </ul>
</nav>
<!--/.Navbar -->

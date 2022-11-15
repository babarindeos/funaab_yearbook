<?php
    function successAlert($title="",$message,$footer="")
    {
    ?>
        <div class='alert alert-success' role='alert'>
            <?php if($title!=""){ ?>
                <h4 class='alert-heading'><?php echo $title; ?></h4>
            <?php } ?>
            <p>
                <?php echo $message; ?>
            </p>
            <?php if($footer!=""){ ?>
                <?php echo $footer; ?>
            <?php } ?>


        </div>

    <?php
    }


  function miniSuccessAlert($message){
    ?>
        <div class="alert alert-warning" role="alert">
            <i class="far fa-clock"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>
        </div>

    <?php
  }


  function miniApprovedAlert($message){
    ?>
        <div class="alert alert-success" role="alert">
            <i class="far fa-check-circle"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>
        </div>

    <?php
  }

  function miniPendingAlert($message){
    ?>
        <div class="alert alert-info" role="alert">
            <i class="fas fa-question"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>
        </div>

    <?php
  }

  function miniDeclinedAlert($message){
    ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-times"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $message; ?>
        </div>

    <?php
  }


  function miniErrorAlert($message){
    ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp; <?php echo $message; ?>
        </div>

    <?php
  }



  function errorAlert($title="",$message,$footer="")
  {
    ?>
        <div class='alert alert-danger' role='alert'>
            <?php if($title!=""){ ?>
                <h4 class='alert-heading'><?php echo $title; ?></h4>
            <?php } ?>
            <p>
                <?php echo $message; ?>
            </p>

            <?php if($footer!=""){ ?>
                <?php echo $footer; ?>
            <?php } ?>


        </div>

    <?php
  }

?>

<?php
  if(isset($_GET['action'])){
    $action = $_GET['action'];
    if($action === 'add') {
      $title = 'Add teacher';    
    }
   } else {
  }

  if(isset($_POST['submit_register'])) {
    $register_result = System::callAPIOrigin(System::API_CODE['USER'], 'register', array(
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'role' => 'Teacher'
    ), false);

    if($register_result->response_status) {
      $user_data = System::callAPI(System::API_CODE['USER'], 'edit', array(
      'name' => $_POST['name'],
      'surname' => $_POST['surname'],
      'user_id' => $register_result->response_data[0]->user_id
    ), false);

      System::notification('Add Teacher success', 'success');
      System::redirect('manageuser.php');
    } else {
      System::notification('Username already exists.', 'error');
    }
  }
?>


  <!--content area start-->
  <div id="content" class="pmd-content inner-page">
    <div class="container-fluid full-width-container">
      <div class="row">
        <div class="col-sm-push-2 col-sm-8 col-xs-offset-0 col-xs-12">
          <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-01-blue.svg" alt="" class="img-responsive">
            </div>
            <span class="media-middle">
              <?php echo $title; ?>
            </span>
          </h1>
        </div>
        <div class="col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12">
          <div class="section-content">
            <div class="row">
              
              <form action="" method="POST" class="form-horizontal has-validator" role="form" data-toggle="validator">

                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">Name</label>
                  <input type="text" id="name" name="name" class="form-control" required>
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">Surname</label>
                  <input type="text" id="surname" name="surname" class="form-control" required>
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>

                <div class="form-group col-xs-12">
                    <label for="" class="control-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>

                <div class="form-group col-xs-12">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="" maxlength="20" required>
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>

                <div class="form-group col-xs-12">
                    <label for="" class="control-label">Retype Password</label>
                    <input type="password" class="form-control" name="repassword" id="" placeholder="" maxlength="20" required data-match="#password"
                      data-match-error="Passwords don't match">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                  </div>

                <div class="form-group col-xs-12 text-right mt-3">
                  <button name="submit_register" type="submit" class="btn btn-default-fill">Add Teacher</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- content area end -->
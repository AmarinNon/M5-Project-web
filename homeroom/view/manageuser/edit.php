<?php
  if($user->role === 'Teacher'){
    if(isset($_GET['action']) && isset($_GET['id'])){
      $input_id = $_GET['id'];
      if($input_id != $user->user_id) {
        System::redirect('student.php');
      }
      else {}
    }
    else {
      System::redirect('student.php');
    }
  }

  if(isset($_GET['action']) && isset($_GET['id'])){
    $action = $_GET['action'];
    $user_id = $_GET['id'];
    if($action === 'edit') {
      $title = 'Edit teacher information';    
    }
   } else {
     System::redirect('manageuser.php');
  }

  $get_user = System::callAPI(System::API_CODE['USER'], 'getuserbyid', array(
    'user_id' => $user_id
  ), false);
  $user = $get_user[0];

  if(isset($_POST['submit_edit'])) {
    $edit_result = System::callAPIOrigin(System::API_CODE['USER'], 'edit', array(
    'user_id' => $user_id,
    'name' => $_POST['name'],
    'surname' => $_POST['surname']
	'img_dir' => $_POST['img_dir']
    ), false);

    if($edit_result->response_status) {
      System::notification('Edit success', 'success');
      System::redirect('manageuser.php');
    } else {
      System::notification('Username already exists.', 'error');
    }
  }

  if(isset($_POST['submit_password'])){
    $password_result = System::callAPIOrigin(System::API_CODE['USER'], 'editpassword', array(
      'user_id' => $user_id,
      'oldpassword' => $_POST['oldpassword'],
      'newpassword' => $_POST['password']
    ), false);

    if($password_result->response_status) {
      System::notification('Change passwords success', 'success');
      System::redirect('manageuser.php');
    } else {
      System::notification($password_result->response_message, 'error');
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
        <div class="section-content">
            <div class="col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12">
          <div class="row">
              <form action="" method="POST" class="form-horizontal has-validator" role="form" data-toggle="validator">
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">Name</label>
                  <input type="text" id="name" name="name" class="form-control" required value="<?php echo $user->name; ?>">
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">Surname</label>
                  <input type="text" id="surname" name="surname" class="form-control" required value="<?php echo $user->surname; ?>">
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-xs-12 text-right mt-3">
                  <button name="submit_edit" type="submit" class="btn btn-default-fill">Save data</button>
                </div>
              </form>
            </div>
            </div>
            <div class="col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12">
            <div class="row">
              <form action="" method="POST" class="form-horizontal has-validator" role="form" data-toggle="validator">
                <div class="form-group col-xs-12">
                    <label for="" class="control-label">Current Password</label>
                    <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="" maxlength="20" required>
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
                      data-match-error="รหัสผ่านไม่ตรงกัน">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                  </div>
                <div class="form-group col-xs-12 text-right mt-3">
                  <button name="submit_password" type="submit" class="btn btn-default-fill">Change password</button>
                </div>
              </form>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- content area end -->
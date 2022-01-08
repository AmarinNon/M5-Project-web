<?php
  $user = System::get_current_user();

  if(isset($_GET['action'])){
    $action = $_GET['action'];
    if($action === 'add') {
      $title = 'Add data';    
    }
   } else {
  }

  if(isset($_POST['submit_register'])) {
    $register_result = System::callAPIOrigin(System::API_CODE['USER'], 'register', array(
    'username' => $_POST['username'],
    'password' => $_POST['username'],
	
    'role' => 'Student'
    ), false);

    if($register_result->response_status) {
      $student_id = $register_result->response_data[0]->user_id;
      $user_data = System::callAPI(System::API_CODE['USER'], 'edit', array(
        'user_id' => $student_id,
        'group' => $_POST['number'],
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'title' => $_POST['prefix'],
		'img_dir'  => $_POST['img_dir'],
        'log_value1' => 'homeroom',
		
        'log_id1' => System::session('homeroom_id')
       ), false);

       $register_parent = System::callAPIOrigin(System::API_CODE['USER'], 'register', array(
        'username' => 'P'.$_POST['username'],
        'password' => $_POST['parent_tel'],
        'role' => 'Parent'
        ), false);

        if($register_parent->response_status) {
          $parent_id = $register_parent->response_data[0]->user_id;
          $parent_data = System::callAPI(System::API_CODE['USER'], 'edit', array(
            'user_id' => $parent_id,
            'name' => $_POST['parent_name'],
            'surname' => $_POST['parent_surname'],
            'tel' => $_POST['parent_tel'],
            'email' => $_POST['parent_email']
          ), false);

          $insert_result = System::temtem(System::API_CODE['HOMEROOM'], 'student_parent', 'insert', array(
          'teacher_id' => $user->user_id,
          'student_id' => $student_id,
          'parent_id' => $parent_id
          ), false);

          if(count($insert_result) > 0) {
            System::notification('เพิ่มบัญชีสำเร็จ', 'success');
            System::redirect('student.php');
          }
        } else {

        }
    } else {
      System::notification('Username already exists.', 'error');
    }
  }
?>

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
        <div class="row">
          <form action="" method="POST" class="form-horizontal has-validator" role="form" data-toggle="validator">
            <div class="col-xs-12">
              <p class="text-blue bigger-130">Student information</p>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-4 col-xs-12">
                    <label for="" class="control-label">Number</label>
                    <input type="text" name="number" id="number" class="form-control" required maxlength="2" pattern="[0-9]+" data-pattern-error="Numeric only">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-4 col-xs-12">
                    <label for="" class="control-label">Student ID</label>
                    <input type="text" name="username" id="username" class="form-control" required maxlength="5" pattern="[0-9]+" data-pattern-error="Numeric only">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="form-group col-sm-4 col-xs-12">
              <label for="" class="control-label">Name Title</label>
              <input type="text" id="prefix" name="prefix" class="form-control" list="data_title" required>
              <datalist id="data_title">
                <option value="Mr."></option>
                <option value="Miss"></option>
              </datalist>
              <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-sm-4 col-xs-12">
              <label for="" class="control-label">Name</label>
              <input type="text" id="name" name="name" class="form-control" required>
              <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-sm-4 col-xs-12">
              <label for="" class="control-label">Surname</label>
              <input type="text" id="surname" name="surname" class="form-control" required>
              <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
			<div class="form-group col-sm-4 col-xs-12">
			  <label for="" class="control-label">Student Picture</label>
              <input type="file" id="img_dir" name="img_dir" class="smaller-80" accept="application/.jpg" />
              <div class="smaller-80">* Attach (*.jpg)</div>
            </div>
            

            <div class="col-xs-12">
              <p class="text-blue bigger-130">Parent information</p>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">Name</label>
                  <input type="text" id="parent_name" name="parent_name" class="form-control" required>
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">Surname</label>
                  <input type="text" id="parent_surname" name="parent_surname" class="form-control" required>
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="" class="control-label">E-mail</label>
                    <input type="email" name="parent_email" id="parent_email" class="form-control" required>
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="" class="control-label">Phone Number</label>
                    <input type="text" name="parent_tel" id="parent_tel" class="form-control" required maxlength="10" pattern="[0-9]+" data-pattern-error="Numeric only">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
              </div>
            </div>

            <div class="form-group col-xs-12 text-right mt-3">
              <button name="submit_register" type="submit" class="btn btn-default-fill">Add data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<?php
  if(isset($_GET['action']) && isset($_GET['id'])){
    $action = $_GET['action'];
    $user_id = $_GET['id'];
    if($action === 'edit') {
      $title = 'แก้ไขข้อมูล';    
    }
   } else {
     System::redirect('student.php');
  }

  $get_user = System::callAPI(System::API_CODE['USER'], 'getuserbyid', array(
    'user_id' => $user_id
  ), false);
  $user = $get_user[0];
  $parent = Homeroom::student_parent($user->user_id);

  if(isset($_POST['edit_student'])) {
    $edit_student_result = System::callAPIOrigin(System::API_CODE['USER'], 'edit', array(
      'user_id' => $user_id,
      'group' => $_POST['number'],
      'title' => $_POST['prefix'],
      'name' => $_POST['name'],
      'surname' => $_POST['surname'],
    ), false);

    if($edit_student_result->response_status > 0) {
      System::notification('แก้ไขข้อมูลนักเรียนสำเร็จ', 'success');
      System::redirect();
    } else {
      System::notification('การแก้ไขผิดพลาด', 'error');
    }
  }

  if(isset($_POST['edit_parent'])) {
    $edit_parent_result = System::callAPIOrigin(System::API_CODE['USER'], 'edit', array(
      'user_id' => $parent->user_id,
      'name' => $_POST['parent_name'],
      'surname' => $_POST['parent_surname'],
      'tel' => $_POST['parent_tel'],
      'email' => $_POST['parent_email']
    ), false);

    if($edit_parent_result->response_status > 0) {
      System::notification('แก้ไขข้อมูลผู้ปกครองสำเร็จ', 'success');
      System::redirect();
    } else {
      System::notification('การแก้ไขผิดพลาด', 'error');
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
              <p class="text-blue bigger-130">ข้อมูลนักเรียน</p>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-4 col-xs-12">
                    <label for="" class="control-label">เลขที่</label>
                    <input type="text" name="number" id="number" class="form-control" required maxlength="2" pattern="[0-9]+" data-pattern-error="เลขที่ต้องเป็นตัวเลขเท่านั้น" value="<?php echo $user->group; ?>">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-4 col-xs-12">
                  <label for="" class="control-label">รหัสนักเรียน</label>
                  <p name="username" id="username" class="form-control-static"><?php echo $user->username; ?></p>
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="form-group col-sm-4 col-xs-12">
              <label for="" class="control-label">คำนำหน้า</label>
              <input type="text" id="prefix" name="prefix" class="form-control" list="data_title" required value="<?php echo $user->title; ?>">
              <datalist id="data_title">
                <option value="ด.ช."></option>
                <option value="ด.ญ."></option>
                <option value="นาย"></option>
                <option value="นางสาว"></option>
              </datalist>
              <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-sm-4 col-xs-12">
              <label for="" class="control-label">ชื่อ</label>
              <input type="text" id="name" name="name" class="form-control" required value="<?php echo $user->name; ?>">
              <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-sm-4 col-xs-12">
              <label for="" class="control-label">นามสกุล</label>
              <input type="text" id="surname" name="surname" class="form-control" required value="<?php echo $user->surname; ?>">
              <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-xs-12 text-right mt-3">
              <button name="edit_student" type="submit" class="btn btn-default-fill">บันทึกข้อมูล</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12">
        <div class="row">
          <form action="" method="POST" class="form-horizontal has-validator" role="form" data-toggle="validator">
            <div class="col-xs-12">
              <p class="text-blue bigger-130">ข้อมูลผู้ปกครอง</p>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">ชื่อ</label>
                  <input type="text" id="parent_name" name="parent_name" class="form-control" required value="<?php echo $parent->name; ?>">
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">นามสกุล</label>
                  <input type="text" id="parent_surname" name="parent_surname" class="form-control" required value="<?php echo $parent->surname; ?>">
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="" class="control-label">อีเมล</label>
                    <input type="email" name="parent_email" id="parent_email" class="form-control" required value="<?php echo $parent->email; ?>">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="" class="control-label">เบอร์โทรศัพท์</label>
                    <input type="text" name="parent_tel" id="parent_tel" class="form-control" required maxlength="10" pattern="[0-9]+" data-pattern-error="เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น" value="<?php echo $parent->tel; ?>">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-xs-12 text-right mt-3">
                  <button name="edit_parent" type="submit" class="btn btn-default-fill">บันทึกข้อมูล</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
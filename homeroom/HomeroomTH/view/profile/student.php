<?php
  $title = 'แก้ไขข้อมูล';

  $get_user_id = System::get_current_user()->user_id;
  $user = Homeroom::user_getbyid($get_user_id);
  $user_id = $user->user_id;

  if(isset($_POST['edit_student'])) {
    $edit_student_result = System::callAPIOrigin(System::API_CODE['USER'], 'edit', array(
      'user_id' => $user_id,
      'title' => $_POST['prefix'],
      'name' => $_POST['name'],
      'surname' => $_POST['surname'],
    ), 'false');

    if($edit_student_result->response_status > 0) {
      System::notification('แก้ไขข้อมูลสำเร็จ', 'success');
      System::redirect();
    } else {
      System::notification('การแก้ไขผิดพลาด', 'error');
    }
  }

  if(isset($_POST['submit_password'])){
    $password_result = System::callAPIOrigin(System::API_CODE['USER'], 'editpassword', array(
      'user_id' => $user_id,
      'oldpassword' => $_POST['oldpassword'],
      'newpassword' => $_POST['password']
    ), false);

    if($password_result->response_status) {
      System::notification('เปลี่ยนพาสเวิร์ดสำเร็จ', 'success');
      System::redirect();
    } else {
      System::notification($password_result->response_message, 'error');
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
              <div class="row">
                <div class="form-group col-sm-4 col-xs-12">
                    <label for="" class="control-label">เลขที่</label>
                    <p name="number" id="number" class="form-control-static"><?php echo $user->group; ?></p>
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
            <div class="form-group col-xs-12">
                <label for="" class="control-label">รหัสผ่านเดิม</label>
                <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="" maxlength="20" required>
                <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-xs-12">
                <label for="" class="control-label">รหัสผ่าน</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="" maxlength="20" required>
                <div class="mt-1 help-block with-errors invalid-feedback"></div>
            </div>
            <div class="form-group col-xs-12">
                <label for="" class="control-label">รหัสผ่านอีกครั้ง</label>
                <input type="password" class="form-control" name="repassword" id="" placeholder="" maxlength="20" required data-match="#password"
                  data-match-error="รหัสผ่านไม่ตรงกัน">
                <div class="mt-1 help-block with-errors invalid-feedback"></div>
              </div>
            <div class="form-group col-xs-12 text-right mt-3">
              <button name="submit_password" type="submit" class="btn btn-default-fill">เปลี่ยนรหัสผ่าน</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
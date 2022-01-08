<?php
  $title = 'แก้ไขข้อมูล';

  $get_user_id = System::get_current_user()->user_id;
  $user = Homeroom::user_getbyid($get_user_id);
  $user_id = $user->user_id;

  if(isset($_POST['edit_parent'])) {
    $edit_parent_result = System::callAPIOrigin(System::API_CODE['USER'], 'edit', array(
      'user_id' => $user_id,
      'name' => $_POST['parent_name'],
      'surname' => $_POST['parent_surname'],
      'tel' => $_POST['parent_tel'],
      'email' => $_POST['parent_email']
    ), false);

    if($edit_parent_result->response_status > 0) {
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
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">ชื่อ</label>
                  <input type="text" id="parent_name" name="parent_name" class="form-control" required value="<?php echo $user->name; ?>">
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                  <label for="" class="control-label">นามสกุล</label>
                  <input type="text" id="parent_surname" name="parent_surname" class="form-control" required value="<?php echo $user->surname; ?>">
                  <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="" class="control-label">อีเมล</label>
                    <input type="email" name="parent_email" id="parent_email" class="form-control" required value="<?php echo $user->email; ?>">
                    <div class="mt-1 help-block with-errors invalid-feedback"></div>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label for="" class="control-label">เบอร์โทรศัพท์</label>
                    <input type="text" name="parent_tel" id="parent_tel" class="form-control" required maxlength="10" pattern="[0-9]+" data-pattern-error="เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น" value="<?php echo $user->tel; ?>">
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
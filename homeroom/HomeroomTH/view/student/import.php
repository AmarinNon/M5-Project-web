<?php
$user = System::get_current_user();

if(isset($_POST['submit_import'])) {

  $csv_file = file_get_contents($_FILES['import_file']['tmp_name']);
  
  // fetch & validate data
  $START_ROW = 1; // skip row 1
  $N_COL = 9;

  $data = array();
  $tmp_data = explode("\n" , $csv_file);
  $row_add = 0;
  for($i = $START_ROW ; $i < count($tmp_data) ; $i++) {
    $cols = str_getcsv($tmp_data[$i], ",");
    if(count($cols) == $N_COL) {
      $cols = trim_arr($cols);
      $register_result = System::callAPIOrigin(System::API_CODE['USER'], 'register', array(
      'username' => $cols[1],
      'password' => $cols[1],
      'role' => 'Student'
      ), false);

      if($register_result->response_status) {
        $student_id = $register_result->response_data[0]->user_id;
        $user_data = System::callAPI(System::API_CODE['USER'], 'edit', array(
          'user_id' => $student_id,
          'group' => $cols[0],
          'name' => $cols[3],
          'surname' => $cols[4],
          'title' => $cols[2],
          'log_value1' => 'homeroom',
          'log_id1' => System::session('homeroom_id')
        ), false);

        $register_parent = System::callAPIOrigin(System::API_CODE['USER'], 'register', array(
        'username' => 'P'.$cols[1],
        'password' => $cols[8],
        'role' => 'Parent'
        ), false);

        if($register_parent->response_status) {
          $parent_id = $register_parent->response_data[0]->user_id;
          $parent_data = System::callAPI(System::API_CODE['USER'], 'edit', array(
            'user_id' => $parent_id,
            'name' => $cols[5],
            'surname' => $cols[6],
            'tel' => $cols[8],
            'email' => $cols[7]
          ), false);

          $insert_result = System::temtem(System::API_CODE['HOMEROOM'], 'student_parent', 'insert', array(
          'teacher_id' => $user->user_id,
          'student_id' => $student_id,
          'parent_id' => $parent_id
          ), false);

          if($insert_result) {
            $row_add++;
          }
        }
      }
    }
  }
  if($row_add > 0) {
    System::notification('นำเข้าข้อมูลสำเร็จ', 'success');
    System::redirect('student.php');
  }
}

function trim_arr($arr) {
  for($i = 0 ; $i < count($arr) ; $i++) {
    $arr[$i] = trim($arr[$i]);
  }
  return $arr;
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
          <span class="media-middle">Import</span>
        </h1>
      </div>
      <div class="col-sm-offset-2 col-sm-8 col-xs-offset-0 col-xs-12">
        <div class="row">
          <form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="col-xs-12">
              <p class="text-blue bigger-130">ข้อมูลนักเรียน</p>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                  <input type="file" name="import_file" accept=".csv" class="" required />
                  <div class="smaller-80">
                    * ไฟล์นามสกุล .csv ขนาดไม่เกิน 2MB
                  </div>
                </div>

                <div class="form-group col-xs-12">
                  <a href="example_import_student.php" class="btn-link">
                    <i class="fa fa-file-excel-o"></i> 
                    ตัวอย่างไฟล์
                  </a>
                </div>
              </div>
            </div>

            <div class="form-group col-xs-12 mt-3">
              <button name="submit_import" type="submit" class="btn btn-default-fill">เพิ่มข้อมูล</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
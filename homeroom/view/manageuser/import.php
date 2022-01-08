<?php
$user = System::get_current_user();

if(isset($_POST['submit_import'])) {

  $csv_file = file_get_contents($_FILES['import_file']['tmp_name']);
  
  // fetch & validate data
  $START_ROW = 1; // skip row 1
  $N_COL = 4;

  $data = array();
  $tmp_data = explode("\n" , $csv_file);
  $row_add = 0;
  for($i = $START_ROW ; $i < count($tmp_data) ; $i++) {
    $cols = str_getcsv($tmp_data[$i], ",");
    if(count($cols) == $N_COL) {
      $cols = trim_arr($cols);
      $register_result = System::callAPIOrigin(System::API_CODE['USER'], 'register', array(
      'username' => $cols[2],
      'password' => $cols[3],
      'role' => 'Teacher'
      ), false);

      if($register_result->response_status) {
        $user_data = System::callAPI(System::API_CODE['USER'], 'edit', array(
          'name' => $cols[0],
          'surname' => $cols[1],
          'user_id' => $register_result->response_data[0]->user_id
        ), false);
      }
      if($register_result) {
        $row_add++;
      }
    }
  }
  if($row_add > 0) {
    System::notification('Data import success', 'success');
    System::redirect('manageuser.php');
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
              <p class="text-blue bigger-130">Teacher information</p>
            </div>
            <div class="col-xs-12">
              <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                  <input type="file" name="import_file" accept=".csv" class="" required />
                  <div class="smaller-80">
                    * File extension .csv Size doesn't exceed 2MB
                  </div>
                </div>

                <div class="form-group col-xs-12">
                  <a href="example_import_teacher.php" class="btn-link">
                    <i class="fa fa-file-excel-o"></i> 
             File example
                  </a>
                </div>
              </div>
            </div>

            <div class="form-group col-xs-12 mt-3">
              <button name="submit_import" type="submit" class="btn btn-default-fill">Add Teacher</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
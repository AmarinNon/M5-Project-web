<?php
if(isset($_POST['submit_checkin']) && isset($_POST['student_id'])) {
  // check duplicate
  $result = Homeroom::checkin_getlist(array(
    'homeroom_id' => $_POST['homeroom_id'][0],
    'subject_id' => $_POST['subject_id'][0],
    'insertdatetime' => $_POST['checkin_date']
  ));
  if(count($result) > 0) {
    $checkin_id = $result[0]->id;
  } else {
    $insert_result = Homeroom::checkin_add(array(
      'homeroom_id' => $_POST['homeroom_id'][0],
      'subject_id' => $_POST['subject_id'][0],
      'insertdatetime' => $_POST['checkin_date']
    ));
    $checkin_id = $insert_result->response_data[0]->id;
  }
  if($checkin_id) {
    // get old data
    $checkin_detail = Homeroom::checkin_detail_teacher($_POST['homeroom_id'][0], $_POST['subject_id'][0]);

    $insert_data = array();
    $update_data = array();
    for($i = 0 ; $i < count($_POST['student_id']) ; $i++) {
      if(isset($_POST['checkin_status'][$i])) {
        $data = array(
          'checkin_id' => $checkin_id,
          'student_id' => $_POST['student_id'][$i],
          'homeroom_id' => $_POST['homeroom_id'][$i],
          'subject_id' => $_POST['subject_id'][$i],
          'checkin_status' => 'No',
          'insertdatetime' => $_POST['checkin_date']
        );

        // if match old data -> do nothing
        if(isset($checkin_detail[$_POST['checkin_date']][$_POST['student_id'][$i]])) {

        } else {
          array_push($insert_data, $data);
        }
      }
    }
    if(count($insert_data) > 0) {
      $insert_result = Homeroom::checkin_detail_add($insert_data);
    }
  }
  if(isset($insert_result) && $insert_result->response_status) {
    Homeroom::save_success();
  } else {
    Homeroom::save_error();
  }
  System::redirect();
}
?>
<form action="" method="post" class="form-inline">
  <div class="form-group">
    <label class="text-blue mt-1 mr-2 control-label">Daily</label>
    <input type="date" name="checkin_date" class="form-control" value="<?php echo date('Y-m-d');?>" required>
  </div>
  <div class="pmd-card mt-2">
    <?php
    $subject_id = 0;
    $homeroom_id = System::session('homeroom_id');
    $student = Homeroom::student_getbyhomeroomid($homeroom_id);
    ?>
    <table class="table pmd-table table-striped table-bordered pmd-data-table" data-paging="false" data-searching="false" data-info="false">
      <thead>
        <tr>
          <th>Number</th>
          <th>Student ID</th>
          <th>Name - Surname</th>
          <th class="no-sort">Absent</th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0 ; $i < count($student) ; $i++) { ?>
          <tr>
            <td><?php echo $student[$i]->group;?></td>
            <td><?php echo $student[$i]->username;?></td>
            <td class="text-left text-nowarp">
              <?php
          echo $student[$i]->title.' ';
          echo $student[$i]->name.' ';
          echo $student[$i]->surname;
          ?>
          </td>
          <td>
            <?php
            echo '<input type="hidden" name="homeroom_id['.$i.']" value="'.$homeroom_id.'">';
            echo '<input type="hidden" name="subject_id['.$i.']" value="'.$subject_id.'">';
            echo '<input type="hidden" name="student_id['.$i.']" value="'.$student[$i]->user_id.'">';
            echo '<label class="checkbox-inline pmd-checkbox pmd-checkbox-ripple-effect">';
            echo '<input type="checkbox" name="checkin_status['.$i.']" value="No">';
            echo '</label>';
            ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="form-group pull-right">
    <input type="hidden" name="submit_checkin" value="1">
    <button type="submit" class="btn pmd-ripple-effect btn-default-fill">Save data</button>
  </div>
</form>
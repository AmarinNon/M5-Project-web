<?php
$subject_id = System::session('subject_id');
$subject = Homeroom::subject_getbyid($subject_id);

if($subject) {
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-sm-12">
      <?php
      
      $teacher = Homeroom::user_getbyid($subject->teacher_id);
      $homework = Homeroom::homework_getlist(array(
        'subject_id' => $subject_id
      ));
      $student_score = Homeroom::score_getlistwithstudent($subject_id);
      // transform student_score
      $tmp_student_score = array();
      for($i = 0 ; $i < count($student_score) ; $i++) {
        $tmp_student_score[$student_score[$i]->user_id] = $student_score[$i];
      }

      if(isset($_POST['submit_score'])) {
        $insert_data = array();
        $update_data = array();
        for($i = 0 ; $i < count($_POST['homework_id']) ; $i++) {
          $student_id = $_POST['student_id'][$i];
          $homework_id = $_POST['homework_id'][$i];
          $homeroom_id = $_POST['homeroom_id'][$i];
          $score = $_POST['score'][$i];
          $late_send = isset($_POST['late_send'][$i]) ? 1 : 0;
          $score_id = $_POST['score_id'][$i];
          $data = array(
            'student_id' => $student_id,
            'homework_id' => $homework_id,
            'homeroom_id' => $homeroom_id,
            'score' => $score,
            'late_send' => $late_send
          );
          // check if score change
          $condition_1 = $tmp_student_score[$student_id]->score[$homework_id]['score'] != $score;
          $condition_2 = $tmp_student_score[$student_id]->score[$homework_id]['late_send'] != $late_send;
          if($condition_1 || $condition_2) {
            if($score_id == -1) {
              array_push($insert_data, $data);
            } else {
              $data['id'] = $score_id;
              array_push($update_data, $data);
            }
          }
        }
        if(count($insert_data) > 0) {
          $insert_result = Homeroom::score_add($insert_data);
          if($insert_result->response_status) {
            Homeroom::save_success();
          } else {
            Homeroom::save_error();
          }
        }
        if(count($update_data) > 0) {
          $update_result = Homeroom::score_update($update_data);
          if($update_result->response_status) {
            Homeroom::save_success();
          } else {
            Homeroom::save_error();
          }
        }
        System::redirect();
      }
      ?>
        <h1 class="section-title">
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-03-blue.svg" alt="" class="img-responsive">
          </div>
          <span>
            <?php
            echo $current_subject->name;
            echo ' ชั้น ';
            echo Homeroom::homeroom_getbyid($current_subject->homeroom_id)->name;
          ?>
          </span>
        </h1>

        <div class="pmd-card">
          <form action="" method="post" id="score_form">
            <table class="table pmd-table table-striped table-bordered pmd-data-table" data-paging="false" data-searching="false" data-info="false">
              <thead>
                <tr>
                  <th>เลขที่</th>
                  <th>รหัส</th>
                  <th>ชื่อ - สกุล</th>
                  <?php
                  for($hidx = 0 ; $hidx < count($homework) ; $hidx++) {
                    echo '<th class="no-sort" data-toggle="tooltip" data-placement="auto" title="'.$homework[$hidx]->name.'">';
                    echo $homework[$hidx]->shortname;
                    echo ' ('.number_format($homework[$hidx]->score).')';
                    '</th>';
                  }
                  ?>
                </tr>
              </thead>
                <tbody>
                  <?php
                  $arr_idx = 0;
                  for($sidx = 0 ; $sidx < count($student_score) ; $sidx++) { 
                  ?>
                  <tr>
                    <td><?php echo $student_score[$sidx]->group;?></td>
                    <td><?php echo $student_score[$sidx]->username;?></td>
                    <td class="text-left text-nowrap">
                    <?php 
                    echo $student_score[$sidx]->title.' ';
                    echo $student_score[$sidx]->name.' ';
                    echo $student_score[$sidx]->surname;
                    ?>
                    </td>
                    <?php
                    $score = $student_score[$sidx]->score;
                    for($hidx = 0 ; $hidx < count($homework) ; $hidx++) {
                      $late_check = ($score[$homework[$hidx]->id]['late_send'] == 1) ? 'checked' : '';
                      echo '<td>';
                      echo '<input type="hidden" name="student_id[]" value="'.$student_score[$sidx]->user_id.'">';
                      echo '<input type="hidden" name="homeroom_id[]" value="'.$subject->homeroom_id.'">';
                      echo '<input type="hidden" name="homework_id[]" value="'.$homework[$hidx]->id.'">';
                      echo '<input type="hidden" name="score_id[]" value="'.$score[$homework[$hidx]->id]['id'].'">';
                      echo '<input class="score-input select-focus text-right" type="number" name="score[]" value="'.$score[$homework[$hidx]->id]['score'].'" min="0" max="'.$homework[$hidx]->score.'" step="0.01" required>';
                      echo '<label class="checkbox-inline pmd-checkbox pmd-checkbox-ripple-effect">';
                      echo '<input type="checkbox" name="late_send['.$arr_idx.']" value="1" '.$late_check.'>';
                      echo 'ส่งงานช้า</label>';
                      echo '</td>';
                      $arr_idx++;
                    }
                    ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>

              <div class="form-group text-center pt-3">
                <input type="hidden" name="submit_score" value="1">
                <?php if(count($homework) > 0) { ?>
                <button class="btn pmd-ripple-effect btn-default-fill" type="submit">บันทึกคะแนน</button>
                <?php } ?>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
<?php
} else {
  include 'view/nodata/subject.php';
}
?>
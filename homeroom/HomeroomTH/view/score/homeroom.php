<?php
$homeroom_id = System::session('homeroom_id');
$homeroom = Homeroom::homeroom_getbyid($homeroom_id);

if($homeroom) {
  $where = array('homeroom_id' => $homeroom_id); 
  $subject_list = Homeroom::subject_getlist($where);
  $subject_list_id = array();
  for($i = 0; $i < count($subject_list) ; $i++){
    $subject_list_id[$i] = $subject_list[$i]->id;
  } 

  if(isset($_GET['id']) && $_GET['id'] != '' && in_array($_GET['id'], $subject_list_id)) {
    $filter = $_GET['id'];
  } else {
    if(count($subject_list_id) > 0) {
      $filter = $subject_list_id[0];
    }
  }
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-03-blue.svg" alt="" class="img-responsive">
          </div>
          <span class="media-middle">Homeroom ชั้น <?php echo $homeroom->name;?></span>
        </h1>
      </div>
      
      <div class="col-xs-12">
        <div class="row">
          <div class="col-sm-4">
            <select id="filter_subject" class="form-control" onchange="location = this.value;">
              <option value="" selected disabled>เลือกวิชา</option>
              <?php for($i = 0; $i < count($subject_list); $i++) { ?>
                <option value="score.php?id=<?php echo $subject_list[$i]->id; ?>" <?php echo ($filter == $subject_list[$i]->id)? 'selected':'' ;?>>
                  <?php echo $subject_list[$i]->subject_code.' : '.$subject_list[$i]->name; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        <?php 
          if(isset($filter)) {
          $subject_id = $filter;
          $subject = Homeroom::subject_getbyid($subject_id);
          $teacher = Homeroom::user_getbyid($subject->teacher_id);
          $homework = Homeroom::homework_getlist(array(
            'subject_id' => $subject_id
          ));
          $student_score = Homeroom::score_getlistwithstudent($subject_id);
           ?>
          <div class="pmd-card mt-3">
            <div class="mb-3">ครูประจำวิชา : <?php echo $teacher->name.' '.$teacher->surname;?></div>
            <hr>
            <div class="table-responsive">
              <table class="table pmd-table pmd-data-table table-striped table-bordered">
              <thead>
                <tr>
                  <th>เลขที่</th>
                  <th>รหัส</th>
                  <th>ชื่อ - สกุล</th>
                  <?php
                  for($hidx = 0 ; $hidx < count($homework) ; $hidx++) {
                    echo '<th data-toggle="tooltip" data-placement="auto" title="'.$homework[$hidx]->name.'">';
                    echo $homework[$hidx]->shortname;
                    echo ' ('.number_format($homework[$hidx]->score).')';
                    echo '</th>';
                  }
                  ?>
                </tr>
              </thead>
                <tbody>
                  <?php for($sidx = 0 ; $sidx < count($student_score) ; $sidx++) { ?>
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
                      echo '<td>'.$score[$homework[$hidx]->id]['score'].'</td>';
                    }
                    ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php } else { ?>
          <div class="pmd-card mt-3">
            <div class="alert alert-danger">
              <i class="fa fa-warning text-danger mr-1" aria-hidden="true"></i>
              ชั้นเรียนนี้ยังไม่มีรายวิชา
            </div>
          </div>
        <?php } ?>
    </div>
  </div>
</div>
</div>
<?php
} else {
  include 'view/nodata/homeroom.php';
}
?>
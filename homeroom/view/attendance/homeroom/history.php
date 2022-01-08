<?php
  $subject_id = 0;
  $homeroom_id = System::session('homeroom_id');
  $student = Homeroom::student_getbyhomeroomid($homeroom_id);
  
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
      // $filter = $subject_list_id[0];
      $filter = 0;
    }
  }
  ?>
  <div class="row">
    <div class="col-sm-4">
      <select id="filter_subject" class="form-control" onchange="location = this.value;">
        <option value="" selected disabled>Choose subjects</option>
        <option value="attendance.php?action=history&id=0" <?php echo ($filter == 0)? 'selected':'' ;?>>Homeroom Class <?php echo $homeroom->name;?></option>
        <?php for($i = 1; $i <= count($subject_list); $i++) { ?>
          <option value="attendance.php?action=history&id=<?php echo $subject_list[$i-1]->id; ?>" <?php echo ($filter == $subject_list[$i-1]->id)? 'selected':'' ;?>>
          <?php echo $subject_list[$i-1]->subject_code.' : '.$subject_list[$i-1]->name; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    
    <?php 
if(isset($filter)) {
  $subject_id = $filter;
  $subject = Homeroom::subject_getbyid($subject_id);
  
  if($filter > 0) {
    $teacher = Homeroom::user_getbyid($subject->teacher_id);
  }
  
  $checkin_detail = Homeroom::checkin_detail_teacher($homeroom_id, $subject_id);
  $checkin = Homeroom::checkin_getlist(array(
    'homeroom_id' => $homeroom_id,
    'subject_id' => $subject_id
  ));
  ?>
<div class="pmd-card mt-3">
  <?php if($filter > 0) { ?>
  <div class="mb-3">Subjects Teacher : <?php echo $teacher->name.' '.$teacher->surname;?></div>
  <?php } ?>
  <hr>
  <table class="table pmd-table table-striped table-bordered pmd-data-table" data-paging="false" data-searching="false" data-info="false">
    <thead>
      <tr>
        <th>Number</th>
        <th>Password</th>
        <th>Name - Surname</th>
        <?php
        for($i = 0 ; $i < count($checkin) ; $i++) {
          echo '<th class="no-sort" data-toggle="tooltip" data-placemet="auto" title="'.System::convertDateTHShort($checkin[$i]->insertdatetime).'">';
          echo 'No. '.($i + 1);
          echo '</th>';
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
      for($i = 0 ; $i < count($student) ; $i++) {
        $student_id = $student[$i]->user_id;
      ?>
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
        <?php
        for($j = 0 ; $j < count($checkin) ; $j++) {
          $date = date('Y-m-d', strtotime($checkin[$j]->insertdatetime));
          $checked = true;
          if(isset($checkin_detail[$date][$student_id])) {
            $checked = false;
          }
          echo '<td>';
          if($checked) {
            echo '<span class="text-success">Attend class</span>';
          } else {
            echo '<span class="text-danger">Absent</span>';
          }
          echo '</td>';
        }
        ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php } else { ?>
<!-- <div class="pmd-card mt-3">
  <div class="alert alert-danger">
    <i class="fa fa-warning text-danger mr-1" aria-hidden="true"></i>
    วิชานี้ยังไม่มีประวัติการขาดเรียน
  </div>
</div> -->
<?php } ?>
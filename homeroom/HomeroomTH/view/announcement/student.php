<?php
$user = System::get_current_user();
if($user->role == 'Student') {
  $where = array(
    'homeroom_id' => $user->log_id1
  );
} else {
  $student = Homeroom::parent_student($user->user_id);
  $where = array(
    'homeroom_id' => $student->log_id1,
    'subject_id' => 0
  );
}
$prakard = Homeroom::prakard_getlist($where);
$prakard_count = count($prakard);
$limit_set = true;
if(!isset($prakard_limit)) {
  $limit_set = false;
  $prakard_limit = $prakard_count;
}

if(! $limit_set) {
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-07-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">ประกาศ</span>
        </h1>
      </div>
<?php } ?>    
      <div id="student-announcement" class="mt-3">
        <?php
        for($i = 0 ; $i < $prakard_limit && $i < $prakard_count  ; $i++) {
          $homeroom = Homeroom::homeroom_getbyid($prakard[$i]->homeroom_id);
          if($prakard[$i]->subject_id == 0) {
            $subject_name = 'Homeroom ชั้น '.$homeroom->name;
          } else {
            $subject = Homeroom::subject_getbyid($prakard[$i]->subject_id);
            $subject_name = $subject->name.' ชั้น '.$homeroom->name;
          }
          $teacher = Homeroom::user_getbyid($prakard[$i]->teacher_id);
        ?>
        <div class="col-xs-12">
          <div class="pmd-z-depth alert alert-info">
            <div class="mb-1 bigger-130 bold">
              <div class="media-top icon-title mr-2">
                <img src="images/svg/icon-07-blue.svg" alt="" class="img-responsive">
              </div>
              <span class="media-middle text-blue"><?php echo $subject_name;?></span>
            </div>
            <span class="mr-3">วันที่ <?php echo System::convertDateTH($prakard[$i]->updatedatetime, true); ?></span>
            <span>จาก <?php echo $teacher->name.' '.$teacher->surname; ?></span>
            <hr class="mt-2">
            <div class="pmd-card-body mb-0">
              <?php echo nl2br($prakard[$i]->message); ?>
            </div>
          </div>
        </div>
        <?php
        }
        if($limit_set && $prakard_limit > 0 && ($prakard_count > $prakard_limit)) {
          echo '<div class="col-xs-12 text-right">';
          echo '<a class="btn-link" href="announcement.php">ดูประกาศทั้งหมด ('.$prakard_count.')</a>';
          echo '</div>';
        }
        ?>
      </div>
<?php if(! $limit_set) { ?>
    </div>
  </div>
</div>
<?php } ?>
<?php
require_once '../import/defImport.php';

$start_date = $_POST['start'];
$end_date = $_POST['end'];

$user = System::get_current_user();
if($user->role === "Teacher") {
  if(System::session('mode') == 'Homeroom') {
    $homeroom_id = System::session('homeroom_id');
    $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
    $where = array(
      'homeroom_id' => System::session('homeroom_id'),
      'deadline_date{{<>}}' => array($start_date, $end_date)
    );
  } else {
    $subject_id = System::session('subject_id');
    $current_subject = Homeroom::subject_getbyid($subject_id);
    $homeroom_id = $current_subject->homeroom_id;
    $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
    $where = array(
      'homeroom_id' => $homeroom_id,
      'deadline_date{{<>}}' => array($start_date, $end_date)
    );
  }
} else if ($user->role === 'Student') {
  $homeroom_id = $user->log_id1;
  $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
  $where = array(
    'homeroom_id' => $user->log_id1,
    'deadline_date{{<>}}' => array($start_date, $end_date)
  );
} else if ($user->role === 'Parent') {
  $parent_id = $user->user_id;
  $student = Homeroom::parent_student($parent_id);
  $homeroom_id = $student->log_id1;

  $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
  $where = array(
    'homeroom_id' => $homeroom_id,
    'deadline_date{{<>}}' => array($start_date, $end_date)
  );
} else {

}

$homeworks = Homeroom::homework_groupbydate($where, 'deadline_date');
foreach($homeworks as $date => $homework) {
?>
  <div class="pmd-card pmd-z-depth fill-gray">
    <div class="pmd-card-title">
      <div class="media-body media-middle">
        <p class="pmd-card-title-text bigger-130 bold"><?php echo System::convertDateTH($date); ?></p>
      </div>
    </div>
    <div class="pmd-card-body">
      <hr>
      <?php for($i = 0; $i < count($homework); $i++) { 
      $subject = System::temtem(System::API_CODE['HOMEROOM'], 'subject', 'getbyid', array('id' => $homework[$i]->subject_id), false);
      $subject_bg_color = $subject[0]->color;
      $color_code = Homeroom::color_index($subject_bg_color);
      $subject_color = Homeroom::FONT_COLORS[$color_code];
      ?>
        <a href="homework.php?action=view&id=<?php echo $homework[$i]->id; ?>" data-toggle="tooltip"
        title="<?php echo $subject[0]->name?> : Work No. <?php echo $homework[$i]->shortname; ?>">
          <div class="tag-pills" style="background-color: <?php echo $subject_bg_color; ?>; color: <?php echo $subject_color; ?>">
          <?php echo $subject[0]->subject_code.' : '.$homework[$i]->name; ?>
          </div>
        </a>
      <?php } ?>
    </div>
  </div>
<?php
}
?>
<?php
$user = System::get_current_user();
$subject_list = Homeroom::subject_getlist(array(
  'teacher_id' => $user->user_id
));

$homework_list = Homeroom::homework_getlist(array(
  'subject_id' => System::session('subject_id')
));
$homework_id = array();
for($i = 0; $i < count($homework_list); $i++) {
  $homework_id[$i] = $homework_list[$i]->id;
}
  
if(isset($_GET['id']) && in_array($_GET['id'], $homework_id)){
  $homework_result = Homeroom::homework_getbyid($_GET['id']);
  $homework = $homework_result[0];
  $deadline_date = System::dayofweek_thai($homework->deadline_date).' ';
  $deadline_date .= date('d/m/', strtotime($homework->deadline_date));
  $deadline_date .= date('Y', strtotime($homework->deadline_date));
} else {
  System::redirect('homework.php');
}
?>
<div class="pmd-card pmd-z-depth fill-gray">
  <div class="pmd-card-title clearfix">
    <div class="media-left pull-left">
      <h2 class="pmd-card-title-text"><?php echo $homework->name; ?></h2>
      <p class="pmd-card-title-text d-none visible-sm visible-xs bold">Submit: Date <?php echo $deadline_date;?></p>
      <p class="pmd-card-title-text bold">Score : <?php echo number_format($homework->score, 2); ?></p>
    </div>
    <div class="media-right pull-right">
      <h2 class="pmd-card-title-text d-none visible-md visible-lg">Submit: Date <?php echo $deadline_date;?></h2>
    </div>
  </div>
  <div class="pmd-card-body">
    <?php echo $homework->description; ?>
    <div class="clearfix">
      <div class="pull-left mt-4">
        <a href="homework.php?action=edit&id=<?php echo $homework->id; ?>" class="btn btn-default"><span class="smaller-80 fa fa-pencil mr-2"></span>Edit work</a>
        <?php
        $file = Homeroom::homework_get_file('homework_'.$homework->id);
        if(count($file) > 0) {
          echo '<a href="'.$file[0]->url.'" class="btn btn-default" download><span class="smaller-80 fa fa-file mr-2"></span>Download document</a>';
        }
        ?>
      </div>
      <div class="pull-right mt-4">
        <form action="" method="POST">
          <input type="hidden" value="<?php echo $homework->id; ?>" name="homework_id">
          <input type="hidden" value="delete" name="action">
          <a href="#" class="btn btn-default-fill bg-red toggle-confirm" data-toggle="tooltip" title="Delete" data-message="Delete confirm"><span class="smaller-80 fa fa-trash-o mr-2"></span>Delete work</a>
        </form>
      </div>
    </div>
  </div>
</div>

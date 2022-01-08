<?php 
$user = System::get_current_user();
$homeroom = Homeroom::homeroom_getbyid(System::session('homeroom_id'));

if($homeroom || $user->role == 'Student' || $user->role == 'Parent') {
  if(isset($_GET['id'])){
    $homework_result = Homeroom::homework_getbyid($_GET['id']);
    $homework = $homework_result[0];
    $deadline_date = System::dayofweek_thai($homework->deadline_date).' ';
    $deadline_date .= date('d/m/', strtotime($homework->deadline_date));
    $deadline_date .= date('Y', strtotime($homework->deadline_date));

    $subject = System::temtem(System::API_CODE['HOMEROOM'], 'subject', 'getbyid', array('id' => $homework->subject_id), false);
  } else {
    System::redirect('homework.php');
  }
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
        <?php if($homeroom) { ?>
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-02-blue.svg" alt="" class="img-responsive">
          </div>
          <span class="media-middle">Homeroom Class <?php echo $homeroom->name;?></span>
        <?php } else { ?>
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-09-blue.svg" alt="" class="img-responsive">
          </div>
          <span class="media-middle">Assignment</span>
        <?php } ?>
        </h1>
      </div>

      <div class="col-xs-12">
        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title clearfix">
            <div class="media-left pull-left">
              <h2 class="pmd-card-title-text"><?php echo 'Subjects '.$subject[0]->name.' No. '.$homework->shortname.' : '.$homework->name; ?></h2>
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
                <?php
                $file = Homeroom::homework_get_file('homework_'.$homework->id);
                if(count($file) > 0) {
                  echo '<a href="'.$file[0]->url.'" class="btn btn-default" download><span class="smaller-80 fa fa-file mr-2"></span>Download document</a>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
} else {
  include 'view/nodata/homeroom.php';
}
?>
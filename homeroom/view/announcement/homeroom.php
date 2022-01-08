<?php
$user = System::get_current_user();
$teacher_id = $user->user_id;
$homeroom_id = System::session('homeroom_id');
$subject_id = 0;

$homeroom = Homeroom::homeroom_getbyid($homeroom_id);

if(isset($_POST['submit_prakard'])) {
  $query_result = Homeroom::prakard_add($teacher_id, $subject_id, $homeroom_id, $_POST['message']);
  if($query_result->response_status) {
    Homeroom::save_success();
  } else {
    Homeroom::save_error();
  }
  System::redirect();
}

$where = array(
  'teacher_id' => $teacher_id,
  'subject_id' => $subject_id,
  'homeroom_id' => $homeroom_id
);
$prakard = Homeroom::prakard_getlist($where);
if(count($prakard) > 0) {
  $message = $prakard[0]->message;
  $date_updated = 'Edit Recent announcement : '.System::convertDateTH($prakard[0]->updatedatetime, true);
} else {
  $message = '';
  $date_updated = '';
}
if($homeroom) {
?>
  <div id="content" class="pmd-content inner-page">
    <div class="container-fluid full-width-container">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-07-blue.svg" alt="" class="img-responsive">
            </div>
            <span class="media-middle">Homeroom Class
              <?php echo $homeroom->name;?>
            </span>
          </h1>
        </div>
        <div class="col-xs-12">
          <div class="pmd-card pmd-z-depth fill-gray">
            <div class="pmd-card-title">
              <div class="media-body media-middle">
                <h2 class="pmd-card-title-text">Announcement</h2>
              </div>
            </div>
            <div class="pmd-card-body">
              <form action="" method="post">
                <div class="form-group">
                  <textarea name="message" id="" class="form-control" rows="4"><?php echo $message;?></textarea>
                </div>
                <div class="form-group">
                  <span><?php echo $date_updated; ?></span>
                </div>
                <div class="form-group">
                  <input type="hidden" name="submit_prakard" value="1">
                  <button type="submit" class="btn btn-default-fill">Submit</button>
                </div>
              </form>
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
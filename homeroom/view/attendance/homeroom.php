<?php
$homeroom_id = System::session('homeroom_id');
$homeroom = Homeroom::homeroom_getbyid($homeroom_id);
if($homeroom) {
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
      <?php
      $action = 'checkin';
      $view = 'view/attendance/homeroom/checkin.php';
      if(isset($_GET['action']) && $_GET['action'] == 'history') {
        $action = 'history';
        $view = 'view/attendance/homeroom/history.php';
      }
      ?>
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-04-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homeroom Class <?php echo $homeroom->name;?></span>
        </h1>
      </div>
      <div class="col-sm-3">
          <div class="tab-subject">
            <ul class="nav nav-pills nav-stacked nav-outline">
              <li role="presentation" class="<?php echo ($action == 'checkin')? 'active':'';?> ">
                  <a href="attendance.php?action=checkin" class="pmd-ripple-effect">Check Students</a>
              </li>
              <li role="presentation" class="<?php echo ($action == 'history')? 'active':'';?> ">
                  <a href="attendance.php?action=history"  class="pmd-ripple-effect">Absent History</a>
              </li>
            </ul>
          </div>
      </div>

      <div class="col-sm-9">
        <?php
        include_once $view;
        ?>
      </div>
    </div>
  </div>
</div>
<?php
} else {
  include 'view/nodata/homeroom.php';
}
?>
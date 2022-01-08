<?php
  $subject_id = System::session('subject_id');
  $subject = Homeroom::subject_getbyid($subject_id);

  if($subject) {
?>

<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <h1 class="section-title">
        <div class="media-top icon-title mr-2">
          <img src="images/svg/icon-01-blue.svg" alt="" class="img-responsive">
        </div>
      <span class="media-middle"><?php echo $subject->name;?> ชั้น <?php echo Homeroom::homeroom_getbyid($subject->homeroom_id)->name; ?></span>
    </h1>

    <div class="section-content">
      <div class="row">
        <div class="col-xs-12">
          <div class="pmd-card">
            <div class="table-responsive">
              <table class="table pmd-table pmd-data-table table-striped table-bordered">
              <thead>
                <tr>
                  <th>เลขที่</th>
                  <th>รหัสนักเรียน</th>
                  <th>ชื่อ - สกุล</th>
                </tr>
              </thead>
                
              <tbody>
              <?php
                $student = Homeroom::student_getbyhomeroomid($subject->homeroom_id);
                for($i = 0; $i < count($student) ; $i++){
              ?>
                  <tr class="fadeIn animated">
                    <td><?php echo $student[$i]->group; ?></td>
                    <td><?php echo $student[$i]->username; ?></td>
                    <td class="text-left"><?php echo $student[$i]->title.' '.$student[$i]->name.' '.$student[$i]->surname; ?></td>
                  </tr>
                <?php
                }
              ?>
              </tbody>
              </table>
            </div>
          </div>
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
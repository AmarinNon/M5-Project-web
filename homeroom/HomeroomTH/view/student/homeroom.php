<?php
  if(isset($_POST['action'])){
    if($_POST['action'] == 'delete') {
      $delete_result = Homeroom::delete_student($_POST['student_id'], $_POST['parent_id']);
      System::notification('การลบสำเร็จ', 'success');
      System::redirect();
    }
  }
  $user = Homeroom::student_getbyhomeroomid(System::session('homeroom_id'));
  $homeroom = Homeroom::homeroom_getbyid(System::session('homeroom_id'));

  if($homeroom) {
?>

<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <h1 class="section-title">
        <div class="media-top icon-title mr-2">
          <img src="images/svg/icon-01-blue.svg" alt="" class="img-responsive">
        </div>
      <span class="media-middle">Homeroom ชั้น <?php echo $homeroom->name;?></span>
    </h1>

    <div class="section-content">
      <div class="row">
        <div class="col-xs-12">
          <div>
            <span class="btn-with-icon">
              <a href="student.php?action=add" class="btn btn-default">
            <span class="fa fa-plus btn-icon img-circle"></span>เพิ่มข้อมูล</a>
            </span>
            <span class="btn-with-icon">
              <a href="student.php?action=import" class="btn btn-default">
            <span class="fa fa-download btn-icon img-circle"></span>Import</a>
            </span>
          </div>
          
          <div class="mt-3 pmd-card">
            <div class="table-responsive">
              <table class="table pmd-table pmd-data-table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>เลขที่</th>
                    <th>รหัสนักเรียน</th>
                    <th>ชื่อ - สกุล</th>
                    <th>ชื่อผู้ปกครอง</th>
                    <th>อีเมล</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th class="no-sort thin-cell"></th>
                  </tr>
                </thead>
									
                <tbody>
                <?php
                  for($i = 0; $i < count($user) ; $i++){
                    $parent = Homeroom::student_parent($user[$i]->user_id);
                ?>
                    <tr class="fadeIn animated">
                      <td><?php echo $user[$i]->group; ?></td>
                      <td><?php echo $user[$i]->username; ?></td>
                      <td class="text-left"><?php echo $user[$i]->title.' '.$user[$i]->name.' '.$user[$i]->surname; ?></td>
                      <td class="text-left">คุณ <?php echo $parent->name.' '.$parent->surname; ?></td>
                      <td><?php echo $parent->email; ?></td>
                      <td><?php echo preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3",$parent->tel); ?></td>
                      <td class="thin-cell">
                        <a href="student.php?action=edit&id=<?php echo $user[$i]->user_id; ?>" class="smaller-80 mr-2" data-toggle="tooltip" title="แก้ไข"><span class="fa fa-pencil"></span></a>
                        <form action="" method="POST" class="inline">
                          <input type="hidden" value="<?php echo $user[$i]->user_id; ?>" name="student_id">
                          <input type="hidden" value="<?php echo $parent->user_id; ?>" name="parent_id">
                          <input type="hidden" value="delete" name="action">
                          <a href="#" class="smaller-80 btn-link toggle-confirm" data-toggle="tooltip" title="ลบ" data-message="ยืนยันการลบข้อมูล"><span class="fa fa-trash-o"></span></a>
                        </form>
                      </td>
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
    include 'view/nodata/homeroom.php';
  }
?>
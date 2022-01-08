<?php
  $user = System::get_current_user();

  if(isset($_POST['edit_homeroom'])) {
    $edit_result = Homeroom::homeroom_edit($_POST['id'], $_POST['name']);
    if($edit_result) {
      Homeroom::save_success();
    } else {
      Homeroom::save_error();
    }
    System::redirect();
  }

  if(isset($_POST['delete_homeroom'])) {
    $delete_result = Homeroom::homeroom_delete($_POST['id']);
    if($delete_result) {
      Homeroom::save_success();
      if($_POST['id'] == System::session('homeroom_id')) {
        System::remove_session('homeroom_id');
      }
    } else {
      Homeroom::save_error();
    }
    System::redirect();
  }

  $homeroom_list = Homeroom::homeroom_getlist(array(
    'teacher_id' => $user->user_id
  ));
?>

<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <h1 class="section-title">
        <div class="media-top icon-title mr-2">
          <img src="images/svg/HoT-01-blue.svg" alt="" class="img-responsive">
        </div>
      <span class="media-middle">จัดการ Homeroom</span>
    </h1>

    <div class="section-content">
      <div class="row">
        <div class="col-md-6">
          <div class="btn-with-icon">
            <a href="#" class="btn btn-default toggle-modal" data-target="#add-homeroom-modal">
            <span class="fa fa-plus btn-icon img-circle"></span>เพิ่ม Homeroom</a>
          </div>
          
          <div class="mt-3 pmd-card">
            <div class="table-responsive">
              <table class="table pmd-table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>ชื่อ Homeroom</th>
                    <th class="thin-cell"></th>
                  </tr>
                </thead>
									
                <tbody>
                <?php
                  for($i = 0; $i < count($homeroom_list) ; $i++){
                ?>
                  <tr class="fadeIn animated">
                    <td><?php echo $i + 1; ?></td>
                    <td class="text-left">
                      Homeroom ชั้น <?php echo $homeroom_list[$i]->name; ?>
                    </td>
                    <td class="thin-cell">
                      <a href="teacher_manage.php?action=edit&id=<?php echo $homeroom_list[$i]->id;?>" class="smaller-80 mr-2" data-toggle="tooltip" title="แก้ไข"><span class="fa fa-pencil"></span></a>
                      <?php if(Homeroom::homeroom_removable($homeroom_list[$i]->id)) { ?>
                      <form action="" method="POST" class="inline">
                        <input type="hidden" value="<?php echo $homeroom_list[$i]->id;?>" name="id">
                        <input type="hidden" name="delete_homeroom" value="1">
                        <a href="#" class="smaller-80 btn-link toggle-confirm" data-toggle="tooltip" title="ลบ" data-message="ยืนยันการลบข้อมูล"><i class="fa fa-trash-o text-danger"></i></a>
                      </form>
                      <?php } else { ?>
                        <i class="fa fa-trash-o smaller-80" data-toggle="tooltip" title="ไม่สามารถลบ Homeroom ได้"></i>
                      <?php } ?>
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


        <?php
        if(isset($_GET['action']) && $_GET['action'] === 'edit') {
          $homeroom = Homeroom::homeroom_getbyid($_GET['id']);
          if($homeroom) {
        ?>
        <div class="col-md-6">
          <h1 class="text-blue bigger-130 text-center">แก้ไข Homeroom</h1>
          <div class="mt-3 pmd-card">
            <form action="" method="POST">
              <div class="form-group">
                <label for="" class="control-label text-info bigger-110">ชื่อ Homeroom</label>
                <input name="name" type="text" id="" class="form-control" placeholder="ex. ม.6/1" required value="<?php echo $homeroom->name; ?>" autofocus>
              </div>
              <div class="form-group text-right">
                <input type="hidden" name="id" value="<?php echo $homeroom->id; ?>">
                <input type="hidden" name="edit_homeroom" value="1">
                <button type="submit" class="btn pmd-ripple-effect btn-default-fill">บันทึก</button>
              </div>
            </form>
          </div>
        </div>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>
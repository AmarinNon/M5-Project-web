<?php
  $user = System::get_current_user();

  if(isset($_POST['edit_subject'])) {
    $edit_result = Homeroom::subject_edit(array(
      'id' => $_POST['id'],
      'name' => $_POST['name'],
      'subject_code' => $_POST['subject_code'],
      'color' => $_POST['color']
    ));
    if($edit_result->response_message == 'success') {
      Homeroom::save_success();
    } else {
      Homeroom::save_error();
    }
    System::redirect();
  }

  if(isset($_POST['delete_subject'])) {
    $delete_result = Homeroom::subject_delete($_POST['id']);
    System::display($delete_result);
    if($delete_result->response_message == 'success') {
      Homeroom::save_success();
      if($_POST['id'] == System::session('subject_id')) {
        System::remove_session('subject_id');
      }
    } else {
      Homeroom::save_error();
    }
    System::redirect();
  }

  $subject_list = Homeroom::subject_getlist(array(
    'teacher_id' => $user->user_id
  ));
?>

<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <h1 class="section-title">
        <div class="media-top icon-title mr-2">
          <img src="images/svg/HoT-02-blue.svg" alt="" class="img-responsive">
        </div>
      <span class="media-middle">จัดการรายวิชา</span>
    </h1>

    <div class="section-content">
      <div class="row">
        <div class="col-md-6">
          <div class="btn-with-icon">
            <a href="#" class="btn btn-default toggle-modal" data-target="#add-subject-modal">
            <span class="fa fa-plus btn-icon img-circle"></span>เพิ่มวิชาที่สอน</a>
          </div>
          
          <div class="mt-3 pmd-card">
            <div class="table-responsive">
              <table class="table pmd-table table-striped table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th>วิชา</th>
                    <th class="thin-cell"></th>
                  </tr>
                </thead>
									
                <tbody>
                <?php
                  for($i = 0; $i < count($subject_list) ; $i++) {
                ?>
                  <tr class="fadeIn animated">
                    <td><?php echo $i + 1; ?></td>
                    <td class="text-left">
                      <?php
                        echo '<i class="fa fa-square" style="color:'.$subject_list[$i]->color.';"></i> ';
                        echo $subject_list[$i]->subject_code.': ';
                        echo $subject_list[$i]->name;
                        echo ' ชั้น ';
                        echo Homeroom::homeroom_getbyid($subject_list[$i]->homeroom_id)->name;
                      ?>
                    </td>
                    <td class="thin-cell">
                      <a href="teacher_manage.php?action=edit&id=<?php echo $subject_list[$i]->id;?>" class="smaller-80 mr-2" data-toggle="tooltip" title="แก้ไข"><span class="fa fa-pencil"></span></a>
                    <?php if(Homeroom::subject_removable($subject_list[$i]->id)) { ?>
                      <form action="" method="POST" class="inline">
                        <input type="hidden" value="<?php echo $subject_list[$i]->id;?>" name="id">
                        <input type="hidden" name="delete_subject" value="1">
                        <a href="#" class="smaller-80 btn-link toggle-confirm" data-toggle="tooltip" title="ลบ" data-message="ยืนยันการลบข้อมูล"><span class="fa fa-trash-o text-danger"></span></a>
                      </form>
                    <?php } else { ?>
                      <span class="fa fa-trash-o smaller-80" data-toggle="tooltip" title="ไม่สามารถลบวิชาได้ : ต้องลบงานที่สั่งก่อน"></span></a>
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
          $subject = Homeroom::subject_getbyid($_GET['id']);
          if($subject) {
        ?>
        <div class="col-md-6">
          <h1 class="text-blue bigger-130 text-center">แก้ไขรายวิชา</h1>
          <div class="mt-3 pmd-card">
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="" class="control-label text-info bigger-110">รหัสวิชา</label>
                    <input name="subject_code" type="text" id="" class="form-control" placeholder="" required value="<?php echo $subject->subject_code;?>">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="" class="control-label text-info bigger-110">ชื่อวิชา</label>
                <input name="name" type="text" id="" class="form-control" placeholder="" required value="<?php echo $subject->name;?>">
              </div>
              
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="" class="control-label text-info bigger-110">ชั้น</label>
                    <select name="homeroom_id" class="form-control" disabled>
                      <?php
                      $homeroom_list = Homeroom::homeroom_getlist();
                      for($i = 0 ; $i < count($homeroom_list) ; $i++) {
                        if($homeroom_list[$i]->id == $subject->homeroom_id) {
                          echo '<option value="'.$homeroom_list[$i]->id.'" selected>'.$homeroom_list[$i]->name.'</option>';
                        } else {
                          echo '<option value="'.$homeroom_list[$i]->id.'">'.$homeroom_list[$i]->name.'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="" class="control-label text-info bigger-110">สี</label>
                    <span class="dropdown pmd-dropdown clearfix color-picker">
                      <input type="hidden" class="color-input" name="color" value="<?php echo $subject->color;?>" required>
                      <button class="btn btn-block btn-default dropdown-toggle color-select" type="button" data-toggle="dropdown" aria-expanded="true" style="">&nbsp;</button>
                      <ul role="menu" class="dropdown-menu scrollable-menu">
                        <?php
                        for($i = 0 ; $i < count(Homeroom::COLORS) ; $i++) {
                          echo '<li role="presentation">
                            <a href="#" class="color-item text-center" tabindex="-1" role="menuitem" data-color="'.Homeroom::COLORS[$i].'" style="background-color: '.Homeroom::COLORS[$i].'; color: '.Homeroom::FONT_COLORS[$i].';">'.Homeroom::COLORS[$i].'</a>
                          </li>';
                        }
                        ?>
                      </ul>
                    </span>
                  </div>
                </div>
              </div>

              <div class="form-group text-right">
                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                <input type="hidden" name="edit_subject" value="1">
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
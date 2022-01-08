<?php
if($user->role == 'Teacher') {
  if(isset($_POST['add_subject'])) {
    $insert_result = Homeroom::subject_add(array(
      'teacher_id' => $user->user_id,
      'homeroom_id' => $_POST['homeroom_id'],
      'subject_code' => $_POST['subject_code'],
      'name' => $_POST['name'],
      'color' => $_POST['color']
    ));
    if(count($insert_result) > 0) {
      System::notification('บันทึกข้อมูลสำเร็จ', 'success');
    }
    System::redirect();
  }
?>

<div class="modal fade" id="add-subject-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
          </div>
        </div>

        <form class="form-horizontal" action="" method="post">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <label for="" class="control-label text-info bigger-110">รหัสวิชา</label>
                <input name="subject_code" type="text" id="" class="form-control" placeholder="" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label text-info bigger-110">ชื่อวิชา</label>
            <input name="name" type="text" id="" class="form-control" placeholder="" required>
          </div>
          
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <label for="" class="control-label text-info bigger-110">ชั้น</label>
                <select name="homeroom_id" class="form-control" required>
                  <?php
                  $homeroom_list = Homeroom::homeroom_getlist();
                  for($i = 0 ; $i < count($homeroom_list) ; $i++) {
                    echo '<option value="'.$homeroom_list[$i]->id.'">'.$homeroom_list[$i]->name.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
              <?php $ridx = mt_rand(0, count(Homeroom::COLORS) - 1); ?>
                <label for="" class="control-label text-info bigger-110">สี</label>
                <span class="dropdown pmd-dropdown clearfix color-picker">
                  <input type="hidden" class="color-input" name="color" value="<?php echo Homeroom::COLORS[$ridx];?>" required>
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
            <input type="hidden" name="add_subject" value="1">
            <button type="submit" class="btn pmd-ripple-effect btn-default-fill">เพิ่มวิชา</button>
            <button type="button" class="btn pmd-ripple-effect btn-link" data-dismiss="modal">ยกเลิก</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  $(document).on('click', '.color-picker .color-item', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $picker = $this.parents('.color-picker').find('.color-select');
    $picker.css('background-color', $this.data('color'));

    var $input = $this.parents('.dropdown').find('input.color-input');
    $input.val($this.data('color'));
  });

  $('.color-picker').each(function(idx, el) {
    var $el = $(el);
    var color = $el.find('input.color-input').val();
    $el.find('.color-select').css('background-color', color);
  });
});
</script>
<?php } ?>
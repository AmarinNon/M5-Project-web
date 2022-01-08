<?php
$user = System::get_current_user();
$subject_id = System::session('subject_id');
if($current_subject) {
  $homeroom_id = Homeroom::homeroom_getbyid($current_subject->homeroom_id)->id;
}
$homework = Homeroom::homework_getlist(array('subject_id' => $subject_id));

$homework_list_id = array();
for($i = 0; $i < count($homework) ; $i++){
  $homework_list_id[$i] = $homework[$i]->id;
} 

if(isset($_GET['id']) && $_GET['id'] != '' && in_array($_GET['id'], $homework_list_id)) {
  $filter = $_GET['id'];
} else {
  if(count($homework_list_id) > 0) {
    $filter = $homework_list_id[0];
    System::redirect('homework.php?action=view&id='.$filter);
  }
}

if(isset($_POST['submit_homework'])){
  $homework_result = Homeroom::homework_add(array(
    'subject_id' => $subject_id,
    'teacher_id' => $user->user_id,
    'homeroom_id' => $homeroom_id,
    'shortname' => $_POST['shortname'],
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'homework_type' => $_POST['homework_type'],
    'assign_date' => $_POST['assign_date'],
    'deadline_date' => $_POST['deadline_date'],
    'score' => $_POST['score']
  ));
  if(count($homework_result) > 0) {
    // add file
    if(isset($_FILES['file'])) {
      Homeroom::homework_add_file('homework_'.$homework_result->response_data[0]->id, $_FILES['file']);
    }
    System::notification('เพิ่มการบ้านสำเร็จ' ,'success');
    System::redirect();
  } else {
    System::notification('เพิ่มการบ้านไม่สำเร็จ' ,'danger');
    System::redirect();
  }
}

if(isset($_POST['action'])){
  if($_POST['action'] == 'delete') {
    $delete_result = Homeroom::homework_delete($_POST['homework_id']);
    System::notification('ลบการบ้านสำเร็จ', 'success');
    System::redirect('homework.php?action=view');
  }
}
if($current_subject) {
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-02-blue.svg" alt="" class="img-responsive">
          </div>
          <span class="media-middle">
            <?php
            echo $current_subject->name;
            echo ' ชั้น ';
            echo Homeroom::homeroom_getbyid($current_subject->homeroom_id)->name;
            ?>
          </span>
        </h1>
      </div>
      
      <div class="col-sm-3">
        <div class="btn-with-icon">
          <a class="btn btn-default" data-toggle="modal" href='#add-homework'>
          <span class="fa fa-plus btn-icon img-circle"></span>เพิ่มงาน</a>
        </div>
        <div class="mt-3">
          <ul class="nav nav-pills nav-stacked nav-outline">
            <?php for($i = 0; $i < count($homework) ; $i++) { ?>
            <li class="<?php echo ($filter == $homework[$i]->id)? 'active':'' ;?>">
                <a href="homework.php?action=view&id=<?php echo $homework[$i]->id; ?>" class="pmd-ripple-effect">งานครั้งที่ <?php echo $homework[$i]->shortname; ?></a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="col-sm-9">
        <?php if(count($homework) != 0) {
        if(isset($_GET['action']) && $_GET['action'] == 'view') {
          include_once 'view/homework/view_detail_teacher.php';
        }
        ?>
        <?php } else {
          include 'view/nodata/homework.php';
        } ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add-homework">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <form action="" method="POST" id="homework_form" enctype="multipart/form-data">
            <div class="form-group col-sm-2">
              <label for="" class="control-label text-info bigger-110">งานครั้งที่</label>
              <input type="text" name="shortname" id="shortname" class="form-control" required>
            </div>
            <div class="form-group col-sm-5">
              <label for="" class="control-label text-info bigger-110">ชื่องาน</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group col-sm-5">
              <label for="" class="control-label text-info bigger-110">งานที่เคยสั่ง</label>
              <?php
              $homework_list = Homeroom::homework_getlist(
                array(
                'teacher_id' => $user->user_id
                ),
                array(
                  'subject_id' => 'ASC',
                  'shortname' => 'ASC'
                )
              );
              
              ?>
              <select name="" class="form-control" id="previous_homework">
                <option value="" selected>ไม่เลือก</option>
                <?php
                for($i = 0 ; $i < count($homework_list) ; $i++) {
                  $subject = Homeroom::subject_getbyid($homework_list[$i]->subject_id);
                  $homeroom = Homeroom::homeroom_getbyid($homework_list[$i]->homeroom_id);
                  echo '<option value="'.$homework_list[$i]->id.'">';
                  echo '[งานครั้งที่ '.$homework_list[$i]->shortname.'] - ';
                  echo $subject->name;
                  echo ' '.$homeroom->name;
                  echo '</option>';
                }
                ?>
              </select>
              <p class="help-block mt-1 no-margin-bottom">*หากต้องการสั่งงานเหมือนที่ผ่านมา</p>
            </div>
            <div class="form-group col-xs-12">
              <label for="" class="control-label">รายละเอียด</label>
              <textarea name="description" id="description" class="form-control" rows="10" required></textarea>
            </div>
            <div class="form-group col-sm-2">
              <label for="" class="control-label">ประเภทงาน</label>
              <select name="homework_type" id="homework_type" class="form-control">
                <option value="1">งานเดี่ยว</option>
                <option value="2">งานกลุ่ม</option>
              </select>
            </div>
            <div class="form-group col-sm-4">
              <label for="" class="control-label">วันสั่งงาน</label>
              <input type="date" name="assign_date" id="assign_date" class="form-control">
            </div>
            <div class="form-group col-sm-4">
              <label for="" class="control-label">กำหนดส่ง</label>
              <input type="date" name="deadline_date" id="deadline_date" class="form-control">
            </div>
            <div class="form-group col-sm-2">
              <label for="" class="control-label">คะแนนเต็ม</label>
              <input type="text" name="score" id="score" class="form-control" required>
            </div>
            <div class="form-group col-sm-6 col-xs-12">
              <input type="file" name="file" class="smaller-80" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" />
              <div class="smaller-80">* แนบไฟล์ (*.pdf , *.doc, *.docx)</div>
            </div>
            <div class="form-group col-sm-6 col-xs-12">
              <div class="mt-2 text-right">
                <input type="hidden" name="submit_homework">
                <button type="submit" class="btn btn-default-fill">บันทึก</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  <?php
  // transform array
  $tmp_arr = array();
  for($i = 0 ; $i < count($homework_list) ; $i++) {
    $homework_list[$i]->assign_date = date('Y-m-d', strtotime($homework_list[$i]->assign_date));
    $homework_list[$i]->deadline_date = date('Y-m-d', strtotime($homework_list[$i]->deadline_date));

    $tmp_arr[$homework_list[$i]->id] = $homework_list[$i];
  }
  $homework_list = $tmp_arr;
  ?>
  var previous_homework = <?php echo json_encode($homework_list);?>;
  
  $(document).on('change', '#previous_homework', function(e) {
    var $this = $(this);
    var homework_id = $this.val();
    var homework = previous_homework[homework_id];
    for(key in homework) {
      if($('#' + key)) {
        var $obj = $('#' + key);
        $obj.val(homework[key]);
      }
    }
  });
</script>
<?php
} else {
  include 'view/nodata/subject.php';
}
?>
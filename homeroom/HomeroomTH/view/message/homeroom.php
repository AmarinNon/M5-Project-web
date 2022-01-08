<?php
$homeroom_id = System::session('homeroom_id');
$homeroom = Homeroom::homeroom_getbyid($homeroom_id);

if($homeroom) {
$where = array('homeroom_id' => $homeroom_id); 
$subject_list = Homeroom::subject_getlist($where);

if(isset($_GET['view']) && $_GET['view'] != '') {
  $filter = $_GET['view'];
} else {
  $filter = 'inbox';
}

$where = array(
  'receive_user_id' => $user->user_id,
  'message_type' => array('1','3','5'),
  'homeroom_id' => $homeroom_id
);
$message = Homeroom::message_getlist($where);

if(isset($_POST['submit_message_student_parent'])){
  $receiver_id = $_POST['reciever_number'];
  $parent = Homeroom::student_parent($receiver_id);
  
  if($_POST['reciever_type'] == 'Student'){
    $message_type = '4';
    // to student
    $result = Homeroom::message_add($user->user_id, $receiver_id, $_POST['message'], $message_type, '', $homeroom_id);
    
    if($result->response_data) {
      // also to parent
      $message_type = '2';
      $receiver_id = $parent->user_id;
      $result = Homeroom::message_add($user->user_id, $receiver_id, $_POST['message'], $message_type, '', $homeroom_id);
      
      if($result->response_data) {
        System::notification('ส่งข้อความสำเร็จ','success');
      } else {
      }
    } else {
      System::notification('ส่งข้อความล้มเหลว','danger');
    }
    System::redirect();
  }
  else if($_POST['reciever_type'] == 'Parent'){
    $message_type = '2';
    $receiver_id = $parent->user_id;
    
    $result = Homeroom::message_add($user->user_id, $receiver_id, $_POST['message'], $message_type, '', $homeroom_id);
    
    if($result->response_data) {
      System::notification('ส่งข้อความสำเร็จ','success');
    } else {
      System::notification('ส่งข้อความล้มเหลว','danger');
    }
    System::redirect();
  }
}

if(isset($_POST['submit_message_subject'])){
  $to_subject = Homeroom::subject_getbyid($_POST['receiver_subject']);
  $receiver_id = $to_subject->teacher_id;
  
  $result = Homeroom::message_add($user->user_id, $receiver_id, $_POST['message'], '0', $_POST['receiver_subject'], $homeroom_id);
  
  if($result->response_data) {
    System::notification('ส่งข้อความสำเร็จ','success');
  } else {
    System::notification('ส่งข้อความล้มเหลว','danger');
  }
  System::redirect();
}

if(isset($_POST['action'])){
  if($_POST['action'] == 'delete') {
    $delete_result = Homeroom::message_delete(array('id' => $_POST['message_id']));
    System::notification('การลบสำเร็จ', 'success');
    System::redirect();
  }
}
  
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-06-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homeroom ชั้น <?php echo $homeroom->name;?></span>
        </h1>
      </div>
      <div class="col-sm-3">
        <ul class="nav nav-pills nav-stacked nav-outline">
          <li class="<?php echo ($filter == 'inbox')? 'active':'' ;?>">
            <a href="message.php?view=inbox" aria-controls="home" class="pmd-ripple-effect">กล่องข้อความ</a>
          </li>
          <li class="<?php echo ($filter == 'send' || $filter == 'reply')? 'active':'' ;?>">
            <a href="message.php?view=send" aria-controls="tab"  class="pmd-ripple-effect">ส่งข้อความ</a>
          </li>
        </ul>
      </div>
      <div class="col-sm-9">
      <?php if($filter == 'inbox') {
      if(count($message)) {
        for($i = 0; $i < count($message); $i++){
          $sent_user = Homeroom::user_getbyid($message[$i]->send_user_id);
          $sent_role = '';
          $sent_form = '';
          if($sent_user->role == 'Teacher'){ 
            $sent_role = 'ครูประจำวิชา';
            $sent_subject = Homeroom::subject_getbyid($message[$i]->ref_id);
            $subject_homeroom = Homeroom::homeroom_getbyid($sent_subject->homeroom_id);
            $sent_form = 'จาก '.$sent_role.' / วิชา '.$sent_subject->name.' ชั้น '.$subject_homeroom->name;
          }
          else if($sent_user->role == 'Student'){ 
            $sent_role = 'นักเรียน';
            $sent_form = 'จาก '.$sent_role.' / เลขที่ '.$sent_user->group.' '.$sent_user->title.' '.$sent_user->name.' '.$sent_user->surname;
          }
          else if($sent_user->role == 'Parent'){ 
            $sent_role = 'ผู้ปกครอง';
            $student = Homeroom::parent_student($sent_user->user_id);
            $sent_form = 'จาก '.$sent_role.' / เลขที่ '.$student->group.' คุณ '.$sent_user->name.' '.$sent_user->surname;
          }
        ?>
        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title">
            <div class="media-body media-middle">
              <h2 class="pmd-card-title-text"><?php echo $sent_form; ?></h2>
              <span class="text-gray"><?php echo System::convertDateTH($message[$i]->insertdatetime, true); ?></span>
            </div>
            <div class="media-right">
              <a href="message.php?view=reply&id=<?php echo $message[$i]->id; ?>" class="pt-2 smaller-80 btn btn-sm btn-info" data-toggle="tooltip" title="ตอบกลับ"><span class="fa fa-reply"></span></a>
            </div>
            <div class="media-right">
              <form action="" method="POST" class="inline">
                <input type="hidden" value="<?php echo $message[$i]->id; ?>" name="message_id">
                <input type="hidden" value="delete" name="action">
                <a href="#" class="pt-2 smaller-80 btn btn-sm btn-danger toggle-confirm" data-toggle="tooltip" title="ลบ" data-message="ยืนยันการลบข้อมูล"><span class="fa fa-trash-o"></span></a>
              </form>
            </div>
          </div>
          <div class="pmd-card-body">
            <hr>  
            <p class="ml-4"><?php echo $message[$i]->message; ?></p>
          </div>
        </div>
      <?php }
      } else { ?>
        <div class="alert alert-info">คุณยังไม่มีข้อความ</div>
      <?php }
      } else if ($filter == 'send') { ?>
        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title">
            <div class="media-body media-middle">
              <h2 class="pmd-card-title-text">ถึง ผู้ปกครอง / นักเรียน</h2>
            </div>
          </div>
          <div class="pmd-card-body">
            <form id="message_student_parent_form" action="" method="POST">
              <div class="form-group">
                <span class="text-blue">ส่งข้อความถึง</span>
                <select id="reciever_type" name="reciever_type" class="form-control select-custom ml-2 " required="required">
                  <option disabled selected>เลือกผู้รับ</option>
                  <option value="Student">นักเรียน</option>
                  <option value="Parent">ผู้ปกครอง</option>
                </select>
                <select id="reciever_number" name="reciever_number" class="form-control select-custom ml-2 mr-3" required="required">
                  <option value="" disabled selected>เลขที่</option>
                  <?php
                  $student_list = Homeroom::student_getbyhomeroomid($homeroom_id);
                  $student_number = array();
                  for($i = 0 ; $i < count($student_list) ; $i++) {
                    $student_number[$student_list[$i]->group] = $student_list[$i];
                  }
                  ksort($student_number);
                  foreach ($student_number as $group => $student) {
                    echo '<option value="'.$student->user_id.'">'.$group.' : '.$student->name.' '.$student->surname.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <textarea name="message" class="form-control" rows="4" required="required"></textarea>
              </div>
              <div class="form-group">
                <button name="submit_message_student_parent" class="btn btn-default-fill">ส่งข้อความ</button>
              </div>
            </form>
          </div>
        </div>

        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title">
            <div class="media-body media-middle">
              <h2 class="pmd-card-title-text">ถึง ครูผู้สอน</h2>
            </div>
          </div>
          <div class="pmd-card-body">
            <form id="message_subject_form" action="" method="POST">
              <div class="form-group">
                <span class="text-blue">ส่งข้อความถึง</span>
                <select id="receiver_subject" name="receiver_subject" class="form-control select-custom ml-2 mr-3" required="required">
                  <option value="" disabled selected>เลือกรายวิชา</option>
                  <?php for($i = 0; $i < count($subject_list); $i++) { ?>
                  <option value="<?php echo $subject_list[$i]->id; ?>">
                  <?php echo $subject_list[$i]->subject_code.' : '.$subject_list[$i]->name; ?></option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <textarea name="message" class="form-control" rows="4" required="required"></textarea>
              </div>
              <div class="form-group">
                <button name="submit_message_subject" class="btn btn-default-fill">ส่งข้อความ</button>
              </div>
            </form>
          </div>
        </div>
        <?php } else if ($filter == 'reply') {
          include_once 'view/message/homeroom_reply.php';
        } else {
          System::redirect('message.php');
        } ?>
      </div>
    </div>
  </div>
</div>
<?php
  } else {
    include 'view/nodata/homeroom.php';
  }
?>
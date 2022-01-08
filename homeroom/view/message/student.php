<?php
$homeroom_id = $user->log_id1;
$homeroom = Homeroom::homeroom_getbyid($homeroom_id);
$homeroom_teacher = Homeroom::user_getbyid($homeroom->teacher_id);

$where = array('homeroom_id' => $homeroom_id); 
$subject_list = Homeroom::subject_getlist($where);

if(isset($_GET['view']) && $_GET['view'] != '') {
  $filter = $_GET['view'];
} else {
  $filter = 'inbox';
}

$where = array(
  'receive_user_id' => $user->user_id,
  'message_type' => array('4','6')
);
$message = Homeroom::message_getlist($where);

if(isset($_POST['submit_message_homeroom'])){
  $result = Homeroom::message_add($user->user_id, $_POST['homeroom_teacher_id'], $_POST['message'], '5', '', $homeroom_id);
  
  if($result->response_data) {
    System::notification('Send message success','success');
  } else {
    System::notification('Send message unsuccess','danger');
  }
  System::redirect();
}

if(isset($_POST['submit_message_subject'])){
  $to_subject = Homeroom::subject_getbyid($_POST['receiver_subject']);
  $receiver_id = $to_subject->teacher_id;
  
  $result = Homeroom::message_add($user->user_id, $receiver_id, $_POST['message'], '7', $_POST['receiver_subject'], $homeroom_id);

  if($result->response_data) {
    System::notification('Send message success','success');
  } else {
    System::notification('Send message unsuccess','danger');
  }
  System::redirect();
}

if(isset($_POST['action'])){
  if($_POST['action'] == 'delete') {
    $delete_result = Homeroom::message_delete(array('id' => $_POST['message_id']));
    System::notification('Delete success', 'success');
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
          <span class="media-middle">Message</span>
        </h1>
      </div>
      <div class="col-sm-3">
        <ul class="nav nav-pills nav-stacked nav-outline">
          <li class="<?php echo ($filter == 'inbox')? 'active':'' ;?>">
            <a href="message.php?view=inbox" aria-controls="home" class="pmd-ripple-effect">Inbox</a>
          </li>
          <li class="<?php echo ($filter == 'send' || $filter == 'reply')? 'active':'' ;?>">
            <a href="message.php?view=send" aria-controls="tab"  class="pmd-ripple-effect">Send message</a>
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
          if($message[$i]->message_type == '4'){ 
            $sent_role = 'Homeroom Teacher';
            $sent_form = 'From '.$sent_role.' '.$sent_user->name.' '.$sent_user->surname;
          }
          else if($message[$i]->message_type == '6'){ 
            $sent_role = 'Subjects Teacher';
            $sent_subject = Homeroom::subject_getbyid($message[$i]->ref_id);
            $subject_homeroom = Homeroom::homeroom_getbyid($sent_subject->homeroom_id);
            $sent_form = 'From subjects '.$sent_subject->name.' Class '.$subject_homeroom->name.' / '.$sent_user->name.' '.$sent_user->surname;
          }
        ?>
        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title">
            <div class="media-body media-middle">
              <h2 class="pmd-card-title-text"><?php echo $sent_form; ?></h2>
              <span class="text-gray"><?php echo System::convertDateTH($message[$i]->insertdatetime, true); ?></span>
            </div>
            <div class="media-right">
              <a href="message.php?view=reply&id=<?php echo $message[$i]->id; ?>" class="pt-2 smaller-80 btn btn-sm btn-info" data-toggle="tooltip" title="Feedback"><span class="fa fa-reply"></span></a>
            </div>
            <div class="media-right">
              <form action="" method="POST" class="inline">
                <input type="hidden" value="<?php echo $message[$i]->id; ?>" name="message_id">
                <input type="hidden" value="delete" name="action">
                <a href="#" class="pt-2 smaller-80 btn btn-sm btn-danger toggle-confirm" data-toggle="tooltip" title="Delete" data-message="Delete confirm"><span class="fa fa-trash-o"></span></a>
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
          <div class="alert alert-info">You don't have any message</div>
      <?php }
      } else if ($filter == 'send') { ?>
        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title">
            <div class="media-body media-middle">
              <h2 class="pmd-card-title-text">To Homeroom Teacher</h2>
            </div>
          </div>
          <div class="pmd-card-body">
            <form id="message_homeroom_form" action="" method="POST">
              <div class="form-group">
                <span class="text-blue">Send message to</span>
                <span>: <?php echo $homeroom_teacher->name.' '.$homeroom_teacher->surname; ?></span>
              </div>
              <div class="form-group">
                <textarea name="message" class="form-control" rows="4" required="required"></textarea>
              </div>
              <div class="form-group">
                <input type="hidden" name="homeroom_teacher_id" value="<?php echo $homeroom_teacher->user_id; ?>">
                <button name="submit_message_homeroom" class="btn btn-default-fill">Send message</button>
              </div>
            </form>
          </div>
        </div>

        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title">
            <div class="media-body media-middle">
              <h2 class="pmd-card-title-text">To Subjects Teacher</h2>
            </div>
          </div>
          <div class="pmd-card-body">
            <form id="message_subject_form" action="" method="POST">
              <div class="form-group">
                <span class="text-blue">Send message to</span>
                <select id="receiver_subject" name="receiver_subject" class="form-control select-custom ml-2 mr-3" required="required">
                  <option value="" disabled selected>Select subjects</option>
                  <?php for($i = 0; $i < count($subject_list); $i++) { ?>
                  <option value="<?php echo $subject_list[$i]->id; ?>">
                  <?php echo $subject_list[$i]->subject_code.' : '.$subject_list[$i]->name; ?></option>
                <?php } ?>
                </select>
                <span id="teacher_name" style="display: none;"></span>
              </div>
              <div class="form-group">
                <textarea name="message" class="form-control" rows="4" required="required"></textarea>
              </div>
              <div class="form-group">
                <button name="submit_message_subject" class="btn btn-default-fill">Send message</button>
              </div>
            </form>
          </div>
        </div>
        <?php } else if ($filter == 'reply') {
          include_once 'view/message/student_reply.php';
        } else {
          System::redirect('message.php');
        } ?>
      </div>
    </div>
  </div>
</div>
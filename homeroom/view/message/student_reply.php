<?php
// check message id
$where = array(
  'receive_user_id' => $user->user_id,
  'message_type' => array('4','6')
);
$message = Homeroom::message_getlist($where);

$message_list_id = array();
  for($i = 0; $i < count($message) ; $i++){
    $message_list_id[$i] = $message[$i]->id;
} 

if(isset($_GET['view']) && $_GET['view'] != '' && isset($_GET['id']) && in_array($_GET['id'], $message_list_id)) {
  $filter = $_GET['view'];
  $message_id = $_GET['id'];
} else {
  System::redirect('message.php');
}

$message = Homeroom::message_getbyid($message_id);
$message = $message[0];
$reply_user = Homeroom::user_getbyid($message->send_user_id);
?>

<?php if($message->message_type == '6') {
  // teacher -> student
  $sent_subject = Homeroom::subject_getbyid($message->ref_id);
  $subject_homeroom = Homeroom::homeroom_getbyid($sent_subject->homeroom_id);
  ?>
  <div class="pmd-card pmd-z-depth fill-gray">
    <div class="pmd-card-title">
      <div class="media-body media-middle">
        <h2 class="pmd-card-title-text text-blue">
        <?php
        echo '<span class="smaller-70 fa fa-reply mr-2"></span>';
        echo 'Feedback to Homeroom Teacher ';
        echo $sent_subject->name;
        echo ' Class ';
        echo $subject_homeroom->name;
        echo ' / ';
        echo $reply_user->name.' '.$reply_user->surname;
        ?>
        </h2>
      </div>
    </div>
    <div class="pmd-card-body">
      <div class="pmd-card pmd-z-depth">
        <div class="pmd-card-title">
          <div class="media-body media-middle">
            <span class="text-gray"><?php echo System::convertDateTH($message->insertdatetime, true); ?></span>
          </div>
        </div>
        <div class="pmd-card-body">
          <hr>  
          <p class="ml-4"><?php echo $message->message; ?></p>
        </div>
      </div>

      <form id="message_subject_form" action="" method="POST">
        <div class="form-group">
          <textarea name="message" class="form-control" rows="4" required="required"></textarea>
        </div>
        <div class="form-group">
          <input type="hidden" name="receiver_subject" value="<?php echo $message->ref_id; ?>">
          <button name="submit_message_subject" class="btn btn-default-fill">Send message</button>
        </div>
      </form>
    </div>
  </div>
  <?php } else if ($message->message_type == '4') {
    // homeroom -> student
  ?>
  <div class="pmd-card pmd-z-depth fill-gray">
    <div class="pmd-card-title">
      <div class="media-body media-middle">
        <h2 class="pmd-card-title-text text-blue">
        <?php
        echo '<span class="smaller-70 fa fa-reply mr-2"></span>';
        echo 'Feedback to Homeroom Teacher : ';
        echo $reply_user->name.' '.$reply_user->surname;
        ?>
        </h2>
      </div>
    </div>
    <div class="pmd-card-body">
      <div class="pmd-card pmd-z-depth">
        <div class="pmd-card-title">
          <div class="media-body media-middle">
            <span class="text-gray"><?php echo System::convertDateTH($message->insertdatetime, true); ?></span>
          </div>
        </div>
        <div class="pmd-card-body">
          <hr>  
          <p class="ml-4"><?php echo $message->message; ?></p>
        </div>
      </div>
      
      <form id="message_homeroom_form" action="" method="POST">
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
  <?php } else {

  } ?>
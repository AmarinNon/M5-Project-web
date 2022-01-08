<?php
$get_user_id = System::get_current_user()->user_id;
$user = Homeroom::user_getbyid($get_user_id);
$user_id = $user->user_id;
?>
<!-- Header Starts -->
<!--Start Nav bar -->
<nav class="navbar navbar-inverse navbar-fixed-top pmd-navbar">

  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a href="javascript:void(0);" class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect pull-left margin-r8 pmd-sidebar-toggle">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </a>
    </div>

    <?php if($user->role == 'Teacher' && System::session('mode') == 'Homeroom') { ?>
    <ul class="nav navbar-nav top-nav has-separator copy-to-side hidden-xs">
      <?php
        $homeroom_list = Homeroom::homeroom_getlist(array(
          'teacher_id' => $user->user_id
        ));

        $homeroom_list_html = '';
        $current_homeroom = '';
        for($i = 0 ; $i < count($homeroom_list) ; $i++) {
          if($i == 0) {
            $current_homeroom = $homeroom_list[$i]->name;
            if(System::session('homeroom_id') === null) {
              System::session('homeroom_id', $homeroom_list[$i]->id);
            }
          }
          if($homeroom_list[$i]->id == System::session('homeroom_id')) {
            $current_homeroom = $homeroom_list[$i]->name;
          }
          $homeroom_list_html .= '
          <li role="presentation">
            <a href="swap_module.php?homeroom_id='.$homeroom_list[$i]->id.'&url='.urlencode(CURRENT_URL).'" tabindex="-1" role="menuitem">Homeroom ชั้น '.$homeroom_list[$i]->name.'</a>
          </li>
          ';
        }
        if(count($homeroom_list) > 0) {
      ?>
      <li class="dropdown pmd-dropdown active">
        <a href="#" class="pmd-ripple-effect dropdown-toggle" data-sidebar="true" data-toggle="dropdown">
          Homeroom ชั้น 
          <?php echo $current_homeroom; ?>
          <span class="caret"></span>
        </a>
        <ul role="menu" class="dropdown-menu dropdown-menu-right">
          <?php echo $homeroom_list_html; ?>
        </ul>
      </li>
      <?php } ?>

      <li class="">
        <a href="#" class="toggle-modal" data-target="#add-homeroom-modal" data-toggle="tooltip" data-placement="auto" title="เพิ่ม Homeroom">
          <img src="images/svg/plus-13.svg" class="">
          <span class="visible-xs-inline-block ml-3">เพิ่ม Homeroom</span>
        </a>
      </li>
      
    </ul>
    <?php } else if($user->role == 'Teacher') { ?>
    <ul class="nav navbar-nav top-nav has-separator copy-to-side hidden-xs">
      <?php
        $subject_list = Homeroom::subject_getlist(array(
          'teacher_id' => $user->user_id
        ));

        $subject_list_html = '';
        $current_subject = null;
        for($i = 0 ; $i < count($subject_list) ; $i++) {
          if($i == 0) {
            $current_subject = $subject_list[$i];
            if(System::session('subject_id') === null) {
              System::session('subject_id', $subject_list[$i]->id);
            }
          }
          if($subject_list[$i]->id == System::session('subject_id')) {
            $current_subject = $subject_list[$i];
          }
          $subject_list_html .= '
          <li role="presentation">
            <a href="swap_module.php?subject_id='.$subject_list[$i]->id.'&url='.urlencode(CURRENT_URL).'" tabindex="-1" role="menuitem">'.$subject_list[$i]->name.' ชั้น '.Homeroom::homeroom_getbyid($subject_list[$i]->homeroom_id)->name.'</a>
          </li>
          ';
        }
        if(count($subject_list) > 0) {
      ?>
      <li class="dropdown pmd-dropdown active">
        <a href="#" class="pmd-ripple-effect dropdown-toggle" data-sidebar="true" data-toggle="dropdown">
          <?php
            echo $current_subject->name;
            echo ' ชั้น ';
            echo Homeroom::homeroom_getbyid($current_subject->homeroom_id)->name;
          ?>
          <span class="caret"></span>
        </a>
        <ul role="menu" class="dropdown-menu dropdown-menu-right">
          <?php echo $subject_list_html; ?>
        </ul>
      </li>
      <?php } ?>

      <li class="">
        <a href="#" class="toggle-modal" data-target="#add-subject-modal" data-toggle="tooltip" data-placement="auto" title="เพิ่มวิชาที่สอน">
          <img src="images/svg/plus-13.svg" class="">
          <span class="visible-xs-inline-block ml-3">เพิ่มวิชาที่สอน</span>
        </a>
      </li>
    </ul>
    <?php } ?>

    <ul class="nav navbar-nav top-nav navbar-right">
      <?php if($user->role != 'Admin') {
        if($user->role == 'Student' || $user->role == 'Parent') {
          $where = array('receive_user_id' => $user->user_id);
        } else {
          if(System::session('mode') == 'Homeroom') {
            $where = array(
              'receive_user_id' => $user->user_id,
              'message_type' => array('1', '3', '5'),
              'homeroom_id' => System::session('homeroom_id')
            );
          } else {
            $where = array(
              'receive_user_id' => $user->user_id,
              'message_type' => array('0', '7'),
              'ref_id' => System::session('subject_id')
            );
          }
        }
        $message = Homeroom::message_getlist($where);
        $nmessage = count($message);
      ?>
      <li>
        <a href="message.php" title="ข้อความ" class="pmd-ripple-effect notification " data-toggle="tooltip" data-placement="auto" title="ข้อความ">
          <div data-badge="<?php echo $nmessage; ?>" class="material-icons md-light pmd-sm pmd-badge pmd-badge-overlap">
            <img src="<?php echo 'images/svg/icon-06.svg';?>" class="">
          </div>
        </a>
      </li>
      <?php } ?>
      <li>
      <?php
        if($user->role === 'Student' || $user->role === 'Parent') {
          $link = 'profile.php';
        } else if ($user->role === 'Teacher') {
          $link = 'manageuser.php?action=edit&id='.$user->user_id;
        } else {
          $link = '#';
        }
      ?>
        <a href="<?php echo $link; ?>">
          <img src="<?php echo 'images/svg/icon-profile.svg';?>" class="">
          <span class="ml-3">
            <?php echo $user->name.' '.$user->surname; ?>
          </span>
        </a>
      </li>
    </ul>
  </div>

</nav>
<!--End Nav bar -->
<!-- Header Ends -->

<?php
  include_once 'view/homeroom/add.php';
  include_once 'view/subject/add.php';
?>
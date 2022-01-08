<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');

  $user = System::get_current_user();
  $url = 'index.php';
  if($user->role === 'Teacher') {
    // change mode Homeroom <> Teacher
    if(isset($_GET['mode'])) {
      System::session('mode', $_GET['mode']);
    }

    // change homeroom class
    if(isset($_GET['homeroom_id'])) {
      System::session('homeroom_id', $_GET['homeroom_id']);
    }
    // change subject
    if(isset($_GET['subject_id'])) {
      System::session('subject_id', $_GET['subject_id']);
    }
    
    if(isset($_GET['url'])) {
      $url = $_GET['url'];
    }
  }
  System::redirect($url);
?>
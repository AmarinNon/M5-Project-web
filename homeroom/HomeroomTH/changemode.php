<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');

  $user = System::get_current_user();
  $url = 'index.php';
  if($user->role === 'Teacher') {
    if(isset($_GET['mode'])) {
      System::session('mode', $_GET['mode']);
    }
    if(isset($_GET['url'])) {
      $url = $_GET['url'];
    }
  }
  System::redirect($url);
?>
<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');

  $user = System::get_current_user();
  if($user->role === 'Admin') {
    System::redirect('manageuser.php');
  } else if($user->role === 'Teacher') {
    System::session('mode', 'homeroom');
  } else if($user->role === 'Parent') {
    System::redirect('calendar.php');
  } else if($user->role === 'Student') {
    System::redirect('calendar.php');

  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?php echo System::SITE_TITLE; ?> : หน้าหลัก</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
    $nopace = true;
    require_once 'import/defaultMeta.php';
    require_once 'import/loadCSS.php';
    ?>
  </head>

  <body>
    <?php
    define('PAGE_NAME', 'main');
    include_once 'view/main.php';
    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');

  $user = System::get_current_user();
  if($user->role === 'Student' || $user->role === 'Parent') {
  } else {
    System::redirect('login.php');
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?php echo System::SITE_TITLE; ?> : คะแนนเก็บ</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
    require_once 'import/defaultMeta.php';
    require_once 'import/loadCSS.php';
    ?>
  </head>

  <body>
    <?php
    define('PAGE_NAME', 'total-score');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';
    include_once 'view/total-score.php';
    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
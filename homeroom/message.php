<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?php echo System::SITE_TITLE; ?> : Message</title>
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
    define('PAGE_NAME', 'message');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';

    // router
    if($user->role === 'Teacher') {
      if(System::session('mode') == 'Homeroom') {
        include_once 'view/message/homeroom.php';
      } else {
        include_once 'view/message/teacher.php';
      }
    } else if ($user->role === 'Student') {
      include_once 'view/message/student.php';
    } else if ($user->role === 'Parent') {
      include_once 'view/message/parent.php';
    }

    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
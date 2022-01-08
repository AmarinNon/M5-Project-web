<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');

  $user = System::get_current_user();

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?php echo System::SITE_TITLE; ?></title>
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
    define('PAGE_NAME', 'profile');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';
    if($user->role === 'Student') {
      include_once 'view/profile/student.php';
    } else if($user->role === 'Parent') {
      include_once 'view/profile/parent.php';
    } else if ($user->role === 'Teacher') {
      include_once 'view/profile/profile.php';
    } else {
      System::redirect('login.php');
    }
    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
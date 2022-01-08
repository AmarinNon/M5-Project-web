<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');
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
    define('PAGE_NAME', 'homework');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';
    $user = System::get_current_user();

    // router
    if($user->role === 'Teacher') {
      if(System::session('mode') == 'Homeroom') {
        if(isset($_GET['action']) && $_GET['action'] == 'view') {
          include_once 'view/homework/view_detail.php';
        } else {
          include_once 'view/homework/homeroom.php';
        }
      } else {
        if(isset($_GET['action']) && $_GET['action'] == 'edit'){
          include_once 'view/homework/edit.php';
        } else {
          include_once 'view/homework/teacher.php';
        }
      }
    } else {
      if(isset($_GET['action']) && $_GET['action'] == 'view') {
        include_once 'view/homework/view_detail.php';
      } else {
        include_once 'view/homework/student.php';
      }
    }
    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
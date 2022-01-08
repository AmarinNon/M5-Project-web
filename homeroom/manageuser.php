<?php
  require_once 'import/defImport.php';
  System::login_require('login.php');

  Homeroom::check_permission(array('Admin', 'Teacher'), 'index.php');
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?php echo System::SITE_TITLE; ?> : Manage user</title>
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
    define('PAGE_NAME', 'manageuser');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';
    if(isset($_GET['action'])) {
      if($_GET['action'] === 'add') {
        include_once 'view/manageuser/add.php';
      } else if ($_GET['action'] === 'edit') {
        include_once 'view/manageuser/edit.php';
      } else if ($_GET['action'] === 'import') {
        include_once 'view/manageuser/import.php';
      } else {
        include_once 'view/manageuser/manageuser.php';
      }
    } else {
      if($user->role === 'Admin'){
        include_once 'view/manageuser/manageuser.php';
      }
      else {
        System::redirect('index.php');
      }
    }
    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
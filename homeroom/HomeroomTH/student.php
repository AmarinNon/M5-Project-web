<?php
  require_once 'import/defImport.php';
  Homeroom::check_permission(array('Teacher'), 'index.php');
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
    define('PAGE_NAME', 'student');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';
    if(System::session('mode') == 'Homeroom') {
      if(isset($_GET['action']) && $_GET['action'] == 'add') {
        // add student page
        include_once 'view/student/add.php';
      } else if(isset($_GET['action']) && $_GET['action'] == 'edit') {
        // edit student page
        include_once 'view/student/edit.php';
      } else if(isset($_GET['action']) && $_GET['action'] == 'import') {
        // edit student page
        include_once 'view/student/import.php';
      } else {
        // list student page
        if(count(Homeroom::homeroom_getlist(array(), true)) > 0) {
          include_once 'view/student/homeroom.php';
        } else {
          include_once 'view/nodata/homeroom.php';
        }
      }
    } else {
      include_once 'view/student/teacher.php';
    }
    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
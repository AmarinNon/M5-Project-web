<?php
  require_once 'import/defImport.php';
  Homeroom::check_permission(array('Teacher'), 'index.php');
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title><?php echo System::SITE_TITLE; ?> : คะแนนของทุกวิชา</title>
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
    define('PAGE_NAME', 'score');
    require_once 'layout/header.php';
    require_once 'layout/sidebar.php';

    // router
    if(System::session('mode') == 'Homeroom') {
      include_once 'view/score/homeroom.php';
    } else {
      include_once 'view/score/teacher.php';
    }

    require_once 'import/loadJS.php';
    ?>
  </body>

  </html>
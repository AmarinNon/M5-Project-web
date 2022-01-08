<?php
  require_once 'import/defImport.php';

  if(System::is_login()) {
    System::redirect('index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<title><?php echo System::SITE_TITLE; ?> : Login</title>
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

define('PAGE_NAME', 'login');
include_once 'view/login.php';
require_once 'import/loadJS.php';

?>
</body>

</html>
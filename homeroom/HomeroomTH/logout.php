<?php
  require_once 'import/defImport.php';
  
  System::logout();
  System::remove_session('homeroom_id');
  System::remove_session('subject_id');

  System::redirect('login.php');
?>
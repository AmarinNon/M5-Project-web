<?php
header('Content-Encoding: UTF-8');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=example_import_teacher.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF"; // UTF-8 BOM
$col_def = array(
  'Name',
  'Surname',
  'Username',
  'Password'
);

// header
echo implode(",", $col_def).PHP_EOL;

// example data
$row_1 = array(
  '"สมหวัง"',
  '"ดั่งใจปอง"',
  '"somwang1234"',
  '"123456"'
);
echo implode(",", $row_1).PHP_EOL;

?>
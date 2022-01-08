<?php
header('Content-Encoding: UTF-8');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=example_import_student.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF"; // UTF-8 BOM
$col_def = array(
  'Number',
  'Student ID',
  'Name Title',
  'Student Name',
  'Student Surname',
  'Parent Name',
  'Parent Surname',
  'Parent E-mail',
  'Parent phone number (only number)'
);

// header
echo implode(",", $col_def).PHP_EOL;

// example data
$row_1 = array(
  '"1"',
  '"610001"',
  '"Mr."',
  '"Some"',
  '"Example name"',
  '"Chai"',
  '"Example name"',
  '"example@gmail.com"',
  '"0801234567"'
);
echo implode(",", $row_1).PHP_EOL;

?>
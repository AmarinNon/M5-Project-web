<?php
header('Content-Encoding: UTF-8');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=example_import_student.csv");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF"; // UTF-8 BOM
$col_def = array(
  'เลขที่',
  'รหัสนักเรียน',
  'คำนำหน้านาม',
  'ชื่อนักเรียน',
  'นามสกุลนักเรียน',
  'ชื่อผู้ปกครอง',
  'นามสกุลผู้ปกครอง',
  'อีเมลผู้ปกครอง',
  'เบอร์โทรศัพท์ผู้ปกครอง (กรอกตัวเลขเท่านั้น)'
);

// header
echo implode(",", $col_def).PHP_EOL;

// example data
$row_1 = array(
  '"1"',
  '"610001"',
  '"ด.ช."',
  '"สมชาย"',
  '"นามสมมติ"',
  '"สมปอง"',
  '"นามสมมติ"',
  '"example@gmail.com"',
  '"0801234567"'
);
echo implode(",", $row_1).PHP_EOL;

?>
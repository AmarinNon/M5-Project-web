<?php
header('Content-type:application/json');
require_once '../import/defImport.php';

if($_REQUEST['mode'] == 'homeroom') {
  $homeroom_id = $_REQUEST['homeroom_id'];
  $where = array('homeroom_id' => $homeroom_id);
}
$homework = Homeroom::homework_getlist(
  $where,
  array('deadline_date' => 'DESC')
);

$events = array();

for($i = 0 ; $i < count($homework) ; $i++) {
  $subject = Homeroom::subject_getbyid($homework[$i]->subject_id);
  $date = date('Y-m-d', strtotime($homework[$i]->deadline_date));
  $event = array(
    'id' => $homework[$i]->id,
    'title' => ' ',
    'start' => $date,
    'end' => $date,
    'color' => $subject->color
  );
  array_push($events, $event);
}

echo json_encode($events);
?>
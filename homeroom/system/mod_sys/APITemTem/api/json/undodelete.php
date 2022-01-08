<?php
include '../../def/defImport.php';
include '../def/output_json.php';

// GET PARAMETER
$table = $_REQUEST['table'];
$id = $_REQUEST['id'];

// REQUIRED
$callarr = array(
	$table,
	$id
);

// INITIAL DATA
$data = array('status' => 'Active');
// UPDATE DATA
$where = array('id' => $id);
$result = Amst::update($table,$data,$where);

// IF FAILED
if (!$result)
	repError('Unable to undo delete data');

repNoData('success');
?>
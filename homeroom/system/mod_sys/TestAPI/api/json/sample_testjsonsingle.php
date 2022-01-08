<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

$wrap['sampleid'] = 1;
$wrap['sampletext'] = 'some sample text';
$wrap['samplenumber'] = 12345;

rep('Success',true,$wrap);
?>
<?php
if(!defined('CALLFROMMAIN'))
	die('Direct access not permitted');

for($i=1; $i<=5; $i++)
{
	$wrap[($i-1)]['sampleid'] = $i;
	$wrap[($i-1)]['sampletext'] = 'data '.$i;
	$wrap[($i-1)]['samplenumber'] = ($i*12);
}

rep('Success',true,$wrap);
?>
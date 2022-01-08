<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

startShow();
showTopic('All Post data');
foreach($_POST as $name => $value)
	show($name , $value);
endShow();

function showTopic($topic)
{
	echo '<tr><td colspan="2">'.$topic.'</td></tr>';
}
function startShow()
{	echo '<table>';	}
function show($topic, $data)
{	echo '<tr><td>'.$topic.'</td><td>'.$data.'</td></tr>';	}
function endShow()
{	echo '</table>';	}
?>
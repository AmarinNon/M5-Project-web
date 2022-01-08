<?php
function showMainBar($code)
{
	echo '<div class="row">';
	echo '<div class="col-md-12">';
	echo '<ul class="nav nav-tabs">';

	if($code=='status') $class='class="active"'; else $class='';
	echo '<li '.$class.'><a href="index.php">Status</a></li>';
	if($code=='function') $class='class="active"'; else $class='';
	echo '<li '.$class.'><a href="function.php">Function</a></li>';

	echo '<li class="pull-right"><a target="_blank" href="dbadminer.php">DB Adminer</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';

	echo '<br />';
}
?>
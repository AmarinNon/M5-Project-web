<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('high');

include 'php/function_core.php';

$core = new CoreManagement();

// form action
// system
if(isset($_POST['resetSystem']))
	$_POST['submitresult'] = DB::dropSQLTable();

// log
if(isset($_POST['clearActionLog']))
	$_POST['submitresult'] = Log::clearActionLog(User::getCurrentUserid());

if(isset($_POST['clearSQLLog']))
	$_POST['submitresult'] = Log::clearSQLLog(User::getCurrentUserid());

DB::regenerateSQLTable();

// other
$actionloglist = Log::getActionLog();
$sqlloglist = Log::getSQLLog();
$functionlist = Func::getFunction();
$userlist = User::getUser();

$tablelist = $core->getAllTable();

?>

<?php include '../../def/defHeader.php'; showMenuBar("core"); ?>

<div class="container">
	<?php include 'def/defHeader.php'; showMainBar('reset'); ?>

	<div class="row">
		<div class="span12 label label-important text-center">
			<? echo '<h4>Warning ! THIS IS [<strong> '.$_SERVER['SERVER_NAME'].' </strong>]</h4>'; ?>
		</div>
		<br /><br /><br />
	</div>

	<div class="row">
		<div class="span4">
			<legend>SQL</legend>
			<form method="POST" action="">
				<button class="btn btn-block btn-warning" name="clearSQLLog" value="1" type="submit">Clear SQL Log</button>
			</form>
		</div>
		<div class="span4">
			<legend>Action</legend>
			<form method="POST" action="">
				<button class="btn btn-block btn-warning" name="clearActionLog" value="1" type="submit">Clear Action Log</button>
			</form>
		</div>
		<div class="span4">
			<legend>System</legend>
			<form method="POST" action="">
				<button class="btn btn-block btn-danger" name="resetSystem" value="1" type="submit">RESET SYSTEM, RESET ALL</button>
			</form>
		</div>
	</div>
</div>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>

<?php include '../../def/defFooter.php'; ?>
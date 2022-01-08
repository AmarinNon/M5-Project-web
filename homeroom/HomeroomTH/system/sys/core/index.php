<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('high');

include 'php/function_core.php';

DBInit::regenerateSQLTable();

// other
$actionloglist = Log::getActionLog();
$sqlloglist = Log::getSQLLog();
$functionlist = Func::getFunction();
$userlist = User::getUser();

?>

<?php include '../../def/defHeader.php'; showMenuBar("core"); ?>

<div class="container">
	<?php include 'def/defHeader.php'; showMainBar('status'); ?>

	<div class="row">
		<div class="col-md-3">
			<legend>Info</legend>
			<table class="table table-striped table-bordered" cellspacing="0" width="100%">
				<tr>
					<th>System version</th>
					<td class='thincell'><?php echo Config::sysVersion; ?></td>
				</tr>
				<tr>
					<th>System Code Name</th>
					<td><?php echo Config::sysCodeName; ?></td>
				</tr>
				<tr>
					<th>Database Server</th>
					<td><?php echo Config::dbserver; ?></td>
				</tr>
				<tr>
					<th>Database Name</th>
					<td ><?php echo Config::dbname; ?></td>
				</tr>
				<tr>
					<th>Database Username</th>
					<td><?php echo Config::dbusername; ?></td>
				</tr>
				<tr>
					<th>Database Password</th>
					<td><?php echo Config::dbpassword; ?></td>
				</tr>

				<?php
				$logaddnum=0;
				foreach($actionloglist as $actionlog)
				{
					if (strpos($actionlog['description'],'add data') !== false)
						$logaddnum++;
				}

				$logeditnum=0;
				foreach($actionloglist as $actionlog)
				{
					if (strpos($actionlog['description'],'edit data') !== false)
						$logeditnum++;
				}

				$logremovenum=0;
				foreach($actionloglist as $actionlog)
				{
					if (strpos($actionlog['description'],'remove data') !== false)
						$logremovenum++;
				}

				if($sqlloglist) $sqlnum=count($sqlloglist); else $sqlnum=0;
				?>

				<tr>
					<th>Log ADD</th>
					<td class="text-success"><?php echo $logaddnum; ?></td>
				</tr>
				<tr>
					<th>Log EDIT</th>
					<td class="text-success"><?php echo $logeditnum; ?></td>
				</tr>
				<tr>
					<th>Log REMOVE</th>
					<td class="text-success"><?php echo $logremovenum; ?></td>
				</tr>
				<tr>
					<th>Log ERROR</th>
					<td class="text-danger"><?php echo $sqlnum; ?></td>
				</tr>
			</table>
		</div>

		<div class="col-md-3">
			<legend>Module</legend>
			<table class="table table-striped table-hover table-condensed table-bordered">
				<tr>
					<th>Function name</th>
					<th class='thincell'>Status</th>
				</tr>

				<?php
				foreach (Info::$moduleFile as $key => $value)
				{
					if(strpos(Info::$moduleFile[$key], 'mod/') === 0)
					{
						echo "<tr>";
						echo "<td>". $key ."</td>";
						if(file_exists('../../'.Info::$moduleFile[$key]))
							echo "<td><span class=\"label label-success\">Enable</span></td>";
						else
							echo "<td><span class=\"label label-danger\">Disable</span></td>";
						echo "</tr>";
					}
				}
				?>
			</table>
		</div>

		<div class="col-md-3">
			<legend>Module_SYS</legend>
			<table class="table table-striped table-hover table-condensed table-bordered">
				<tr>
					<th>Function name</th>
					<th class='thincell'>Status</th>
				</tr>

				<?php
				foreach (Info::$moduleFile as $key => $value)
				{
					if(strpos(Info::$moduleFile[$key], 'mod_sys/') === 0)
					{
						echo "<tr>";
						echo "<td>". $key ."</td>";
						if(file_exists('../../'.Info::$moduleFile[$key]))
							echo "<td><span class=\"label label-success\">Enable</span></td>";
						else
							echo "<td><span class=\"label label-danger\">Disable</span></td>";
						echo "</tr>";
					}
				}
				?>
			</table>
		</div>

		<div class="col-md-3">
			<legend>Module_EX</legend>
			<table class="table table-striped table-hover table-condensed table-bordered">
				<tr>
					<th>Function name</th>
					<th class='thincell'>Status</th>
				</tr>

				<?php
				foreach (Info::$moduleFile as $key => $value)
				{
					if(strpos(Info::$moduleFile[$key], 'mod_ex/') === 0)
					{
						echo "<tr>";
						echo "<td>". $key ."</td>";
						if(file_exists('../../'.Info::$moduleFile[$key]))
							echo "<td><span class=\"label label-success\">Enable</span></td>";
						else
							echo "<td><span class=\"label label-danger\">Disable</span></td>";
						echo "</tr>";
					}
				}
				?>
			</table>
		</div>
	</div>
</div>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function()
{
	
});
</script>

<?php include '../../def/defFooter.php'; ?>
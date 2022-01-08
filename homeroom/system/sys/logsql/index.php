<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('medium');

if(!isset($_GET['select']))
	$_GET['select'] = 'all';

if(isset($_POST['clearAll']))
	$_POST['submitresult'] = Log::clearSQLLog();
else if(isset($_POST['clearServer']))
	$_POST['submitresult'] = Log::clearSQLLogByType('server');
else if(isset($_POST['clearAPI']))
	$_POST['submitresult'] = Log::clearSQLLogByType('api');

else if($_GET['select']=='server')
	$sqlloglist = Log::getSQLLogByType('server');
else if($_GET['select']=='api')
	$sqlloglist = Log::getSQLLogByType('api');
else
	$sqlloglist = Log::getSQLLog();

?>

<?php include '../../def/defHeader.php'; showMenuBar("sql"); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav class="text-center">
				<ul class="pagination pagination-sm">
					<?php 
					if($_GET['select']=='all') $class='active'; else $class='';
					echo '<li class="'.$class.'"><a href="index.php?select=all">ALL</a></li>'; 
					if($_GET['select']=='server') $class='active'; else $class='';
					echo '<li class="'.$class.'"><a href="index.php?select=server">SERVER</a></li>';
					if($_GET['select']=='api') $class='active'; else $class='';
					echo '<li class="'.$class.'"><a href="index.php?select=api">API</a></li>';
					?>
				</ul>
			</nav>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			
			<form method="POST" action="">
				<div class="btn-group pull-right">
					<button class="btn btn-warning" name="clearServer" value="1" type="submit">Clear Server</button> &nbsp;&nbsp;&nbsp;
					<button class="btn btn-warning" name="clearAPI" value="1" type="submit">Clear API</button> &nbsp;&nbsp;&nbsp;
					<button class="btn btn-danger" name="clearAll" value="1" type="submit">Clear ALL</button>
				</div>
			</form>
			<br />
			<br />
			<br />

			<table class="table table-striped table-hover table-condensed table-bordered table-data">
				<thead>
					<tr>
						<th class="thincell">#</th>
						<th class="thincell">user</th>
						<th>SQL log</th>
						<th>Query</th>
						<th class="thincell">Type</th>
						<th class="thincell">Add Date</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach($sqlloglist as $array)
					{
						echo "<tr>";
						echo "<td>". $array["id"] ."</td>";

						echo "<td>". Amst::formatUser($array["userid"]) ."</td>";

						echo "<td style='word-break:break-word;'>". $array["description"] ."</td>";
						echo "<td style='word-break:break-word;'>". $array["sqlquery"] ."</td>";

						echo "<td>". $array["type"] ."</td>";
						echo "<td nowrap>". Amst::formatDate($array["datetime"]) ."</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>

<?php include '../../def/defFooter.php'; ?>
<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('high');

include 'php/function_core.php';

$core = new CoreManagement();

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

<?php include '../../def/defHeader.php'; showMenuBar("core"); ?>

<div class="container">
	<?php include 'def/defHeader.php'; showMainBar('sql'); ?>

	<div class="row">
		<div class="span12">
			<div class="pagination pagination-centered">
				<ul>
					<? 
					if($_GET['select']=='all') $class='active'; else $class='';
					echo '<li class="'.$class.'"><a href="sql.php?select=all">ALL</a></li>'; 
					if($_GET['select']=='server') $class='active'; else $class='';
					echo '<li class="'.$class.'"><a href="sql.php?select=server">SERVER</a></li>';
					if($_GET['select']=='api') $class='active'; else $class='';
					echo '<li class="'.$class.'"><a href="sql.php?select=api">API</a></li>';
					?>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="span12">
			<form method="POST" action="">
				<div class="btn-group pull-right">
					<button class="btn btn-warning" name="clearServer" value="1" type="submit">Clear Server</button> &nbsp;&nbsp;&nbsp;
					<button class="btn btn-warning" name="clearAPI" value="1" type="submit">Clear API</button> &nbsp;&nbsp;&nbsp;
					<button class="btn btn-danger" name="clearAll" value="1" type="submit">Clear ALL</button>
				</div>
			</form>

			<br />

			<table class="table table-striped table-hover table-condensed table-bordered">
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

				<tfoot>
					<tr>
						<th colspan="7" class="pager form-horizontal">
							<button type="button" class="btn first"><i class="icon-step-backward"></i></button>
							<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
							<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
							<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
							<button type="button" class="btn last"><i class="icon-step-forward"></i></button>
							<select class="pagesize input-mini" title="Select page size">
								<option selected="selected" value="10">10</option>
								<option value="20">20</option>
								<option value="30">30</option>
								<option value="40">40</option>
							</select>
							<select class="pagenum input-mini" title="Select page number"></select>
						</th>
					</tr>
				</tfoot>

				<tbody>
					<?
					if($sqlloglist!=null)
					{
						while($array = mysql_fetch_array($sqlloglist))
						{
							echo "<tr>";
							echo "<td>". $array["id"] ."</td>";
							
							if($array["type"]=='server')
								echo "<td>". $core->formatUser($array["userid"]) ."</td>";
							else if($array["type"]=='api')
								echo "<td>". $core->formatUserAPI($array["userid"]) ."</td>";
							else
								echo "<td>".$array["userid"]."</td>";

							echo "<td>". $array["description"] ."</td>";
							echo "<td>". $array["sqlquery"] ."</td>";

							echo "<td>". $array["type"] ."</td>";
							echo "<td class='thincell'>". date("D d/m/Y - H:i", strtotime($array["datetime"])) ."</td>";
							echo "</tr>";
						}
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
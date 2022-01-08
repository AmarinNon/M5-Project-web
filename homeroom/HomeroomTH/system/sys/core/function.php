<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('high');

include 'php/function_core.php';

$core = new CoreManagement();

// form action
// function
if(isset($_POST['addFunction']))
	$_POST['submitresult'] = Func::addFunction(array('name'=>$_POST['name'],'module'=>$_POST['module']));
else if(isset($_POST['editFunction']))
	$_POST['submitresult'] = Func::editFunction($_POST['editedid'],array('name'=>$_POST['editedname']));
else if(isset($_POST['swapFunction']))
	$_POST['submitresult'] = Func::swapFunction($_POST['currentidposition'],$_POST['movetoidposition']);
else if(isset($_POST['removeFunction']))
	$_POST['submitresult'] = Func::removeFunction($_POST['editedid'],$_POST['editedmodule'],$_POST['editedcode'],$_POST['editedname']);

// system
else if(isset($_POST['resetSystem']))
	$_POST['submitresult'] = DBInit::dropSQLTable();
// log
else if(isset($_POST['clearActionLog']))
	$_POST['submitresult'] = Log::clearActionLog();

else if(isset($_POST['clearSQLLog']))
	$_POST['submitresult'] = Log::clearSQLLog();

DBInit::regenerateSQLTable();

// other
$actionloglist = Log::getActionLog();
$sqlloglist = Log::getSQLLog();
$functionlist = Func::getFunction();
$userlist = User::getUser();

?>

<?php include '../../def/defHeader.php'; showMenuBar("core"); ?>

<div class="container">
	<?php include 'def/defHeader.php'; showMainBar('function'); ?>

	<div class="row">
		<div  class="col-md-3">
			<form method="POST" action="">
				<input class="form-control" name="name" type="text" placeholder="Full Name" required>
				<select class="form-control live" name="module" >
					<?php 
					foreach (Info::$moduleFile as $key => $value)
					{
						if(file_exists('../../'.Info::$moduleFile[$key]))
							echo "<option value='". $key ."'>". $key ."</option>";
					}
					?>
				</select>
				<button class="btn btn-block btn-success" name="addFunction" value="1" type="submit">Add</button>
			</form>

			<br />
			<legend></legend>
			<form method="POST" action="">
				<button class="btn btn-block btn-warning" name="clearSQLLog" value="1" type="submit">Clear SQL Log</button>
				<button class="btn btn-block btn-warning" name="clearActionLog" value="1" type="submit">Clear Action Log</button>
				<button class="btn btn-block btn-danger" name="resetSystem" value="1" type="submit">RESET SYSTEM, RESET ALL</button>
			</form>
		</div>

		<div class="col-md-9">
			<table class="table table-striped table-hover table-condensed table-bordered">
				<tr>
					<th class="thincell" colspan="2">จัดอันดับ</th>
					<th class="thincell">#</th>
					<th>Code</th>
					<th>Name</th>
					<th>Module</th>
					<th class="thincell">Add Date</th>
					<th class="thincell">Add By</th>
					<th class="thincell">&nbsp;</th>
				</tr>
				<?php
				$i=1;
				$sortarr = array();
				foreach($functionlist as $function)
					$sortarr[$i++] = $function['id'];

				$i=1;
				foreach($functionlist as $function)
				{
					echo "<tr>";

					echo '<td>';
					if(array_key_exists($i-1,$sortarr))
					{
						echo "<form method='POST' name='noconfirm' action='' class='nomargin'>";
						echo "<input type='hidden' name='currentidposition' value='".$sortarr[$i]."'>";
						echo "<input type='hidden' name='movetoidposition' value='".$sortarr[$i-1]."'>";
						echo '<button type="submit" name="swapFunction" class="btn btn-xs btn-default">';
						echo '<i class="glyphicon glyphicon-arrow-up"></i>';
						echo '</button>';
						echo "</form>";
					}
					echo '</td>';

					echo '<td>';
					if(array_key_exists($i+1,$sortarr))
					{
						echo "<form method='POST' name='noconfirm' action='' class='nomargin'>";
						echo "<input type='hidden' name='currentidposition' value='".$sortarr[$i]."'>";
						echo "<input type='hidden' name='movetoidposition' value='".$sortarr[$i+1]."'>";
						echo '<button type="submit" name="swapFunction" class="btn btn-xs btn-default">';
						echo '<i class="glyphicon glyphicon-arrow-down"></i>';
						echo '</button>';
						echo "</form>";
					}
					echo '</td>';

					echo "<td class='thincell'>". $function["id"] ."</td>";
					echo "<td>". $function["code"] ."</td>";
					echo "<td>". $function["name"] ."</td>";
					echo "<td>". $function["module"] ."</td>";
					echo "<td nowrap>" . Amst::formatDate($function["insertdatetime"]) . "</td>";

					echo "<td>". $core->formatUser($function["insertuserid"]) ."</td>";

					echo "<td class='thincell'><a id='". $function['id'] ."' role='button' class='btn btn-xs btn-default' data-toggle='edit'>Edit</a></td>";
					echo "</tr>";

					$i++;
				}
				?>
			</table>
		</div>
	</div>
</div>

<br /><br />

<!-- Modal zone -->
<form class="form-horizontal" method="POST" action="">
	<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit</h3>
				</div>
				<div class="modal-body">
					<input type="hidden" name="editedid" />
					<input type="hidden" name="editedmodule" />
					<div class="control-group">
						<label class="control-label">Code</label>
						<input type="text" name="editedcode" placeholder="Code" class="form-control" readonly>
					</div>
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text" name="editedname" placeholder="name" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-primary" name="editFunction" value="1">UPDATE</button>
					<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
					<div class="pull-left">
						<button class="btn btn-sm btn-danger" name="removeFunction" value="1">DELETE</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', 'a[data-toggle="edit"]', function() 
	{   
		var code = <?php echo "'function'" ?>;
		$.ajax({ url: '../../src/php/core_derive/Core_AjaxModal.php?code='+ code +'&id='+$(this).attr('id'),
			type: 'get',
			success: function(result) {
				var obj = jQuery.parseJSON(result);
				<?php $ajaxtable=Info::$sysTable['function']; include_once "../../def/defAjax.php"; ?>
				$('#editModal').modal('show');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert(this.url);
				alert("Status: " + textStatus); alert("Error: " + errorThrown); 
			}  
		});
	});
});
</script>

<?php include '../../def/defFooter.php'; ?>
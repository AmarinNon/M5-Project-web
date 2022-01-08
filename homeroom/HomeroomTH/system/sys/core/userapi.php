<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('high');

include 'php/function_core.php';

$core = new CoreManagement();

// form action
if(isset($_POST['add']))
	$_POST['submitresult'] = UserAPI::register($_POST['fullname']);
else if(isset($_POST['edit']))
	$_POST['submitresult'] = UserAPI::editInfo($_POST['editedid'],$_POST['editedfullname'],$_POST['editedapikey'],$_POST['editedstatus']);
else if(isset($_POST['remove']))
	$_POST['submitresult'] = UserAPI::removeUser($_POST['editedid']);

$userlist = UserAPI::getUser();

?>

<?php include '../../def/defHeader.php'; showMenuBar("core"); ?>

<div class="container">
	<?php include 'def/defHeader.php'; showMainBar('userapi'); ?>

	<div class="row">
		<div class="span3">
			<form action="" method="POST">
				<input type="text" class="input-block-level" name="fullname" placeholder="Fullname" required>
				<button class="btn btn-success btn-block" name="add" value="1">Register</button>
			</form>
		</div>

		<!-- Table data -->
		<div class="span6 table-scroll">
			<table class="table table-striped table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th class="thincell">#</th>
						<th>Fullname</th>
						<th class="thincell">API KEY</th>
						<th class="thincell">Login</th>
						<th class="thincell">Register</th>
						<th class="thincell">Status</th>
						<th class="thincell">&nbsp;</th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th colspan="12" class="pager form-horizontal">
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

				<!-- show user list -->
				<tbody>
					<?php
					if($userlist!=null)
					{
						while($array = mysql_fetch_array($userlist))
						{
							echo "<tr>";
							echo "<td class='thincell'>". $array['id'] ."</td>";
							echo "<td>". $array['fullname'] ."</td>";

							echo "<td>". $array['apikey'] ."</td>";

							if($array['lastlogin'] == "0000-00-00 00:00:00")
								echo "<td>Never</td>";
							else
								echo "<td>". date("d/m/Y", strtotime($array["lastlogin"])) ."</td>";
							echo "<td>". date("d/m/Y", strtotime($array["register"])) ."</td>";

							if($array['status'] == "Active")
								echo "<td>". $array['status'] ."</td>";
							else if($array['status'] == "Banned")
								echo "<td class='text-error'>". $array['status'] ."</td>";
							else
								echo "<td>". $array['status'] ."</td>";

							echo "<td><a id='". $array['id'] ."' role='button' class='btn btn-mini btn-inverse' data-toggle='edit'>Edit</a></td>";

							echo "</td>";
							echo "</tr>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal zone -->
<form class="form-horizontal" method="POST" action="">
	<div id="editModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="myModalLabel">Edit Information</h3>
		</div>
		<div class="modal-body">
			<input type="hidden" name="editedid" />
			<div class="control-group">
				<label class="control-label">Fullname</label>
				<div class="controls">
					<input type="text" name="editedfullname" placeholder="Fullname" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">API KEY</label>
				<div class="controls">
					<input type="text" name="editedapikey" placeholder="API KEY" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Status</label>
				<div class="controls">
					<select name="editedstatus">
						<option>Active</option>
						<option>Banned</option>
					</select>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" name="edit" value="1">Save changes</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<div class="pull-left">
				<button class="btn btn-danger" name="remove" value="1">DELETE</button>
			</div>
		</div>
	</div>
</form>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', 'a[data-toggle="edit"]', function()
	{
		var code = <?php echo "'userapi'" ?>;
		$.ajax({ url: '../../src/php/lib_ajax.php?ajaxselectid=1&code='+ code +'&id='+$(this).attr('id'),
			type: 'get',
			success: function(result) {
				var obj = jQuery.parseJSON(result);
				<?php
				$ajaxtable = Info::$sysTable['userapi'];
				$nameresult = Query::executeQuery("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".$ajaxtable."';");
				while($name = mysql_fetch_array($nameresult))
					echo "$('[name=edited".$name['COLUMN_NAME']."]').val(obj.response_data.".$name['COLUMN_NAME'].");";
				?>
				$('#editModal').modal('show')
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
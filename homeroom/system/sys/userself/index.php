<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('low');

// form action
if(isset($_POST['edit']))
{
	$arr = array(
		'password' => $_POST['newpassword'],
		);
	User::editUser($_POST['editedid'],$arr);

	$_POST['submitresult'] = true;
}

$user = User::getUserByID(User::getCurrentUserID());
?>

<?php include '../../def/defHeader.php'; showMenuBar("userself"); ?>

<div class="container content">
	<div class="row">
		<div class="col-sm-3">
			<legend>User Info</legend>
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="index.php">Account Information</a></li>
			</ul>
		</div>
		<!-- Table data -->
		<div class="col-sm-4">
			<legend>Account Information</legend>
			<table class="table table-striped table-hover table-condensed table-bordered">
				<?php
				echo "<tr>";
				echo "<th class='col-md-2'>Username</th>";
				echo "<td class='col-md-9'>".  $user['username'] ."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<th>Password</th>";
				echo "<td>";
				echo "********";
				echo "<div class='pull-right'><a id='". $user['id'] ."' role='button' class='btn btn-xs btn-default' data-toggle='edit'>Edit</a></div>";
				echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<th>Role</th>";
				if($user['role'] == "Admin")
					echo "<td class='text-error'>". $user['role'] ."</td>";
				else if($user['role'] == "Mod")
					echo "<td class='text-info'>". $user['role'] ."</td>";
				else
					echo "<td class='muted'>". $user['role'] ."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<th>Last Login</th>";
				if($user['lastlogin'] == "0000-00-00 00:00:00")
					echo "<td>Never</td>";
				else
					echo "<td>". date("d/m/Y H:i:s", strtotime($user["lastlogin"])) ."</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<th>Register</th>";
				echo "<td>". date("d/m/Y H:i:s", strtotime($user["register"])) ."</td>";
				echo "</tr>";
				?>
			</table>
		</div>
	</div>
</div>

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
					<div class="control-group">
						<label class="control-label">Password</label>
						<div class="controls">
							<input type="password" name="newpassword" placeholder="New Password" class="form-control">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-primary" name="edit" value="1">UPDATE</button>
					<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
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
		var code = <?php echo "'user'" ?>;
		$.ajax({ url: '../../src/php/core_derive/Core_AjaxModal.php?code='+ code +'&id='+$(this).attr('id'),
			type: 'get',
			success: function(result) {
				var obj = jQuery.parseJSON(result);
				<?php $ajaxtable=Info::$sysTable['user']; include_once "../../def/defAjax.php"; ?>
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
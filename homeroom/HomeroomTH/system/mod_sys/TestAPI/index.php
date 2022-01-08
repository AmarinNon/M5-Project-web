<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('low');

// form action
if(isset($_POST['adduser']))
	$_POST['submitresult'] = User::register($_POST['username'],$_POST['password'],'Mod');
else if(isset($_POST['edituser']))
{
	$arr = array(
		'password' => $_POST['newpassword'],
		);
	$_POST['submitresult'] = User::editUser($_POST['editedid'],$arr);
}
else if(isset($_POST['banuser']))
{
	$arr = array(
		'status' => 'Banned',
		);
	$_POST['submitresult'] = User::editUser($_POST['editedid'],$arr);
}
else if(isset($_POST['unbanuser']))
{
	$arr = array(
		'status' => 'Active',
		);
	$_POST['submitresult'] = User::editUser($_POST['editedid'],$arr);
}
else if(isset($_POST['deleteuser']))
{
	$arr = array(
		'status' => 'Deleted',
		);
	$_POST['submitresult'] = User::editUser($_POST['editedid'],$arr);
}
else if(isset($_POST['addpermission']))
	$_POST['submitresult'] = User::addUserPermission($_GET['user'],$_POST['functionid']);
else if(isset($_POST['removepermission']))
	$_POST['submitresult'] = User::removeUserPermission($_POST['editedid']);
?>

<?php 
include '../../def/defHeader.php'; showMenuBar('function'); showFunctionMenuBar($_GET['c']); 
?>

<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<legend>Register</legend>
			<form action="" method="POST">
				<input type="text" class="form-control" name="username" placeholder="Username" required>
				<input type="password" class="form-control" name="password" placeholder="Password" required>
				<button class="btn btn-success btn-block" name="adduser" value="1">Register</button>
			</form>
		</div>
		
		<div class="col-sm-5">
			<legend>Active User List</legend>

			<?php
			$userlist = User::getUser();

			if(!$userlist)
				echo '<div class="alert alert-danger" role="alert">No User Data.</div>';
			else
			{
				?>
				<table class="table table-hover table-condensed table-bordered">
					<tr>
						<th class="thincell">Role</th>
						<th>Username</th>
						<th class="thincell">Login</th>
						<th class="thincell">Register</th>
						<th class="thincell">&nbsp;</th>
						<th class="thincell">&nbsp;</th>
					</tr>
					<?php
					$rolearr = array(
						'Dev',
						'Mod',
						);
					foreach ($rolearr as $role) 
					{
						$where = array(
							'AND' => array(
								'role' => $role,
								'status' => 'Active'
								),
							'ORDER' => 'lastlogin DESC'
							);
						$userlist = User::getUserByList($where);

						$_GET['user'] = (isset($_GET['user']) ? $_GET['user'] : null);
						foreach($userlist as $user)
						{
							echo "<tr>";

							echo "<td>". Amst::formatUserRole($user['role']) . "</td>";
							echo "<td>" . Amst::formatUser($user['id']) ."</td>";

							if($user['lastlogin'] == "0000-00-00 00:00:00")
								echo "<td>Never</td>";
							else
								echo "<td nowrap>" . Amst::formatDate($user["lastlogin"]) . "</td>";
							echo "<td nowrap>" . Amst::formatDate($user["register"]) . "</td>";

							echo "<td>";
							echo "<a id='". $user['id'] ."' role='button' class='btn btn-xs btn-primary' data-toggle='edituser'><i class='glyphicon glyphicon-wrench'></i></a>";
							echo "</td>";

							if($user['id']==$_GET['user'])
								echo "<td><a class='btn btn-xs btn-primary' href='index.php?c=".$_GET['c']."&user=".$user['id']."'><i class='glyphicon glyphicon-chevron-right'></i></a></td>";
							else
								echo "<td><a class='btn btn-xs btn-default' href='index.php?c=".$_GET['c']."&user=".$user['id']."'><i class='glyphicon glyphicon-chevron-right'></i></a></td>";

							echo "</tr>";
						}
					}
					?>
				</table>
				<br />
				<?php

				$where = array(
					'status' => 'Banned',
					'ORDER' => 'lastlogin DESC'
					);
				$userlist = User::getUserByList($where);

				if($userlist)
				{
					?>
					<legend>Banned User List</legend>

					<table class="table table-hover table-condensed table-bordered">
						<tr>
							<th class="thincell">Role</th>
							<th>Username</th>
							<th class="thincell">Login</th>
							<th class="thincell">Register</th>
							<th class="thincell">&nbsp;</th>
							<th class="thincell">&nbsp;</th>
						</tr>
						<?php
						foreach($userlist as $user)
						{
							echo "<tr class='warning'>";

							echo "<td>". Amst::formatUserRole($user['role']) . "</td>";
							echo "<td>" . Amst::formatUser($user['id']) ."</td>";

							if($user['lastlogin'] == "0000-00-00 00:00:00")
								echo "<td>Never</td>";
							else
								echo "<td nowrap>" . Amst::formatDate($user["lastlogin"]) . "</td>";
							echo "<td nowrap>" . Amst::formatDate($user["register"]) . "</td>";

							echo "<td>";
							echo "<form action='' method='POST'>";
							echo "<input type='hidden' name='editedid' value='".$user['id']."'>";
							echo "<button type='submit' name='unbanuser' class='btn btn-xs btn-success'>unban</button>";
							echo "</form>";
							echo "</td>";
							
							echo "<td>";
							echo "<form action='' method='POST'>";
							echo "<input type='hidden' name='editedid' value='".$user['id']."'>";
							echo "<button type='submit' name='deleteuser' class='btn btn-xs btn-danger'>delete</button>";
							echo "</form>";
							echo "</td>";

							echo "</tr>";
						}
						?>
					</table>
					<?php
				}
			}
			?>
		</div>

		<div class="col-sm-4">
			<?php
			if(isset($_GET['user']))
			{
				$selectuser = User::getUserByID($_GET['user']);

				echo '<legend>Permission</legend>';

				if($selectuser['role']!='Mod')
					echo '<div class="alert alert-success" role="alert">User dont need permission</div>';
				else
				{
					$functionlist = Func::getFunction();
					$where = array(
						'userid' => $_GET['user']
						);
					$userpermissionlist = User::getUserPermissionByList($where);
					?>
					<table class="table table-hover table-condensed table-bordered">
						<?php
						foreach($functionlist as $function)
						{
							echo "<tr>";

							echo "<td>". $function['fullname'] . "</td>";

							$userPermission = User::isUserHavePermission($_GET['user'], $function['id']);
							echo "<td class='thincell'>";
							if($userPermission)
							{
								echo "<form action='' method='POST'>";
								echo "<input type='hidden' name='editedid' value='".$userPermission['id']."'>";
								echo "<button type='submit' name='removepermission' class='btn btn-xs btn-success'><i class='glyphicon glyphicon-ok'></i></button>";
								echo "</form>";
							}
							else
							{
								echo "<form action='' method='POST'>";
								echo "<input type='hidden' name='functionid' value='".$function['id']."'>";
								echo "<button type='submit' name='addpermission' class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i></button>";
								echo "</form>";
							}
							echo "</td>";

							echo "</tr>";
						}
						?>
					</table>
					<br />
					<?php
				}
			}
			?>
		</div>
	</div>
</div>

<!-- Modal zone -->
<form class="form-horizontal" method="POST" action="">
	<div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Edit User</h3>
				</div>
				<div class="modal-body">
					<input type="hidden" name="editedid" />
					<div class="control-group">
						<label class="control-label">Username</label>
						<input type="text" name="editedusername" placeholder="Username" class="form-control" readonly>
					</div>
					<div class="control-group">
						<label class="control-label">Password</label>
						<input type="password" name="newpassword" placeholder="New Password" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-sm btn-primary" name="edituser" value="1">UPDATE</button>
					<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
					<div class="pull-left">
						<button class="btn btn-sm btn-danger" name="banuser" value="1">BAN</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', 'a[data-toggle="edituser"]', function()
	{
		var code = <?php echo "'user'" ?>;
		$.ajax({ url: '../../src/php/core_derive/Core_AjaxModal.php?code='+ code +'&id='+$(this).attr('id'),
			type: 'get',
			success: function(result) {
				var obj = jQuery.parseJSON(result);
				<?php $ajaxtable=Info::$sysTable['user']; include_once "../../def/defAjax.php"; ?>
				$('#editUserModal').modal('show');
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
<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('low');

// form action
if(isset($_POST['adduser']))
	$_POST['submitresult'] = User::register($_POST['username'],$_POST['password'],$_POST['role']);
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
include '../../def/defHeader.php'; showMenuBar('function'); 
if(isset($_GET['c']))
	showFunctionMenuBar($_GET['c']); 
?>

<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<legend data-toggle="tooltip" data-placement="top" title="กรอกข้อมูลการลงทะเบียน">Register</legend>
			<form action="" method="POST">
				<label data-toggle="tooltip" data-placement="top" title="ชื่อผู้ใช้งาน">Username</label>
				<input id="username" type="text" class="form-control" name="username" placeholder="john" required>
				<label data-toggle="tooltip" data-placement="top" title="รหัสผ่าน">Password</label>
				<input id="password" type="password" class="form-control" name="password" placeholder="************" required>
				<label data-toggle="tooltip" data-placement="top" title="ประเภทผู้ใช้งาน">User type</label>
				<select name="role" class="form-control">
					<option value="Mod">Moderator</option>
					<option value="Dev">Developer</option>
				</select>
				<br />
				<button class="btn btn-success btn-block btn-lg" name="adduser" value="1" data-toggle="tooltip" data-placement="top" title="ยืนยันลงทะเบียน">Register</button>
			</form>
		</div>
		
		<div class="col-sm-5">
			<legend data-toggle="tooltip" data-placement="top" title="รายชื่อผู้ใช้งาน">User List</legend>

			<?php
			$userlist = User::getUser();

			if(!$userlist)
				echo '<div class="alert alert-danger" role="alert">No User Data.</div>';
			else
			{
				?>
				<table class="table table-hover table-condensed table-bordered">
					<tr>
						<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="ประเภทผู้ใช้งาน">Role</span></th>
						<th><span data-toggle="tooltip" data-placement="top" title="ชื่อผู้ใช้งาน">Username</span></th>
						<th class="thincell" nowrap><span data-toggle="tooltip" data-placement="top" title="วันที่เข้าใช้งานล่าสุด">Login</span></th>
						<th class="thincell" nowrap><span data-toggle="tooltip" data-placement="top" title="วันที่สมัคร">Register</span></th>
						<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="แก้ไขผู้ใช้งาน">&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
						<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="เลือกผู้ใช้งาน">&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
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
							'ORDER' => array('lastlogin'=>'DESC')
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

							echo "<td><a class='btn btn-xs btn-";
							if($user['id']==$_GET['user'])
								echo "primary";
							else
								echo "default";
							echo "' href='index.php?";
							if(isset($_GET['c']))
								echo "c=".$_GET['c']."&";
							echo "user=".$user['id']."'>";
							echo "<i class='glyphicon glyphicon-chevron-right'></i></a>";
							echo "</td>";

							echo "</tr>";
						}
					}
					?>
				</table>
				<br />
				<?php

				$where = array(
					'status' => 'Banned',
					'ORDER' => array('lastlogin' => 'DESC'),
					);
				$userlist = User::getUserByList($where);

				if($userlist)
				{
					?>
					<legend data-toggle="tooltip" data-placement="top" title="รายชื่อผู้ใช้งานที่ถูก BAN">Banned List</legend>

					<table class="table table-hover table-condensed table-bordered">
						<tr>
							<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="ประเภทผู้ใช้งาน">Role</span></th>
							<th><span data-toggle="tooltip" data-placement="top" title="ชื่อผู้ใช้งาน">Username</span></th>
							<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="วันที่เข้าใช้งานล่าสุด">Login</span></th>
							<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="วันที่สมัคร">Register</span></th>
							<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="แก้ไขผู้ใช้งาน">&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
							<th class="thincell"><span data-toggle="tooltip" data-placement="top" title="เลือกผู้ใช้งาน">&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
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

				if('Dev'==$selectuser['role'])
				{
					echo '<legend data-toggle="tooltip" data-placement="top" title="APIKEY สำหรับเรียก ข้อมูล">API Key</legend>';
					echo '<h4 class="text-center"><b>'.$selectuser['apikey'].'</b></h4><br />';
				}

				echo '<legend data-toggle="tooltip" data-placement="top" title="ความอนุญาติในการเข้าถึงข้อมูล">Permission</legend>';

				if('Mod'!=$selectuser['role'])
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

							echo "<td class='thincell'>". $function['module'] . "</td>";
							echo "<td>". $function['name'] . "'s system</td>";

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
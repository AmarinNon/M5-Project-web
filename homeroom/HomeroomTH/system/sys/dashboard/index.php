<?php 
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('low');

include 'php/function_dashboard.php';

$def = new DashboardManagement();

if(isset($_POST['addmemo']))
{
	$_POST['submitresult'] = User::addUserMemo($_POST['memo'],User::getCurrentUserID());
}

// prepare list
$actionloglist = Log::getActionLog();
$sqlloglist = Log::getSQLLog();
$functionlist = Func::getFunction();
$userlist = User::getUserLastOrderBy('lastlogin');
$usermemolist = User::getUserMemoLast();
?>

<?php include '../../def/defHeader.php'; showMenuBar("dashboard"); ?>

<div class="container intro">
	<div class="row">
		<div class="span12">
			<div class="page-header">
				<h1><?php echo Config::sysCustomer; ?> <small>by @Amstr_</small></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="span4">
			<legend>Lastest Login</legend>
			<table class="table table-striped table-hover table-condensed table-bordered">

				<tr>
					<th>Username</th>
					<th class="thincell">LastLogin</th>
				</tr>
				<?
				if($userlist!=null)
				{
					$i = 0;

					mysql_data_seek( $userlist, 0 );
					while($user = mysql_fetch_array($userlist))
					{
						if($user['role']=='Dev' || $user['role']=='Admin' || $user['role']=='Mod')
						{
							echo "<tr>";
							echo "<td>".$def->formatUser($user['id'])."</td>";
							if($user['lastlogin'] == "0000-00-00 00:00:00")
								echo "<td>Never</td>";
							else
								echo "<td>". date("d/m/Y", strtotime($user["lastlogin"])) ."</td>";
							echo "</tr>";

							$i++;
							if($i==10) break;
						}
					}
				}
				else
					echo "NO USER";
				?>
			</table>
		</div>

		<div class="span8">
			<legend>Memo</legend>
			<table class="table table-hover table-condensed table-bordered">

				<tr>
					<th class="thincell">Username</th>
					<th>Memo</th>
					<th class="thincell">Datetime</th>
				</tr>
				<?
				if($usermemolist!=null)
				{
					$i = 0;

					mysql_data_seek( $usermemolist, 0 );
					while($usermemo = mysql_fetch_array($usermemolist))
					{
						echo "<tr>";
						echo "<td>".$def->formatUser($usermemo['userid'])."</td>";
						echo "<td>".$usermemo['memo']."</td>";
						echo "<td>". date("d/m/Y_h:i:s", strtotime($usermemo["datetime"])) ."</td>";
						echo "</tr>";

						$i++;
						if($i==10) break;
					}
				}
				else
					echo "NO USER";
				?>
			</table>

			<table class="table table-hover">
				<tr>
					<form method="POST" action="">
						<td width="70%"><input type="text" name="memo" placeholder="Type memo here.." class="input-block-level input-mini"> </td>
						<td class="thincell"><input type="submit" name="addmemo" class="btn btn-small btn-block btn-inverse" value=" ADD MEMO "></td>
					</form>
				</tr>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="span12"><legend><br />Contact Admin</legend></div>
		<div class="span4">
			<a class="btn btn-block btn-inverse"  href="https://www.facebook.com/amstre" target="_blank">Facebook : Amstre</a>
			<br />
		</div>
		<div class="span4">
			<a class="btn btn-block btn-inverse"  href="https://twitter.com/Amstr_" target="_blank">Twitter : @Amstr_</a>
			<br />
		</div>
		<div class="span4">
			<a class="btn btn-block btn-inverse"  href="https://github.com/amstre" target="_blank">Github : Amstre</a>
			<br />
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
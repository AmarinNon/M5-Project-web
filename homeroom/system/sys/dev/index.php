<?php 
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('medium');

include 'php/function_api.php';

$api = new APIManagement();

$functionlist = Func::getFunction();

if(isset($_GET['select']))
	$selectfunc = Func::getFunctionByModule($_GET['select']);

$currentuser = User::getUserByID(User::getCurrentUserID());
?>

<?php include '../../def/defHeader.php'; showMenuBar("dev"); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<legend>Functions</legend>
			<table class='table table-hover table-condensed table-bordered'>
				<tr>
					<th class="thincell">#</th>
					<th>Function</th>
					<th class="thincell">&nbsp;</th>
				</tr>

				<?php
				$exists_function = array();
				foreach ($functionlist as $function) 
				{
					if(!in_array($function['module'], $exists_function))
					{
						echo "<tr>";

						echo "<td class='text-right'><b>".Func::countFunctionBy(array('module' => $function['module']))."</b></td>";
						echo "<td>".$function['module']."</td>";

						if((isset($_GET['select']) ? $_GET['select'] : null)==$function['module'])
							echo "<td><a class='btn btn-xs btn-primary' href='index.php?c=".$function['code']."&select=".$function['module']."'><i class='glyphicon glyphicon-chevron-right'></i></a></td>";
						else
							echo "<td><a class='btn btn-xs btn-default' href='index.php?c=".$function['code']."&select=".$function['module']."'><i class='glyphicon glyphicon-chevron-right'></i></a></td>";

						echo "</tr>";

						array_push($exists_function, $function['module']);
					}
				}
				?>
			</table>
		</div>

		<?php
		if(isset($_GET['select']))
		{
			$url = ROOT_URL;
			?>
			<div class="col-sm-9">
				<legend>JSON API</legend>

				<b>CALL THIS LINK</b> <i class="glyphicon glyphglyphicon glyphicon-link"></i> <br /><b class="text-success"><?php echo $url.'/api/json/main.php'; ?></b><br />

				<hr />

				<b>All available "code" to call</b>
				<table class="table table-condensed table-bordered">
					<tr>
						<th class="thincell">code</th>
						<th>name</th>
						<th class="thincell" nowrap>owner id</th>
					</tr>

					<?php
					$availablefunctionlist = Func::getFunctionBy(array('module' => $_GET['select']));

					foreach($availablefunctionlist as $availablefunction)
					{
						echo '<tr>';

						echo '<td>'.$availablefunction['code'].'</td>';
						echo '<td>'.$availablefunction['name'].'</td>';
						echo '<td>'.$availablefunction['insertuserid'].'</td>';

						echo '</tr>';
					}
					?>
				</table>

				<hr />

				<?php
				if(file_exists('../../'.Info::$moduleFile[$selectfunc['module']].'/required/info_api.php'))
				{
					$modulename = $selectfunc['module'];
					include('../../'.Info::$moduleFile[$selectfunc['module']].'/required/info_api.php');
					?>

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
						foreach($apiinfo[$selectfunc['module']] as $topic => $data)
						{
							if($topic == 'PINONTOP')
							{
								foreach($data as $key => $value)
								{
									?>
									<div class="row">
										<div class="col-sm-7">
											<p style="font-size:20px;"><b><?php echo $key; ?></b></p>
											<p><b>Description : </b><?php echo $value['description']; ?></p>
											<h5>PARAMETER <i class="glyphicon glyphglyphicon glyphicon-arrow-down"></i></h5>
											<table class='table table-striped table-hover table-condensed table-bordered'>
												<tr>
													<th class="thincell">Name</th>
													<th>memo</th>
												</tr>

												<tr>
													<td>apikey</td>
													<td><?php echo $currentuser['apikey']; ?></td>
												</tr>
												<tr>
													<td>code</td>
													<td>select code from above</td>
												</tr>
												<?php
												foreach($value['required'] as $requiredkey => $requiredvalue)
												{
													echo '<tr>';
													echo '<td>'.$requiredkey.'</td>';
													echo '<td>'.$requiredvalue.'</td>';
													echo '</tr>';
												}
												?>
											</table>
										</div>

										<div class="col-sm-5">
											<h3 class="text-left"><i class="glyphicon glyphglyphicon glyphglyphicon glyphicon-chevron-down"></i> return json</h3>
											<?php
											if($value['return']=='none')
												echo $api->showReturnJsonNoData(); 
											else if($value['return']=='text')
												echo $api->showReturnJsonTextDescription($value['returndata']); 
											else if($value['return']=='custom') 
												echo $api->showReturnJsonCustomData($value['returndata']); 
											else
											{
												$structurelist = Amst::query("SHOW COLUMNS FROM ".Info::moduleTablePrefix.$selectfunc['code'].'_'.$value['returntable']);
												echo $api->showReturnJson($structurelist); 
											}
											?>
										</div>
									</div>

									<hr />
									<?php
								}
							}
						}
						?>
					</div>
					
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
						$num = 1;
						foreach($apiinfo[$selectfunc['module']] as $topic => $data)
						{
							if($topic != 'PINONTOP')
							{
								?>

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="collapsed" data-toggle="collapse" href="#tab<?php echo $num; ?>"  style="font-size:25px;">
												<?php echo $topic; ?>
											</a>
										</h4>
									</div>
									<div id="tab<?php echo $num; ?>" class="panel-collapse collapse">
										<div class="panel-body">
											<?php
											foreach($data as $key => $value)
											{
												?>
												<div class="row">
													<div class="col-sm-7">
														<p style="font-size:20px;"><b><?php echo $key; ?></b></p>
														<p><b>Description : </b><?php echo $value['description']; ?></p>
														<h5>PARAMETER <i class="glyphicon glyphglyphicon glyphicon-arrow-down"></i></h5>
														<table class='table table-striped table-hover table-condensed table-bordered'>
															<tr>
																<th class="thincell">Name</th>
																<th>memo</th>
															</tr>

															<tr>
																<td>apikey</td>
																<td><?php echo $currentuser['apikey']; ?></td>
															</tr>
															<tr>
																<td>code</td>
																<td>select code from above</td>
															</tr>
															<?php
															foreach($value['required'] as $requiredkey => $requiredvalue)
															{
																echo '<tr>';
																echo '<td>'.$requiredkey.'</td>';
																echo '<td>'.$requiredvalue.'</td>';
																echo '</tr>';
															}
															?>
														</table>
													</div>

													<div class="col-sm-5">
														<h3 class="text-left"><i class="glyphicon glyphglyphicon glyphglyphicon glyphicon-chevron-down"></i> return json</h3>
														<?php
														if($value['return']=='none')
															echo $api->showReturnJsonNoData(); 
														else if($value['return']=='text')
															echo $api->showReturnJsonTextDescription($value['returndata']); 
														else if($value['return']=='custom') 
															echo $api->showReturnJsonCustomData($value['returndata']); 
														else if($value['return']=='copy') 
															echo $api->showReturnJsonCustomData($data[$value['returndata']]['returndata']); 
														else
														{
															$structurelist = Amst::query("SHOW COLUMNS FROM ".Info::moduleTablePrefix.$selectfunc['code'].'_'.$value['returntable']);
															echo $api->showReturnJson($structurelist); 
														}
														?>
													</div>
												</div>

												<hr />
												<?php
											}
											?>
										</div>
									</div>
								</div>
								<?php
							}
							$num++;
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
</div>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function()
{

});
</script>

<?php include '../../def/defFooter.php'; ?>
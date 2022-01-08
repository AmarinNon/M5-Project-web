<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('low');


include '../../def/defHeader.php'; showMenuBar('function'); showFunctionMenuBar($_GET['c']); 
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">

		</div>
	</div>
</div>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>

<?php include '../../def/defFooter.php'; ?>
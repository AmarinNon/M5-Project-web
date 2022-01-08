<?php
include '../../def/defImport.php';
include '../../def/defCheckUser.php'; checkUser('low');
?>

<?php 
include '../../def/defHeader.php'; showMenuBar('function'); showFunctionMenuBar($_GET['c']); 
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center text-muted" style="margin-top:100px; margin-bottom:100px;">ไม่มีหน้าการจัดการหลังบ้าน</h3>
		</div>
	</div>
</div>

<?php include '../../def/defJS.php'; ?>
<script type="text/javascript">
$(document).ready(function(){
	
});
</script>

<?php include '../../def/defFooter.php'; ?>
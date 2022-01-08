<?php
$nameresult = Amst::query("SELECT  `COLUMN_NAME` FROM  `INFORMATION_SCHEMA`.`COLUMNS` WHERE  `TABLE_SCHEMA` =  '".Config::dbname."' AND  `TABLE_NAME` =  '".$ajaxtable."';");
foreach($nameresult as $name)
	echo "$('[name=edited".$name['COLUMN_NAME']."]').val(obj.response_data.".$name['COLUMN_NAME'].");";
?>
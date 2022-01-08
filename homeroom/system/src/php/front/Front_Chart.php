<?php
class ChartManagement {
	
	function generate1StatChart($idtarget, $year, $name, $list, $color)
	{
		echo '$.plot("#'.$idtarget.'", [ ';
		echo '{ label: "'.$name.'", data:';
		echo '[';
		for($month=1; $month<=12; $month++)
			echo '['.$month.','.$list[$month-1].'],';
		echo '], color: "'.$color.'" },';
		echo '], {';
		echo 'series: {';
		echo 'points: {show: true},';
		echo 'lines: { show: true,fill: true,}';
		echo '},';
		echo 'grid: {';
		echo 'hoverable: true,';
		echo 'clickable: true,';
		echo '}';
		echo'});';
	}

	function generate2StatChart($idtarget, $year, $name1, $name2, $list1, $list2, $color1, $color2)
	{
		echo '$.plot("#'.$idtarget.'", [ ';
		echo '{ label: "'.$name1.'", data:';
		echo '[';
		for($month=1; $month<=12; $month++)
			echo '['.$month.','.$list1[$month-1].'],';
		echo '], color: "'.$color1.'" },';
		echo '{ label: "'.$name2.'", data:';
		echo '[';
		for($month=1; $month<=12; $month++)
			echo '['.$month.','.$list2[$month-1].'],';
		echo '], color: "'.$color2.'" },';
		echo '], {';
		echo 'series: {';
		echo 'points: {show: true},';
		echo 'lines: { show: true,fill: true,}';
		echo '},';
		echo 'grid: {';
		echo 'hoverable: true,';
		echo 'clickable: true,';
		echo '}';
		echo'});';
	}

	function generateDonut($idtarget,$data)
	{
		echo '$.plot("#'.$idtarget.'", [';
		foreach ($data as $key => $value)
			echo '{ label: "'.$key.'", data: '.$value.' },';
		echo '], {';
		echo 'series: {';
		echo 'pie: {';
		echo 'innerRadius: 0.5,';
		echo 'show: true}';
		echo '},';
		echo 'grid: {hoverable: true,clickable: true,}';
		echo '});';
	}

	function generateCategoryChart($idtarget,$data)
	{
		echo '$.plot("#'.$idtarget.'", [';
		$num = 1;
		foreach ($data as $key => $value)
			echo '{label: "'.$key.'",data: [['.$num++.', '.$value.']]},';
		echo '], {';
		echo 'series: {';
		echo 'lines: {fill: true,},';
		echo 'bars: { show: true, align:"center",}';
		echo '},';
		echo 'grid: { hoverable: true},';
		echo 'xaxis: {';
		echo 'ticks: [';
		$num = 1;
		foreach ($data as $key => $value)
			echo '['.$num++.', "'.$key.'"],';
		echo ']}';
		echo '});';
	}
}
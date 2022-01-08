<?php
class APIManagement extends Amst
{	
	function showReturnJson($structurelist)
	{
		?>
		<span style="margin-left:0px;">{</span><br />
		<span style="margin-left:20px;"></span>"response_message": "[message]",<br />
		<span style="margin-left:20px;"></span>"response_status": [true||false],<br />
		<span style="margin-left:20px;"></span>"response_rows": [num rows],<br />
		<span style="margin-left:20px;"></span>"response_data": [<br />
		<span style="margin-left:40px;"></span>{<br />
		<?php
		foreach($structurelist as $structure) 
			echo '<span style="margin-left:60px;"></span>"'.$structure['Field'].'" : "[value]",<br />';
		?>
		<span style="margin-left:40px;"></span>},<br />
		<span style="margin-left:20px;"></span>]<br />
		<span style="margin-left:0px;">}<br />
		<?php
	}	

	function showReturnJsonWArray($structurelist)
	{
		?>
		<span style="margin-left:0px;">{</span><br />
		<span style="margin-left:20px;"></span>"response_message": "[message]",<br />
		<span style="margin-left:20px;"></span>"response_status": [true||false],<br />
		<span style="margin-left:20px;"></span>"response_rows": [num rows],<br />
		<span style="margin-left:20px;"></span>"response_data": [<br />
		<span style="margin-left:40px;"></span>{<br />
		<?php
		foreach($structurelist as $structure) 
			echo '<span style="margin-left:60px;"></span>"'.$structure['Field'].'" : "[value]",<br />';
		?>
		<span style="margin-left:40px;"></span>},<br />
		<span style="margin-left:40px;"></span>{},..{} * array of data<br />
		<span style="margin-left:20px;"></span>]<br />
		<span style="margin-left:0px;">}<br />
		<?php
	}	

	function showReturnJsonNoData()
	{
		?>
		<span style="margin-left:0px;">{</span><br />
		<span style="margin-left:20px;"></span>"response_message": "[message]",<br />
		<span style="margin-left:20px;"></span>"response_status": [true||false],<br />
		<span style="margin-left:0px;">}<br />
		<?php
	}	

	function showReturnJsonTextDescription($text)
	{
		?>
		<h4 style="margin-left:0px;"><?php echo $text; ?></h4>
		<?php
	}	

	function showReturnJsonCustomData($customdata)
	{
		?>
		<span style="margin-left:0px;">{</span><br />
		<span style="margin-left:20px;"></span>"response_message": message (string),<br />
		<span style="margin-left:20px;"></span>"response_status": boolean (true,false),<br />
		<span style="margin-left:20px;"></span>"response_rows": num_rows (int),<br />
		<span style="margin-left:20px;"></span>"response_data": <br />
		<span style="margin-left:20px;"></span>{<br />
		<?php
		$this->loopShowJson(40,$customdata);
		?>
		<span style="margin-left:20px;">}<br />
		<span style="margin-left:0px;">}<br />
		<?php
	}

	function showJson($margin,$data)
	{
		echo '<span style="margin-left:'.$margin.'px;">'.$data.'</span><br />';
	}

	function loopShowJson($margin,$json)
	{
		foreach($json as $jsonkey => $jsondata)
		{
			if(!is_array($jsondata))
				$this->showJson($margin,'<span data-toggle="tooltip" data-placement="top" title="'.$jsondata.'">"'.$jsonkey.'"</span>');
			else
			{
				$this->showJson($margin,'<span data-toggle="tooltip" data-placement="top" title="array">"'.$jsonkey.'"</span> {');
				$this->loopShowJson($margin+20,$jsondata);
				$this->showJson($margin,'},');
			}
		}
	}
}
?>
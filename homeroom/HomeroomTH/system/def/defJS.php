<?php
// add js
$jsArr = array(
	// default
	'jquery-1.10.2.min.js',
	'bootstrap.min.js',

	// loading page
	'pace.min.js',

	// alertify
	'alertify.min.js',

	// lightbox
	'lightbox.js',

	// select
	'bootstrap-select.min.js',

	// tag input
	'bootstrap-tagsinput.min.js',

	// datatable
	'jquery.dataTables.min.js',
	'jquery.dataTables.bootstrap.js',

	// wysiwyg
	'wysihtml5.min.js',
	'bootstrap-wysihtml5.min.js',

	// live stamp for datetime
	'moment.js',
	'livestamp.min.js',

	// cookie
	'jquery.cookie.js',

	// default again
	'default.js',

	// date input polyfill https://github.com/brianblakely/nodep-date-input-polyfill
	'nodep-date-input-polyfill.dist.js',

	// thailand address autocomplete
	'jquery.Thailand.js/dependencies/JQL.min.js',
	'jquery.Thailand.js/dependencies/typeahead.bundle.js',
	'jquery.Thailand.js/dist/jquery.Thailand.min.js',

	// Zyser/s Datepicker JS
	'zDatepicker.js'
	);
foreach ($jsArr as &$value)
	echo '<script type="text/javascript" src="../../src/js/'.$value.'"></script>';

// add lib
$jsArr = array(
	// tinymce
	'tinymce/tinymce.min.js'
	);
foreach ($jsArr as &$value)
	echo '<script type="text/javascript" src="../../src/lib/'.$value.'"></script>';

?>

<!-- Theme -->
<?php
	include '../../src/theme/js.php';
?>

<?php
// alertify
if(count($_POST)!=0) // for post alerify if exist
{
	if(isset($_POST['submitresult']))
	{
		if($_POST['submitresult'])
		{
			$text = "<b>Operation Successful</b>";
			echo '<script>alertify.success("'.$text.'");</script>';
		}
		else if(!$_POST['submitresult'])
		{
			$text = "<b>Operation Unsuccessful</b>";
			echo '<script>alertify.error("'.$text.'");</script>';
		}
	}
}
else if(isset($_GET['submitresult'])) // for get alertify
{
	if($_GET['submitresult'])
	{
		$text = "<b>Operation Successful</b>";
		echo '<script>alertify.success("'.$text.'");</script>';
	}
	else
	{
		$text = "<b>Operation Unsuccessful</b>";
		echo '<script>alertify.error("'.$text.'");</script>';
	}
}

if(isset($_GET['debugmessage']))
	echo '<script>alertify.log("DEBUG : '.$_GET['debugmessage'].'");</script>';
?>

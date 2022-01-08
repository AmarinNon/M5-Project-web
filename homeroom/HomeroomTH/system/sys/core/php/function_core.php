<?php
class CoreManagement extends Amst
{	
	function getAllTable()
	{
		$sql = "SHOW TABLES FROM ".Config::dbname;
		
		return Amst::query($sql);
	}

	function getTableStructure($tablename)
	{
		$sql = "DESCRIBE ".$tablename;
		
		return Amst::query($sql);
	}

	function getTableElementASC($tablename)
	{
		$sql = "SELECT * FROM ".$tablename." ORDER BY id ASC";
		
		return Amst::query($sql);
	}

	function getTableElementDESC($tablename)
	{
		$sql = "SELECT * FROM ".$tablename." ORDER BY id DESC";
		
		return Amst::query($sql);
	}

	function removeTableElement($tablename,$id)
	{
		$sql = "DELETE FROM ".$tablename." WHERE id = ".$id;

		return Amst::query($sql);
	}

	function truncateTable($tablename)
	{
		$sql = "TRUNCATE TABLE ".$tablename;

		return Amst::query($sql);
	}

}
?>
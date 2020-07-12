<?php

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/modules/tecnoinmo/include/defines.inc.php";

class TecnoinmoZona extends XoopsObject
{
	var $db;

	//constructor
	function TecnoinmoZona($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("c_zona", XOBJ_DTYPE_INT, null, false);
		$this->initVar("d_zona", XOBJ_DTYPE_TXTBOX, null, true, 255);
		
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
				$this->load(intval($id));
			}
		}
	}

	// public
	function store()
	{
		if ( !$this->cleanVars() ) {
			return false;
		}
		foreach ( $this->cleanVars as $k=>$v ) {
			$$k = $v;
		}
		if ( empty($c_zona) ) {
			$c_zona = $this->db->genId($this->db->prefix(ZONA_TABLA)."_zona_id_seq");
			$sql = "INSERT INTO ".$this->db->prefix(ZONA_TABLA)." (c_zona, d_zona) VALUES ($c_zona, ".$this->db->quoteString($d_zona).")";
		} else {
			$sql ="UPDATE ".$this->db->prefix(ZONA_TABLA)." SET  d_zona=".$this->db->quoteString($d_zona)." WHERE c_zona=$c_zona";
		}
		//echo $sql;
		if ( !$result = $this->db->query($sql) ) {
			$this->setErrors("Could not store data in the database.");
			return false;
		}
		if ( empty($c_zona) ) {
			return $this->db->getInsertId();
		}
		return $c_zona;
	}

	// private
	function load($id)
	{
		$sql = "SELECT * FROM ".$this->db->prefix(ZONA_TABLA)." WHERE c_zona=".$id."";
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
	}

	// public
	function delete()
	{
		$sql = sprintf("DELETE FROM %s WHERE c_zona = %u", $this->db->prefix(ZONA_TABLA), $this->getVar("c_zona"));
        	if ( !$this->db->query($sql) ) {
			return false;
		}
		return true;
	}

	// private, static
	function &getAll($criteria=array(), $asobject=true, $orderby="c_zona DESC", $limit=0, $start=0)
	{
		$db =& Database::getInstance();
		$ret = array();
		$where_query = "";
		if ( is_array($criteria) && count($criteria) > 0 ) {
			$where_query = " WHERE";
			foreach ( $criteria as $c ) {
				$where_query .= " $c AND";
			}
			$where_query = substr($where_query, 0, -4);
		}
		if ( !$asobject ) {
			$sql = "SELECT c_zona FROM ".$db->prefix(ZONA_TABLA)."$where_query ORDER BY $orderby";
			$result = $db->query($sql,intval($limit),intval($start));
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['c_zona'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix(ZONA_TABLA)."".$where_query." ORDER BY $orderby";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new TecnoinmoZona($myrow);
			}
		}
		//echo $sql;
		return $ret;
	}
	
	//public satic
	//Devuelve un array con todas las zonas
	function getAllZonesArray()
	{	
		$db =& Database::getInstance();
		$sql = "SELECT * FROM ".$db->prefix(ZONA_TABLA)."";
		$result = $db->query($sql);
		while ( $myrow = $db->fetchArray($result) ) {
			$ret[$myrow["c_zona"]]=$myrow["d_zona"];
		}
		return $ret;
	}
}
?>
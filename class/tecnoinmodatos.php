<?php

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/modules/tecnoinmo/include/defines.inc.php";

class TecnoinmoDatos extends XoopsObject
{
	var $db;

	//constructor
	function TecnoinmoDatos($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("c_agencia", XOBJ_DTYPE_INT, null, false);
		$this->initVar("nombre", XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar("direccion", XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar("telefono", XOBJ_DTYPE_TXTBOX, null, true, 100);
		$this->initVar("fax", XOBJ_DTYPE_TXTBOX, null, true, 100);
		$this->initVar("email", XOBJ_DTYPE_EMAIL, null, true, 100);
		
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
		if ( empty($c_agencia) ) {
			$c_agencia = $this->db->genId($this->db->prefix(AGENCIA_TABLA)."_agencia_id_seq");
			$sql = "INSERT INTO ".$this->db->prefix(AGENCIA_TABLA)." (c_agencia, nombre, direccion, telefono, fax, email) VALUES ($c_agencia, ".$this->db->quoteString($nombre).",".$this->db->quoteString($direccion).",".$this->db->quoteString($telefono).",".$this->db->quoteString($fax).",".$this->db->quoteString($email).")";
		} else {
			$sql ="UPDATE ".$this->db->prefix(AGENCIA_TABLA)." SET  nombre=".$this->db->quoteString($nombre).", direccion=" .$this->db->quoteString($direccion). ", telefono=".$this->db->quoteString($telefono).", fax=".$this->db->quoteString($fax).", email=".$this->db->quoteString($email)." WHERE c_agencia=$c_agencia";
		}
		//echo $sql;
		if ( !$result = $this->db->query($sql) ) {
			$this->setErrors("Could not store data in the database.");
			return false;
		}
		if ( empty($c_agencia) ) {
			return $this->db->getInsertId();
		}
		return $c_agencia;
	}

	// private
	function load($id)
	{
		$sql = "SELECT * FROM ".$this->db->prefix(AGENCIA_TABLA)." WHERE c_agencia=".$id."";
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
	}

	// public
	function delete()
	{
		$sql = sprintf("DELETE FROM %s WHERE c_agencia = %u", $this->db->prefix(AGENCIA_TABLA), $this->getVar("c_agencia"));
        	if ( !$this->db->query($sql) ) {
			return false;
		}
		return true;
	}

	// private, static
	function &getAll($criteria=array(), $asobject=true, $orderby="c_agencia DESC", $limit=0, $start=0)
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
			$sql = "SELECT c_agencia FROM ".$db->prefix(AGENCIA_TABLA)."$where_query ORDER BY $orderby";
			$result = $db->query($sql,intval($limit),intval($start));
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['c_agencia'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix(AGENCIA_TABLA)."".$where_query." ORDER BY $orderby";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new TecnoinmoAgencia($myrow);
			}
		}
		//echo $sql;
		return $ret;
	}
}
?>
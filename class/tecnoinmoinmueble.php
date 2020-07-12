<?php

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/modules/tecnoinmo/include/defines.inc.php";

class TecnoinmoInmueble extends XoopsObject
{
	var $db;

	//constructor
	function TecnoinmoInmueble($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("c_inmueble", XOBJ_DTYPE_INT, null, false);
		$this->initVar("c_t_inmueble", XOBJ_DTYPE_INT, null, false);
		$this->initVar("c_zona", XOBJ_DTYPE_INT, null, false);
		$this->initVar("c_operacion", XOBJ_DTYPE_INT, null, false);
		$this->initVar("c_referencia", XOBJ_DTYPE_TXTBOX, null, true, 100);
		$this->initVar("d_corta", XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar("d_larga", XOBJ_DTYPE_TXTAREA, null, true);
		$this->initVar("url_icono", XOBJ_DTYPE_TXTBOX, null, true, 100);
		$this->initVar("precio", XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("portada", XOBJ_DTYPE_INT, null, false);
		
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
		if ( empty($c_inmueble) ) {
			$c_inmueble = $this->db->genId($this->db->prefix(INMUEBLE_TABLA)."_inmueble_id_seq");
			$sql = "INSERT INTO ".$this->db->prefix(INMUEBLE_TABLA)." (c_inmueble, c_zona, c_t_inmueble, c_operacion, c_referencia, d_corta, d_larga, url_icono, precio, portada) VALUES ($c_inmueble, $c_zona, $c_t_inmueble, $c_operacion," .$this->db->quoteString($c_referencia)."," .$this->db->quoteString($d_corta).",  ".$this->db->quoteString($d_larga).",  ".$this->db->quoteString($url_icono).", ".$this->db->quoteString($precio). ", $portada)";
		} else {
			$sql ="UPDATE ".$this->db->prefix(INMUEBLE_TABLA)." SET c_t_inmueble=".$c_t_inmueble.", c_zona=".$c_zona.", c_operacion=".$c_operacion.", c_referencia=".$this->db->quoteString($c_referencia).", d_corta=".$this->db->quoteString($d_corta).", d_larga=".$this->db->quoteString($d_larga).", url_icono=".$this->db->quoteString($url_icono).",  precio=".$this->db->quoteString($precio).",  portada=".$portada." WHERE c_inmueble=$c_inmueble";
		}
		if ( !$result = $this->db->query($sql) ) {
			$this->setErrors("Could not store data in the database.");
			return false;
		}
		if ( empty($c_inmueble) ) {
			return $this->db->getInsertId();
		}
		return $c_inmueble;
	}

	// private
	function load($id)
	{
		$sql = "SELECT * FROM ".$this->db->prefix(INMUEBLE_TABLA)." WHERE c_inmueble=".$id."";
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
	}

	// public
	function delete()
	{
		//Borramos el icono
		@unlink(TECNOINMO_ICONOS_UPLOAD_PATH.$this->getVar("url_icono"));
		//Borramos todas las fotos
		$imagenes = new TecnoinmoImagen($this->getVar("c_inmueble"));
		$imagenes->borrarTodasFotos();
		$sql = sprintf("DELETE FROM %s WHERE c_inmueble = %u", $this->db->prefix(INMUEBLE_TABLA), $this->getVar("c_inmueble"));
        	if ( !$this->db->query($sql) ) {
			return false;
		}
		return true;
	}

	// private, static
	function &getAll($criteria=array(), $asobject=true, $orderby="c_inmueble DESC", $limit=0, $start=0)
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
			$sql = "SELECT c_inmueble FROM ".$db->prefix(INMUEBLE_TABLA)."$where_query ORDER BY $orderby";
			$result = $db->query($sql,intval($limit),intval($start));
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['c_inmueble'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix(INMUEBLE_TABLA)."".$where_query." ORDER BY $orderby";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new TecnoinmoInmueble($myrow);
			}
		}
		//echo $sql;
		return $ret;
	}
	
	//public
	// Devuelve la descripción de la zona
	function getDescZona()
	{
		$sql = "SELECT d_zona FROM ".$this->db->prefix(ZONA_TABLA)." WHERE c_zona=".$this->getVar("c_zona")."";
		$myrow = $this->db->fetchArray($this->db->query($sql));
		return $myrow["d_zona"];
	}
	
	//public
	// Devuelve la descripción de tipo de inmueble
	function getTipoInmueble()
	{
		switch ($this->getVar("c_t_inmueble")){
		case TECNOINMO_PISO:
			return _TECNOINMO_AM_PISO;
			break;
		case TECNOINMO_APARTAMENTO:
			return _TECNOINMO_AM_APARTAMENTO;
			break;
		case TECNOINMO_LOCAL:
			return _TECNOINMO_AM_LOCAL;
			break;
		case TECNOINMO_CASA:
			return _TECNOINMO_AM_CASA;
			break;
		case TECNOINMO_OFICINA:
			return _TECNOINMO_AM_OFICINA;
			break;
		case TECNOINMO_FINCA:
			return _TECNOINMO_AM_FINCA;
		break;
		}
	}
	
	//public
	//Devuelve la descripción de la operación
	function getOperacion()
	{
		switch ($this->getVar("c_operacion")){
		case TECNOINMO_VENTA:
			return _TECNOINMO_AM_VENTA;
			break;
		case TECNOINMO_ALQUILER:
			return _TECNOINMO_AM_ALQUILER;
			break;
		}
	}
	
	//Devuelve si hay algún inmueble con esa operación
	function hayOperacion($c_operacion)
	{	
		$sql = "SELECT COUNT(*) AS cuantos FROM ".$this->db->prefix(INMUEBLE_TABLA)." WHERE c_operacion=".$c_operacion;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		return ($myrow["cuantos"] > 0);
	}
	
	//Devuelve si hay algún inmueble de ese tipo
	function hayTipoInmueble($c_t_inmueble)
	{
		$sql = "SELECT COUNT(*) AS cuantos FROM ".$this->db->prefix(INMUEBLE_TABLA)." WHERE c_t_inmueble=".$c_t_inmueble;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		return ($myrow["cuantos"] > 0);
	}
	
	//Devuelve si hay algún inmueble de ese tipo y Operacion
	function hayTipoInmuebleOperacion($c_t_inmueble, $c_operacion)
	{
		$sql = "SELECT COUNT(*) AS cuantos FROM ".$this->db->prefix(INMUEBLE_TABLA)." WHERE c_t_inmueble=".$c_t_inmueble. " AND c_operacion = ".$c_operacion;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		return ($myrow["cuantos"] > 0);
	}
	
	//Devuelve si hay algún inmueble de ese tipo y Operacion
	function &getTOperacionArray()
	{
		return $operacion_array;
	}
}
?>
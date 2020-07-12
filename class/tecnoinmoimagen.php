<?php

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/modules/tecnoinmo/include/defines.inc.php";
include_once XOOPS_ROOT_PATH.'/class/uploader.php';

class TecnoinmoImagen extends XoopsObject
{
	var $db;
	
	//constructor
	function TecnoinmoImagen($id)
	{
		$this->db =& Database::getInstance();
		$this->c_inmueble = $id;
		
	}
	
	//Pública, Estatica
	function subirImagen($path, $file, $file_name)
	{
		$uploader = new XoopsMediaUploader($path, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), 500000);
		$uploader->setPrefix('timicon');
		$err = array();
		$ucount = count($file);
		if ($ucount != 0)
		for ($i = 0; $i < $ucount; $i++) {
			if ($uploader->fetchMedia($file[$i])) {
				if (!$uploader->upload()) {
					$err[] = $uploader->getErrors();
				} else {
					//$inmueble->setVar('url_icono', $uploader->getSavedFileName());
					$file_name = $uploader->getSavedFileName();
				}
			} else {
				$err[] = sprintf(_FAILFETCHIMG, $i);
			}
		}
		return $err;
	}
	
	// public
	function &getAll($orderby="c_foto DESC", $limit=0, $start=0)
	{
		$ret = array();
		$where_query = " WHERE c_inmueble = ".$this->c_inmueble;
		$sql = "SELECT * FROM ".$this->db->prefix(FOTO_TABLA)." WHERE c_inmueble = ".$this->c_inmueble." ORDER BY $orderby";
		$result = $this->db->query($sql,$limit,$start);
		while ( $myrow = $this->db->fetchArray($result) ) {
			$ret[$myrow["c_foto"]]=$myrow["url_foto"];
		}
		return $ret;
	}
	
	//Public
	function subirFoto($file, $file_name)
	{
		$this->subirImagen(TECNOINMO_FOTOS_UPLOAD_PATH, $file, &$file_name);
		$sql = "INSERT INTO ".$this->db->prefix(FOTO_TABLA)." (c_inmueble, url_foto) VALUES (".$this->c_inmueble.", ".$this->db->quoteString($file_name).")";
		if ( !$result = $this->db->query($sql) ) {
			$this->setErrors("Could not store data in the database.");
			return false;
		}
		
		return $result;
	}
	
	//public
	function borrarFoto($file_name)
	{
		@unlink(TECNOINMO_FOTOS_UPLOAD_PATH.$file_name);
		$sql = "DELETE FROM ".$this->db->prefix(FOTO_TABLA)." WHERE url_foto = ".$this->db->quoteString($file_name);
		if ( !$result = $this->db->queryF($sql) ) {
			$this->setErrors("Could not store data in the database.");
			return false;
		}
		return $result;
	}
	
	//public
	function borrarTodasFotos()
	{
		$array =& $this->getAll();
        	// Ahora eliminar cada item, pero dejar la matriz misma intacta:
		foreach ($array as $codigo => $nombre) {
   			$this->borrarFoto($nombre);
		}
	}
}
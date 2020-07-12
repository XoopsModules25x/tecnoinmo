<?php
include("../../mainfile.php");
include './class/tecnoinmoinmueble.php';
include './class/tecnoinmoimagen.php';
include './class/tecnoinmodatos.php';

//Comprobamos cual es la operación
$op = "portada";

if ( !empty($HTTP_POST_VARS['op']) ) {
	$op = $HTTP_POST_VARS['op'];
} elseif (!empty($HTTP_GET_VARS['op'])) {
	$op = $HTTP_GET_VARS['op'];
}

//Listado de todos los inmuebles de portada
if ($op == "portada")
{
	$xoopsOption['template_main'] = 'tecnoinmo_portada.html';
	include(XOOPS_ROOT_PATH."/header.php");
	$limit = (!empty($HTTP_GET_VARS['limit'])) ? intval($HTTP_GET_VARS['limit']) : 10;
	$start = (!empty($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
    	$xoopsTpl->assign('lang_portada', _TECNOINMO_DESTACADOS);
	
	//Pasamos los datos de la agencia
	$datos = new TecnoinmoDatos(TECNOINMO_C_AGENCIA);
	$xoopsTpl->assign('nombre_agencia', $datos->getVar("nombre"));
	$xoopsTpl->assign('direccion_agencia', $datos->getVar("direccion"));
	$xoopsTpl->assign('telefono_agencia', $datos->getVar("telefono"));
	$xoopsTpl->assign('fax_agencia', $datos->getVar("fax"));
	$xoopsTpl->assign('email_agencia', $datos->getVar("email"));
	
	$link_telefono = XOOPS_URL."/modules/tecnoinmo/imagenes/telef1.gif";
	$xoopsTpl->assign('link_telefono', $link_telefono);

	$criteria = array();
	$criteria[] = "portada = 1";
	$inmuebles_arr =& TecnoinmoInmueble::getAll($criteria, true, "c_inmueble DESC", $limit+1, $start);
	$inmuebles_count = count($inmuebles_arr);
	$max = ( $inmuebles_count > $limit ) ? $limit : $inmuebles_count;
	for ( $i = 0; $i < $max; $i++ ) {
		//Comprobamos si es par y si quedan mas
		$par = 0;
		if ($i % 2 == 0) 
			$par = true;
		$ultimo = 0;
		if ($i == $max-1)
			$ultimo = true;

		$xoopsTpl->append('par', $par);
		$xoopsTpl->append('ultimo', $ultimo);
		
		$inmuebles = array();
		$icono_inmo = $inmuebles_arr[$i]->getVar("url_icono");
		if ($icono_inmo == "")
			$icono_inmo = TECNOINMO_NO_DISPONIBLE;
		$url_icono = '<a href="index.php?op=ver&amp;c_inmueble='.$inmuebles_arr[$i]->getVar("c_inmueble").'"><img 
                  height=75 
                  src="'.TECNOINMO_ICONOS_SHOW_PATH.$icono_inmo.'" 
                  width=110 align=left border=0></a>';
		$inmuebles['url_icono']=$url_icono;
		$texto = $inmuebles_arr[$i]->getVar("d_corta").'<br><font color="red">'.$inmuebles_arr[$i]->getVar("precio").'</font><b> '. _TECNOINMO_REFERENCIA .  $inmuebles_arr[$i]->getVar("c_referencia").'</b>';
		
		$inmuebles['texto']=$texto;
		$xoopsTpl->append('inmuebles', $inmuebles);
		unset($inmuebles);
	}
	//Enlaces de anterior y siguiente
	$enlace1 = "";
	$texto_enlace1 = "";
	$enlace2 = "";
	$texto_enlace2 = "";
	if ( $start > 0 ) {
		$hayenlace1 = true;
		$prev_start = ($start - $limit > 0) ? $start - $limit : 0;
		$enlace1 = "index.php?op=portada&amp;start=".$prev_start."&amp;limit=".$limit;
		$texto_enlace1 = _TECNOINMO_PREV;
	}
	if ( $inmuebles_count > $limit ) {
		$enlace2="index.php?op=portada&amp;start=".($start+$limit)."&amp;limit=".$limit;
		$texto_enlace2=_TECNOINMO_NEXT;
	}
	$xoopsTpl->append('texto_enlace1', $texto_enlace1);
	$xoopsTpl->append('enlace1', $enlace1);
	$xoopsTpl->append('texto_enlace2', $texto_enlace2);
	$xoopsTpl->append('enlace2', $enlace2);
	
	include XOOPS_ROOT_PATH."/footer.php";
	return;
}

//Datos de un inmueble
if ($op == "ver")
{
	$xoopsOption['template_main'] = 'tecnoinmo_inmueble.html';
	include(XOOPS_ROOT_PATH."/header.php");
	$c_inmueble = $HTTP_GET_VARS['c_inmueble'];
	
	//Pasamos los datos de la agencia
	$datos = new TecnoinmoDatos(TECNOINMO_C_AGENCIA);
	$xoopsTpl->assign('nombre_agencia', $datos->getVar("nombre"));
	$xoopsTpl->assign('direccion_agencia', $datos->getVar("direccion"));
	$xoopsTpl->assign('telefono_agencia', $datos->getVar("telefono"));
	$xoopsTpl->assign('fax_agencia', $datos->getVar("fax"));
	$xoopsTpl->assign('email_agencia', $datos->getVar("email"));
	
	$link_telefono = XOOPS_URL."/modules/tecnoinmo/imagenes/telef1.gif";
	$xoopsTpl->assign('link_telefono', $link_telefono);

	$inmueble = new TecnoinmoInmueble($c_inmueble);
	$icono_inmo = $inmueble->getVar("url_icono");
	if ($icono_inmo == "")
		$icono_inmo = TECNOINMO_NO_DISPONIBLE;
	$url_icono = TECNOINMO_ICONOS_SHOW_PATH.$icono_inmo;
	$xoopsTpl->assign('url_icono', $url_icono);
	$xoopsTpl->assign('t_inmueble', $inmueble->getTipoInmueble());
	$xoopsTpl->assign('d_larga', $inmueble->getVar("d_larga"));
	$xoopsTpl->assign('precio', $inmueble->getVar("precio"));
	$xoopsTpl->assign('c_referencia', $inmueble->getVar("c_referencia"));
	$xoopsTpl->assign('zona', $inmueble->getDescZona());
	
	$xoopsTpl->assign('referencia_lang', _TECNOINMO_REFERENCIA);
	$xoopsTpl->assign('precio_lang', _TECNOINMO_PRECIO);
	//Generamos las fotos a mostrar
	$imagenes = new TecnoinmoImagen($c_inmueble);
	$imagenes_arr =& $imagenes->getAll();
	$cuantos = count($imagenes_arr);
	$count = 0;
	foreach ($imagenes_arr as $c_foto => $url_foto) {
		$par = false;
		$ultimo = false;
		if ($count % 2 == 0) 
			$par = true;
		if ($count == $cuantos-1)
			$ultimo = true;
		$count++;
		$xoopsTpl->append('par', $par);
		$xoopsTpl->append('ultimo', $ultimo);
		
		$fotos = array();
		$fotos['url_foto']=TECNOINMO_FOTOS_SHOW_PATH . $url_foto;
		$xoopsTpl->append('fotos', $fotos);
		unset($fotos);
	}
	
	include XOOPS_ROOT_PATH."/footer.php";
	return;
}

//Listado de inmuebles
if ($op == "lista")
{
	$xoopsOption['template_main'] = 'tecnoinmo_lista.html';
	
	include(XOOPS_ROOT_PATH."/header.php");
	$c_operacion = $HTTP_GET_VARS['c_operacion'];
	$c_t_inmueble = $HTTP_GET_VARS['c_t_inmueble'];
	//$c_t_inmueble =(!empty($HTTP_GET_VARS['c_t_inmueble'])) ? $HTTP_GET_VARS['c_t_inmueble'] : ""; 
	//$c_operacion =(!empty($HTTP_GET_VARS['c_operacion'])) ? $HTTP_GET_VARS['c_operacion'] : ""; 
	$limit = (!empty($HTTP_GET_VARS['limit'])) ? intval($HTTP_GET_VARS['limit']) : 20;
	$start = (!empty($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
	
	$inmueble = new TecnoinmoInmueble();
	
	$titulo = _TECNOINMO_LISTA;
	//Filtrado
	$criteria = array();
	if ($c_operacion != "")
		$criteria[] = "c_operacion = ". $c_operacion;
	if ($c_t_inmueble!="")
		$criteria[] = "c_t_inmueble = ". $c_t_inmueble;
	
	$xoopsTpl->assign('titulo', $titulo);
	
	$inmuebles_arr =& TecnoinmoInmueble::getAll($criteria, true, "c_zona ", $limit+1, $start);
	$inmuebles_count = count($inmuebles_arr);
	$max = ( $inmuebles_count > $limit ) ? $limit : $inmuebles_count;
	$zona_vieja = -1;
	for ( $i = 0; $i < $max; $i++ ) {
		//Comprobamos si es par y si quedan mas
		$par = 0;
		if ($i % 2 == 0) 
			$par = true;
		$xoopsTpl->append('par', $par);
		
		$inmuebles = array();
		$texto = $inmuebles_arr[$i]->getVar("d_corta").'<br><font color="red">'.$inmuebles_arr[$i]->getVar("precio").'</font>';
		$referencia = '<a href="index.php?op=ver&amp;c_inmueble='.$inmuebles_arr[$i]->getVar("c_inmueble").'">'. _TECNOINMO_REFERENCIA .  $inmuebles_arr[$i]->getVar("c_referencia").'</a>';
		$inmuebles['texto']=$texto;
		$inmuebles['referencia']=$referencia;
		//Comprobamos si hay que poner la zona
		$zona = $inmuebles_arr[$i]->getVar("c_zona");
		if ($zona != $zona_vieja)
		{
			$zona_vieja = $zona;
			$inmuebles['zona'] = $inmuebles_arr[$i]->getDescZona();
		}
		$xoopsTpl->append('inmuebles', $inmuebles);
		unset($inmuebles);
	}
	//Enlaces de anterior y siguiente
	$enlace1 = "";
	$texto_enlace1 = "";
	$enlace2 = "";
	$texto_enlace2 = "";
	if ( $start > 0 ) {
		$hayenlace1 = true;
		$prev_start = ($start - $limit > 0) ? $start - $limit : 0;
		$enlace1 = "index.php?op=lista&amp;start=".$prev_start."&amp;limit=".$limit."&amp;c_operacion=".$c_operacion."&amp;c_inmueble=".$c_inmueble;
		$texto_enlace1 = _TECNOINMO_PREV;
	}
	if ( $inmuebles_count > $limit ) {
		$enlace2="index.php?op=lista&amp;start=".($start+$limit)."&amp;limit=".$limit."&amp;c_operacion=".$c_operacion."&amp;c_inmueble=".$c_inmueble;
		$texto_enlace2=_TECNOINMO_NEXT;
	}
	$xoopsTpl->append('texto_enlace1', $texto_enlace1);
	$xoopsTpl->append('enlace1', $enlace1);
	$xoopsTpl->append('texto_enlace2', $texto_enlace2);
	$xoopsTpl->append('enlace2', $enlace2);
	include XOOPS_ROOT_PATH."/footer.php";
	return;
}
?>
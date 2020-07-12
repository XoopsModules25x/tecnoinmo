<?php

include '../../../include/cp_header.php'; //Include file, which checks for permissions and sets navigation
include XOOPS_ROOT_PATH.'/modules/tecnoinmo/class/tecnoinmoinmueble.php';
include XOOPS_ROOT_PATH.'/modules/tecnoinmo/class/tecnoinmozona.php';
include XOOPS_ROOT_PATH.'/modules/tecnoinmo/class/tecnoinmoimagen.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

$op = "list";

if (!empty($HTTP_GET_VARS['op'])) {
	$op = $HTTP_GET_VARS['op'];
}
if ( isset($HTTP_POST_VARS) ) {
	foreach ( $HTTP_POST_VARS as $k => $v ) {
		$$k = $v;
	}
}


if ( $op == "list" ) {
	$limit = (!empty($HTTP_GET_VARS['limit'])) ? $HTTP_GET_VARS['limit'] : 30;
	$start = (!empty($HTTP_GET_VARS['start'])) ? $HTTP_GET_VARS['start'] : 0;
	//$inmuebles_arr =& TecnoinmoInmueble::getAll(array(), true, null, $limit+1, $start);
	xoops_cp_header();
	$inmuebles_arr =& TecnoinmoInmueble::getAll(array(), true, "c_inmueble", $limit+1, $start);
	echo "<h4>"._TECNOINMO_AM_INMUEBLES."</h4>";
	echo "<h4 style='text-align:left;'>"._TECNOINMO_AM_INMUEBLES_LISTA."</h4>";
	$inmuebles_count = count($inmuebles_arr);
	
	if ( is_array($inmuebles_arr) && $inmuebles_count > 0) {
		echo "<form action='inmueble.php' method='post'><table border='0' cellpadding='7' cellspacing='0' width='100%'><tr><td class='bg2'>
		<table width='100%' border='0' cellpadding='2' cellspacing='1'>
		<tr class='bg3'><td>"._TECNOINMO_AM_INMUEBLE_REFERENCIA."</td><td>"._TECNOINMO_AM_INMUEBLE_DESCRIPCION."</td><td>"._TECNOINMO_AM_INMUEBLE_TIPO."</td><td>"._TECNOINMO_AM_INMUEBLE_ZONA."</td><td>"._TECNOINMO_AM_INMUEBLE_OPERACION."</td><td>&nbsp;</td></tr>";
		$max = ( $inmuebles_count > $limit ) ? $limit : $inmuebles_count;
		for ( $i = 0; $i < $max; $i++ ) {
			echo "<tr class='bg1'><td>".$inmuebles_arr[$i]->getVar("c_referencia")."</td><td align='left'>".$inmuebles_arr[$i]->getVar("d_corta")."</td><td align='left'>".$inmuebles_arr[$i]->getTipoInmueble()."</td><td align='left'>".$inmuebles_arr[$i]->getDescZona()."</td><td align='left'>".$inmuebles_arr[$i]->getOperacion()."</td><td align='right'><a href='inmueble.php?op=edit&amp;c_inmueble=".$inmuebles_arr[$i]->getVar("c_inmueble")."'>"._EDIT."</a><br /><a href='inmueble.php?op=foto&amp;c_inmueble=".$inmuebles_arr[$i]->getVar("c_inmueble")."'>"._TECNOINMO_AM_FOTO."</a><br /><a href='inmueble.php?op=delete&amp;c_inmueble=".$inmuebles_arr[$i]->getVar("c_inmueble")."'>"._DELETE."</a><br />";
		}
		echo "<tr align='right' class='bg3'><td colspan='7'><input type='button' name='button' onclick=\"location='inmueble.php?op=add'\" value='"._TECNOINMO_AM_INMUEBLES_NUEVO."' /> </td></tr></table></td></tr></table></form>";
		echo "<table width='100%'><tr><td align='left'>";
		if ( $start > 0 ) {
			$prev_start = ($start - $limit > 0) ? $start - $limit : 0;
			echo "<a href='inmueble.php?start=".$prev_start."&amp;limit=".$limit."'>"._PL_PREV."</a>";
		} else {
			echo "&nbsp;";
		}
		echo "</td><td align='right'>";
		if ( $inmuebles_count > $limit ) {
			echo "<a href='inmueble.php?start=".($start+$limit)."&amp;limit=".$limit."'>"._PL_NEXT."</a>";
		}
		echo "</td></tr></table>";
	}
	else{ //ningún inmueble
	 echo "<table width='100%' border='0' cellpadding='2' cellspacing='1'><tr align='right' class='bg3'><td colspan='7'><input type='button' name='button' onclick=\"location='inmueble.php?op=add'\" value='"._TECNOINMO_AM_INMUEBLES_NUEVO."' /> </td></tr></table>";
	 }
	
	xoops_cp_footer();
	exit();
}


//Añadimos un nuevo inmueble
if ( $op == "add" ) {
	$inmueble_form = new XoopsThemeForm(_TECNOINMO_AM_INMUEBLE_NUEVO_INMUEBLE, "inmueble_form", "inmueble.php");
	$inmueble_form->setExtra('enctype="multipart/form-data"');
		
	//Tipo de inmueble
	$tipo_inmueble_select = new XoopsFormSelect(_TECNOINMO_AM_INMUEBLE_TIPO_INMUBLE, "inmueble_select");
	$tipo_inmueble_select->addOptionArray($t_inmueble_array);
	$inmueble_form->addElement($tipo_inmueble_select);
	
	//Zona
	$zona_select = new XoopsFormSelect(_TECNOINMO_AM_INMUEBLE_ZONA, "zona_select");
	$zona_select->addOptionArray(TecnoinmoZona::getAllZonesArray());
	$inmueble_form->addElement($zona_select);
	
	//Operación
	$operacion_select = new XoopsFormSelect(_TECNOINMO_AM_INMUEBLE_OPERACION, "operacion_select");
	$operacion_select->addOptionArray($operacion_array);
	$inmueble_form->addElement($operacion_select);
	
	//Código Referencia
	$referencia_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_COD_REFERENCIA, "c_referencia", 50, 100);
	$inmueble_form->addElement($referencia_text);

	//Descripción corta
	$d_corta_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_D_CORTA, "d_corta", 50, 255);
	$inmueble_form->addElement($d_corta_text);
	
	//Descripción larga
	$d_larga_textarea = new XoopsFormTextArea(_TECNOINMO_AM_INMUEBLE_D_LARGA, "d_larga");
	$inmueble_form->addElement($d_larga_textarea);
	
	//URL Icono
	//$nombre_icono_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_URL_ICONO, "nombre_icono", 50, 100);
	//$inmueble_form->addElement($nombre_icono_text);
	$inmueble_form->addElement(new XoopsFormFile(_TECNOINMO_AM_INMUEBLE_URL_ICONO, 'icono_file', 500000));
	
	//Precio
	$precio_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_PRECIO, "precio", 50, 100);
	$inmueble_form->addElement($precio_text);
	
	//Es noticia de portada
	$disp_yn = new XoopsFormRadioYN(_TECNOINMO_AM_INMUEBLE_PORTADA, "portada", 1);
	$inmueble_form->addElement($disp_yn);
	
	$submit_button = new XoopsFormButton("", "inmueble_submit", _SUBMIT, "submit");
	$inmueble_form->addElement($submit_button);
	$op_hidden = new XoopsFormHidden("op", "save");
	$inmueble_form->addElement($op_hidden);
	
	xoops_cp_header();	
	
	echo "<h4>"._TECNOINMO_AM_INMUEBLES."</h4>";
	$inmueble_form->display();
	xoops_cp_footer();
	exit();
}


//Guardar el inmueble
if ( $op == "save" ) {
	//Creamos el objeto
	$inmueble = new TecnoinmoInmueble();
	//Guardamos el valor del formulario
	//Tipo de inmueble
	$inmueble->setVar("c_t_inmueble", $inmueble_select);
	//Zona
	$inmueble->setVar("c_zona", $zona_select);
	//Operación
	$inmueble->setVar("c_operacion", $operacion_select);
	//Código Referencia
	$inmueble->setVar("c_referencia", $c_referencia);
	//Descripción corta
	$inmueble->setVar("d_corta", $d_corta);
	//Descripción larga
	$inmueble->setVar("d_larga", $d_larga);
	//URL Icono
	//Comprobamos que tenemos Icono
	$field = $_POST["xoops_upload_file"][0] ;
	if( !empty( $field ) || $field != "" ) {
		$err  = TecnoInmoImagen::subirImagen(TECNOINMO_ICONOS_UPLOAD_PATH, $HTTP_POST_VARS['xoops_upload_file'],&$nombre_fichero);
		if (count($err) == 0){
				$inmueble->setVar('url_icono', $nombre_fichero);
		}
	}
	//Precio
	$inmueble->setVar("precio", $precio);
	//Es noticia de portada
	$inmueble->setVar("portada", $portada);
	
	//Guardamos los datos
	$nuevo_inmueble_id = $inmueble->store();
	
	//Comprobamos la operación
	if ( empty($nuevo_inmueble_id) ) {
		echo $inmueble->getHtmlErrors();
		exit();
	}
	redirect_header("inmueble.php",1,_TECNOINMO_AM_INMUEBLE_BBDD_ACTUALIZADA);
	exit();
}


if ( $op == "edit" ) {

	$inmueble = new TecnoinmoInmueble($HTTP_GET_VARS['c_inmueble']);
	$inmueble_form = new XoopsThemeForm(_TECNOINMO_AM_INMUEBLE_EDITAR, "inmueble_form", "inmueble.php");
	$inmueble_form->setExtra('enctype="multipart/form-data"');
	
	//Tipo de inmueble
	$tipo_inmueble_select = new XoopsFormSelect(_TECNOINMO_AM_INMUEBLE_TIPO_INMUBLE, "inmueble_select");
	$tipo_inmueble_select->addOptionArray($t_inmueble_array);
	$tipo_inmueble_select->SetValue($inmueble->getVar("c_t_inmueble"));
	$inmueble_form->addElement($tipo_inmueble_select);
	
	//Zona
	$zona_select = new XoopsFormSelect(_TECNOINMO_AM_INMUEBLE_ZONA, "zona_select");
	$zona_select->addOptionArray(TecnoinmoZona::getAllZonesArray());
	$zona_select->SetValue($inmueble->getVar("c_zona"));
	$inmueble_form->addElement($zona_select);
	
	//Operación
	$operacion_select = new XoopsFormSelect(_TECNOINMO_AM_INMUEBLE_OPERACION, "operacion_select");
	$operacion_select->addOptionArray($operacion_array);
	$operacion_select->SetValue($inmueble->getVar("c_operacion"));
	$inmueble_form->addElement($operacion_select);
	
	//Código Referencia
	$referencia_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_COD_REFERENCIA, "c_referencia", 50, 100, $inmueble->getVar("c_referencia"));
	$inmueble_form->addElement($referencia_text);

	//Descripción corta
	$d_corta_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_D_CORTA, "d_corta", 50, 255, $inmueble->getVar("d_corta"));
	$inmueble_form->addElement($d_corta_text);
	
	//Descripción larga
	$d_larga_textarea = new XoopsFormTextArea(_TECNOINMO_AM_INMUEBLE_D_LARGA, "d_larga");
	$d_larga_textarea->SetValue($inmueble->getVar("d_larga"));
	$inmueble_form->addElement($d_larga_textarea);
	
	//URL Icono
	$URLIcono_label = new XoopsFormLabel(_TECNOINMO_AM_INMUEBLE_URL_ICONO,  $inmueble->getVar("url_icono"));
	$inmueble_form->addElement($URLIcono_label);
	$op_hidden = new XoopsFormHidden("url_icono", $URLIcono_label);
	$inmueble_form->addElement($op_hidden);
	$inmueble_form->addElement(new XoopsFormFile(_TECNOINMO_AM_INMUEBLE_NUEVO_ICONO, 'icono_file', 500000));
	
	//Precio
	$precio_text = new XoopsFormText(_TECNOINMO_AM_INMUEBLE_PRECIO, "precio", 50, 100, $inmueble->getVar("precio"));
	$inmueble_form->addElement($precio_text);
	
	//Es noticia de portada
	$disp_yn = new XoopsFormRadioYN(_TECNOINMO_AM_INMUEBLE_PORTADA, "portada", $inmueble->getVar("portada"));
	$inmueble_form->addElement($disp_yn);
	
	
	$op_hidden = new XoopsFormHidden("op", "update");
	$inmueble_form->addElement($op_hidden);
	$c_inmueble_hidden = new XoopsFormHidden("c_inmueble", $inmueble->getVar("c_inmueble"));
	$inmueble_form->addElement($c_inmueble_hidden);
	$submit_button = new XoopsFormButton("", "inmueble_submit", _SUBMIT, "submit");
	$inmueble_form->addElement($submit_button);

	xoops_cp_header();
	echo "<h4>"._TECNOINMO_AM_INMUEBLES."</h4>";	
	$inmueble_form->display();
	xoops_cp_footer();
	exit();
	
}

if ( $op == "update" ) {
	//Creamos el objeto
	$inmueble = new TecnoinmoInmueble($c_inmueble);
	//Guardamos el valor del formulario
	//Tipo de inmueble
	$inmueble->setVar("c_t_inmueble", $inmueble_select);
	//Zona
	$inmueble->setVar("c_zona", $zona_select);
	//Operación
	$inmueble->setVar("c_operacion", $operacion_select);
	//Código Referencia
	$inmueble->setVar("c_referencia", $c_referencia);
	//Descripción corta
	$inmueble->setVar("d_corta", $d_corta);
	//Descripción larga
	$inmueble->setVar("d_larga", $d_larga);
	//URL Icono
	//Comprobamos que tenemos Icono
	$field = $_POST["xoops_upload_file"][0] ;
	if( !empty( $field ) || $field != "" ) {
		$err  = TecnoInmoImagen::subirImagen(TECNOINMO_ICONOS_UPLOAD_PATH, $HTTP_POST_VARS['xoops_upload_file'],&$nombre_fichero);
		if (count($err) == 0){
			//Eliminamos el viejo icono
			@unlink(TECNOINMO_ICONOS_UPLOAD_PATH.$inmueble->getVar("url_icono"));
			//Guardamos el nuevo nombre
			$inmueble->setVar('url_icono', $nombre_fichero);
		}
	}
	else
		$inmueble->setVar("url_icono", $url_icono);
	//Precio
	$inmueble->setVar("precio", $precio);
	//Es noticia de portada
	$inmueble->setVar("portada", $portada);
	//Guardamos los cambios
	$inmueble->store();
	redirect_header("inmueble.php",1,_TECNOINMO_AM_INMUEBLE_BBDD_ACTUALIZADA);
	exit();
}


if ( $op == "delete" ) {
	xoops_cp_header();
	echo "<h4>"._TECNOINMO_AM_INMUEBLES."</h4>";
	$inmueble = new TecnoinmoInmueble($HTTP_GET_VARS['c_inmueble']);
	xoops_confirm(array('op' => 'delete_ok', 'c_inmueble' => $inmueble->getVar('c_inmueble')), 'inmueble.php', sprintf(_TECNOINMO_AM_INMUEBLE_CONFIRMAR_BORRAR,$inmueble->getVar("c_referencia")));
	xoops_cp_footer();
	exit();
}

if ( $op == "delete_ok" ) {
	$inmueble = new TecnoinmoInmueble($c_inmueble);
	if ( $inmueble->delete() ) {
		redirect_header("inmueble.php",1,_TECNOINMO_AM_INMUEBLE_BBDD_ACTUALIZADA);
	}
	exit();
}

if ($op == "foto") {
	$foto_form = new XoopsThemeForm(_TECNOINMO_AM_FOTO_NUEVA_FOTO, "foto_form", "inmueble.php");
	$foto_form->setExtra('enctype="multipart/form-data"');
	
	//URL Foto
	$foto_form->addElement(new XoopsFormFile(_TECNOINMO_AM_INMUEBLE_URL_FOTO, 'foto_file', 500000));
	
	$op_hidden = new XoopsFormHidden("op", "subir_foto");
	$foto_form->addElement($op_hidden);
	$c_inmueble_hidden = new XoopsFormHidden("c_inmueble", $HTTP_GET_VARS['c_inmueble']);
	$foto_form->addElement($c_inmueble_hidden);
	$submit_button = new XoopsFormButton("", "inmueble_submit", _SUBMIT, "submit");
	$foto_form->addElement($submit_button);

	xoops_cp_header();
	echo "<h4 style='text-align:left'>"._TECNOINMO_AM_FOTOS."</h4>";
	$foto_form->display();
	
	//OpenTable();
	echo"<form action=inmueble.php' method='post' name='fotosadmin' id='fotosadmin'>
	<table class='outer' width='100%' cellpadding='2' cellspacing='1'>
	<tr align='center'><th>"._TECNOINMO_AM_FOTOS_LISTADO."</th><th>"._TECNOINMO_AM_FOTOS_OPCION."</th></tr>";
	//Leemos todas las fotos
	$c_inmueble = $HTTP_GET_VARS['c_inmueble'];
	$imagenes = new TecnoinmoImagen($c_inmueble);
	$imagenes_arr =& $imagenes->getAll();
	$count = 0;
	foreach ($imagenes_arr as $c_foto => $url_foto) {
		if ($count % 2 == 0) {
			$class = 'even';
		} else {
			$class = 'odd';
		}
		echo '<tr class="'.$class.'" align="center" valign="middle">
				<td align="left" valign="bottom"><img src="'.TECNOINMO_FOTOS_SHOW_PATH.$url_foto.'" border="0" /></td><td align="center"><a href="inmueble.php?op=borrar_foto&amp;c_inmueble='.$c_inmueble.'&amp;url_foto='.$url_foto.'">'._DELETE.'</a></td></tr>';
		$count++;
	}
	
	echo"</table>	</form>";
	xoops_cp_footer();
	exit();
}

if ($op == "subir_foto") {
	//Comprobamos que tenemos Icono
	$field = $_POST["xoops_upload_file"][0] ;
	if( !empty( $field ) || $field != "" ) {
		$imagenes = new TecnoinmoImagen($HTTP_POST_VARS['c_inmueble']);
		$err  = $imagenes->subirFoto($HTTP_POST_VARS['xoops_upload_file'],&$nombre_fichero);
	}
	redirect_header("inmueble.php",1,_TECNOINMO_AM_INMUEBLE_BBDD_ACTUALIZADA);
}

if ($op == "borrar_foto") {
	$imagenes = new TecnoinmoImagen($HTTP_GET_VARS['c_inmueble']);
	$imagenes->borrarFoto($HTTP_GET_VARS['url_foto']);
	redirect_header("inmueble.php",1,_TECNOINMO_AM_INMUEBLE_BBDD_ACTUALIZADA);
}
?>
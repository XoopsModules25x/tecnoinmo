<?php

include '../../../include/cp_header.php'; //Include file, which checks for permissions and sets navigation
include XOOPS_ROOT_PATH.'/modules/tecnoinmo/class/tecnoinmozona.php';
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
	//$zonas_arr =& TecnoinmoZona::getAll(array(), true, null, $limit+1, $start);
	xoops_cp_header();
	$zonas_arr =& TecnoinmoZona::getAll(array(), true, "c_zona", $limit+1, $start);
	echo "<h4>"._TECNOINMO_AM_ZONAS."</h4>";
	echo "<h4 style='text-align:left;'>"._TECNOINMO_AM_ZONAS_LISTA."</h4>";
	$zonas_count = count($zonas_arr);
	
	if ( is_array($zonas_arr) && $zonas_count > 0) {
		echo "<form action='zona.php' method='post'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
		<table width='100%' border='0' cellpadding='2' cellspacing='1'>
		<tr class='bg3'><td>"._TECNOINMO_AM_ZONAS_CODIGO."</td><td>"._TECNOINMO_AM_ZONAS_DESCRIPCION."</td><td>&nbsp;</td></tr>";
		$max = ( $zonas_count > $limit ) ? $limit : $zonas_count;
		for ( $i = 0; $i < $max; $i++ ) {
			echo "<tr class='bg1'><td>".$zonas_arr[$i]->getVar("c_zona")."</td><td align='left'>".$zonas_arr[$i]->getVar("d_zona")."</td><td align='right'><a href='zona.php?op=edit&amp;c_zona=".$zonas_arr[$i]->getVar("c_zona")."'>"._EDIT."</a><br /><a href='zona.php?op=delete&amp;c_zona=".$zonas_arr[$i]->getVar("c_zona")."'>"._DELETE."</a><br />";
		}
		echo "<tr align='right' class='bg3'><td colspan='7'><input type='button' name='button' onclick=\"location='zona.php?op=add'\" value='"._TECNOINMO_AM_ZONAS_NUEVA."' /> </td></tr></table></td></tr></table></form>";
		echo "<table width='100%'><tr><td align='left'>";
		if ( $start > 0 ) {
			$prev_start = ($start - $limit > 0) ? $start - $limit : 0;
			echo "<a href='zona.php?start=".$prev_start."&amp;limit=".$limit."'>"._PL_PREV."</a>";
		} else {
			echo "&nbsp;";
		}
		echo "</td><td align='right'>";
		if ( $zonas_count > $limit ) {
			echo "<a href='zona.php?start=".($start+$limit)."&amp;limit=".$limit."'>"._PL_NEXT."</a>";
		}
		echo "</td></tr></table>";
	}
	else{ //ninguna zona
	 echo "<table width='100%' border='0' cellpadding='2' cellspacing='1'><tr align='right' class='bg3'><td colspan='7'><input type='button' name='button' onclick=\"location='zona.php?op=add'\" value='"._TECNOINMO_AM_ZONAS_NUEVA."' /> </td></tr></table>";
	 }
	
	xoops_cp_footer();
	exit();
}

//Añadimos una nueva zona
if ( $op == "add" ) {
	$zona_form = new XoopsThemeForm(_TECNOINMO_AM_ZONAS_NUEVA_ZONA, "zona_form", "zona.php");
	$descripcion_text = new XoopsFormText(_TECNOINMO_AM_ZONAS_DESCRIPCION, "d_zona", 50, 255);
	$zona_form->addElement($descripcion_text);
	$submit_button = new XoopsFormButton("", "zona_submit", _SUBMIT, "submit");
	$zona_form->addElement($submit_button);
	$op_hidden = new XoopsFormHidden("op", "save");
	$zona_form->addElement($op_hidden);
	xoops_cp_header();
	
	echo "<h4>"._TECNOINMO_AM_ZONAS."</h4>";
	$zona_form->display();
	xoops_cp_footer();
	exit();
}

//Guardar la zona
if ( $op == "save" ) {
	$zona = new TecnoinmoZona();
	$zona->setVar("d_zona", $d_zona);
	$nueva_zona_id = $zona->store();
	if ( empty($nueva_zona_id) ) {
		echo $zona->getHtmlErrors();
		exit();
	}
	redirect_header("zona.php",1,_TECNOINMO_AM_ZONAS_BBDD_ACTUALIZADA);
	exit();
}

if ( $op == "edit" ) {

	$zona = new TecnoinmoZona($HTTP_GET_VARS['c_zona']);
	$zona_form = new XoopsThemeForm(_TECNOINMO_AM_ZONAS_EDITAR, "zona_form", "zona.php");
	$descripcion_text = new XoopsFormText(_TECNOINMO_AM_ZONAS_DESCRIPCION, "d_zona",
	50,255, $zona->getVar("d_zona"));
	$zona_form->addElement($descripcion_text);
	$op_hidden = new XoopsFormHidden("op", "update");
	$zona_form->addElement($op_hidden);
	$c_zona_hidden = new XoopsFormHidden("c_zona", $zona->getVar("c_zona"));
	$zona_form->addElement($c_zona_hidden);
	$submit_button = new XoopsFormButton("", "zona_submit", _SUBMIT, "submit");
	$zona_form->addElement($submit_button);

	xoops_cp_header();
	echo "<h4>"._TECNOINMO_AM_ZONAS."</h4>";	
	$zona_form->display();
	xoops_cp_footer();
	exit();
	
}

if ( $op == "update" ) {
	$zona = new TecnoinmoZona($c_zona);
	$zona->setVar("d_zona", $d_zona);
	$zona->store();
	redirect_header("zona.php",1,_TECNOINMO_AM_ZONAS_BBDD_ACTUALIZADA);
	exit();
}

if ( $op == "delete" ) {
	xoops_cp_header();
	echo "<h4>"._TECNOINMO_AM_ZONAS."</h4>";
	$zona = new TecnoinmoZona($HTTP_GET_VARS['c_zona']);
	xoops_confirm(array('op' => 'delete_ok', 'c_zona' => $zona->getVar('c_zona')), 'zona.php', sprintf(_TECNOINMO_AM_ZONAS_CONFIRMAR_BORRAR,$zona->getVar("d_zona")));
	xoops_cp_footer();
	exit();
}

if ( $op == "delete_ok" ) {
	$zona = new TecnoinmoZona($c_zona);
	if ( $zona->delete() ) {
		redirect_header("zona.php",1,_TECNOINMO_AM_ZONAS_BBDD_ACTUALIZADA);
	}
	exit();
}
?>
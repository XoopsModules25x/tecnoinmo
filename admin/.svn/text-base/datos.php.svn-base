<?php

include '../../../include/cp_header.php'; //Include file, which checks for permissions and sets navigation
include XOOPS_ROOT_PATH.'/modules/tecnoinmo/class/tecnoinmodatos.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

$op = "edit";

if (!empty($HTTP_GET_VARS['op'])) {
	$op = $HTTP_GET_VARS['op'];
}

if (!empty($HTTP_GET_VARS['c_agencia'])) {
	$c_agencia = $HTTP_GET_VARS['c_agencia'];
}

if ( isset($HTTP_POST_VARS) ) {
	foreach ( $HTTP_POST_VARS as $k => $v ) {
		$$k = $v;
	}
}

if ( $op == "edit" ) {
	
	//Siempre vamos a utiilzar el mismo código de agencia, puesto que sólo hay una
	$c_agencia = TECNOINMO_C_AGENCIA;
	$agencia = new TecnoinmoDatos($c_agencia);
	$agencia_form = new XoopsThemeForm(_TECNOINMO_AM_AGENCIA_EDITAR, "agencia_form", "datos.php");
		
	//Nombre corta
	$nombre_text = new XoopsFormText(_TECNOINMO_AM_AGENCIA_NOMBRE, "nombre", 50, 255, $agencia->getVar("nombre"));
	$agencia_form->addElement($nombre_text);
	
	//Dirección
	$direccion_text = new XoopsFormText(_TECNOINMO_AM_AGENCIA_DIRECCION, "direccion", 50, 255, $agencia->getVar("direccion"));
	$agencia_form->addElement($direccion_text);
	
	//Teléfono
	$telefono_text = new XoopsFormText(_TECNOINMO_AM_AGENCIA_TELEFONO, "telefono", 50, 100, $agencia->getVar("telefono"));
	$agencia_form->addElement($telefono_text);
	
	//Fax
	$fax_text = new XoopsFormText(_TECNOINMO_AM_AGENCIA_FAX, "fax", 50, 100, $agencia->getVar("fax"));
	$agencia_form->addElement($fax_text);
	
	//email
	$email_text = new XoopsFormText(_TECNOINMO_AM_AGENCIA_EMAIL, "email", 50, 100, $agencia->getVar("email"));
	$agencia_form->addElement($email_text);
	
	$op_hidden = new XoopsFormHidden("op", "update");
	$agencia_form->addElement($op_hidden);
	$c_agencia_hidden = new XoopsFormHidden("c_agencia", $c_agencia);
	$agencia_form->addElement($c_agencia_hidden);
	$submit_button = new XoopsFormButton("", "agencia_submit", _SUBMIT, "submit");
	$agencia_form->addElement($submit_button);

	xoops_cp_header();
	echo "<h4>"._TECNOINMO_AM_DATOS."</h4>";	
	$agencia_form->display();
	xoops_cp_footer();
	exit();
	
}

if ( $op == "update" ) {
	//Creamos el objeto
	$agencia = new TecnoinmoDatos($c_agencia);
	//Guardamos el valor del formulario
	$agencia->setVar("c_agencia", $c_agencia);
	//Nombre
	$agencia->setVar("nombre", $nombre);
	//Direccion
	$agencia->setVar("direccion", $direccion);
	//Telefono
	$agencia->setVar("telefono", $telefono);
	//Fax
	$agencia->setVar("fax", $fax);
	//Email
	$agencia->setVar("email", $email);
	//Guardamos los cambios
	$agencia->store();
	redirect_header("datos.php",1,_TECNOINMO_AM_AGENCIA_BBDD_ACTUALIZADA);
	exit();
}
?>
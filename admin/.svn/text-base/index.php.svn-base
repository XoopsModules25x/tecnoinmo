<?php
include("../../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/class/xoopsmodule.php");
include(XOOPS_ROOT_PATH."/include/cp_functions.php");

if ( $xoopsUser ) 
{
	$xoopsModule = XoopsModule::getByDirname("tecnoinmo");
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) 
	{ 
		redirect_header(XOOPS_URL."/",3,_NOPERM);
		exit();
	}
} else 
{
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
}

if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) 
{
	include("../language/".$xoopsConfig['language']."/admin.php");
} else 
{
	include("../language/spanish/admin.php");
}

global $xoopsModule;


xoops_cp_header();
OpenTable();

echo "<a href='inmueble.php'>"._TECNOINMO_INMUEBLE."</a><br />";
echo "<a href='zona.php'>"._TECNOINMO_ZONA."</a><br />";
echo "<a href='datos.php'>"._TECNOINMO_AGENCIA."</a><br />";

CloseTable();
xoops_cp_footer();

?>
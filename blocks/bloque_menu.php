<?php
include_once XOOPS_ROOT_PATH.'/modules/tecnoinmo/class/tecnoinmoinmueble.php';
include_once XOOPS_ROOT_PATH.'/modules/tecnoinmo/include/defines.inc.php';
include_once XOOPS_ROOT_PATH.'/modules/xoopspoll/language/'.$xoopsConfig['language'].'/main.php';

function b_tecnoinmo_show()
{
	//Para cada tipo de operación comprobamos si hay tipo de inmueble y creamos el enlace
	$block = array();
	$inmueble = new TecnoinmoInmueble();
	//$operaciones_array = &$inmueble->getTOperacionArray();
	$operaciones_array = array( TECNOINMO_VENTA => _TECNOINMO_AM_VENTA, 
	TECNOINMO_ALQUILER => _TECNOINMO_AM_ALQUILER
	);
	
	#Array de tipos de inmuebles con los defines de lenguaje????
	$t_inmuebles_array = array( TECNOINMO_PISO => _TECNOINMO_AM_PISO, 
	TECNOINMO_APARTAMENTO => _TECNOINMO_AM_APARTAMENTO, 
	TECNOINMO_LOCAL => _TECNOINMO_AM_LOCAL, 
	TECNOINMO_CASA => _TECNOINMO_AM_CASA, 
	TECNOINMO_OFICINA => _TECNOINMO_AM_OFICINA,
	TECNOINMO_FINCA => _TECNOINMO_AM_FINCA
	);
	
	//Creamos el principal con la portada
	$enlaces = array();
	$enlace = XOOPS_URL."/modules/tecnoinmo/index.php";
	$tipo_menu = 1;
	$enlaces['enlace'] = $enlace;
	$enlaces['tipo_menu'] = $tipo_menu;
	$enlaces['texto'] = _TECNOINMO_BLOCK_PORTADA;
	$block['enlaces'][] =&$enlaces;
	unset($enlaces);

	foreach ($operaciones_array as $c_operacion  => $valor) {
   		if ($inmueble->hayOperacion($c_operacion))
		{
			//Creamos el enlace a la operación
			$enlaces = array();
			$enlace = XOOPS_URL."/modules/tecnoinmo/index.php?op=lista&amp;c_operacion=".$c_operacion;
			$tipo_menu = 1;
			$enlaces['enlace'] = $enlace;
			$enlaces['tipo_menu'] = $tipo_menu;
			$enlaces['texto'] = $operaciones_array[$c_operacion];
			$block['enlaces'][] =&$enlaces;
			unset($enlaces);
			
			//Creamos los subenlaces a los tipos de inmueble de esa operación
			foreach ($t_inmuebles_array as $c_t_inmueble => $t_valor) {
				if ($inmueble->hayTipoInmuebleOperacion($c_t_inmueble, $c_operacion))
				{
					$enlaces = array();
					$enlace = XOOPS_URL."/modules/tecnoinmo/index.php?op=lista&amp;c_operacion=".$c_operacion."&c_t_inmueble=".$c_t_inmueble;
					$tipo_menu = 2;
					$enlaces['enlace'] = $enlace;
					$enlaces['tipo_menu'] = $tipo_menu;
					$enlaces['texto'] = $t_inmuebles_array[$c_t_inmueble];
					$block['enlaces'][] =&$enlaces;
					unset($enlaces);
				}
			}
		}
	}
	return $block;
}
?>
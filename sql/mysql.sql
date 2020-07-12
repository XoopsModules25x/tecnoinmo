CREATE TABLE `tecnoinmo_zona` (
  `c_zona` int(11) NOT NULL auto_increment,
  `d_zona` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`c_zona`)
) TYPE=MyISAM; 

CREATE TABLE `tecnoinmo_inmueble` (
  `c_inmueble` int(11) NOT NULL auto_increment,
  `c_t_inmueble` int(11) NOT NULL default '0',  
  `c_zona` int(11) NOT NULL default '0',
  `c_operacion` int(11) NOT NULL default '0',
  `c_referencia` varchar(100) NOT NULL default '',
  `d_corta` varchar(255) NOT NULL default '',
  `d_larga` text,
  `url_icono` varchar(100),
  `precio` varchar(100) NOT NULL default '',
  `portada` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`c_inmueble`)
) TYPE=MyISAM; 

CREATE TABLE `tecnoinmo_foto` (
 `c_foto` int(11) NOT NULL auto_increment,
  `c_inmueble` int(11) NOT NULL default '0',
  `url_foto` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`c_foto`)
) TYPE=MyISAM; 

CREATE TABLE `tecnoinmo_agencia` (
  `c_agencia` int(11) NOT NULL default '0',
  `nombre` varchar(250) default '',
  `direccion` varchar(250) default '',
  `telefono` varchar(100) default '',
  `fax` varchar(100) default '',
  `email` varchar(100) default '',
  PRIMARY KEY  (`c_agencia`)
) TYPE=MyISAM;

INSERT INTO `tecnoinmo_agencia`
 (`c_agencia`, `nombre`, `direccion`, `telefono`, `fax`, `email`)
VALUES (1, NULL, NULL, NULL, NULL, NULL)
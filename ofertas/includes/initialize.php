<?php

/*Definimos las constantes que nos serviran para tener acceso directo a las carpetas de nuestra página*/
defined("SD") ? NULL : define("SD",DIRECTORY_SEPARATOR); /*DIRECTORY_SEPARATOR nos devuelve el simbolo segun el sistema operativo ya sea Windows(\) - Linux (/)*/

defined("RAIZ_DIR") ? NULL : define("RAIZ_DIR","D:".SD."wamp".SD."www".SD."ofertas");/*Marcamos la ruta directa a la carpeta raiz*/

//defined("RAIZ_DIR") ? NULL : define("RAIZ_DIR","D:".SD."hshome".SD."c298229".SD."ofertaschapinas.com");

defined("LIB_DIR") ? NULL : define("LIB_DIR",RAIZ_DIR.SD."includes");/*Marcamos la ruta directa al directorio que contendra las clases de nuestra página*/

require_once(LIB_DIR.SD.'config.php');
require_once(LIB_DIR.SD.'functions.php');
require_once(LIB_DIR.SD.'database.php');
require_once(LIB_DIR.SD.'database_table.php');
require_once(LIB_DIR.SD.'menu.php');
require_once(LIB_DIR.SD.'sections.php');
require_once(LIB_DIR.SD.'subsections.php');
require_once(LIB_DIR.SD.'product.php');
require_once(LIB_DIR.SD.'session.php');
require_once(LIB_DIR.SD.'pagination.php');
require_once(LIB_DIR.SD.'user.php');
require_once(LIB_DIR.SD.'search.php');
require_once(LIB_DIR.SD.'register.php');



?>
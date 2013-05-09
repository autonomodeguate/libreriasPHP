<?php

/*Definimos las constantes que nos serviran para tener acceso directo a las carpetas de nuestra página*/
defined("SD") ? NULL : define("SD",DIRECTORY_SEPARATOR); /*DIRECTORY_SEPARATOR nos devuelve el simbolo segun el sistema operativo ya sea Windows(\) - Linux (/)*/

defined("RAIZ_DIR") ? NULL : define("RAIZ_DIR","D:".SD."wamp".SD."www".SD."laboratorios");/*Marcamos la ruta directa a la carpeta raiz*/

//defined("RAIZ_DIR") ? NULL : define("RAIZ_DIR","D:".SD."hshome".SD."c298229".SD."imedics.ws/laboratorios/");

defined("LIB_DIR") ? NULL : define("LIB_DIR",RAIZ_DIR.SD."includes");/*Marcamos la ruta directa al directorio que contendra las clases de nuestra página*/

require_once(LIB_DIR.SD.'config.php');
require_once(LIB_DIR.SD.'functions.php');
require_once(LIB_DIR.SD.'database.php');
require_once(LIB_DIR.SD.'database_table.php');
require_once(LIB_DIR.SD.'session.php');
require_once(LIB_DIR.SD.'pagination.php');
/******/

require_once(LIB_DIR.SD.'medic.php');
require_once(LIB_DIR.SD.'speciality.php');
require_once(LIB_DIR.SD.'medicaments.php');
require_once(LIB_DIR.SD.'comments.php');
require_once(LIB_DIR.SD.'prescription.php');
require_once(LIB_DIR.SD.'visits.php');
require_once(LIB_DIR.SD.'labs.php');

?>
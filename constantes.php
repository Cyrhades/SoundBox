<?php

define('HTTP_ADRESS','http://127.0.0.1/', true);
define('HTTP_DIR_LOCATION', 'soundBox/', true);
define('APP_NAME', 'SoundBox', true);

//------------------------------------------------------------------------------
//				BASE URL ET BASE NAMESPACE
//------------------------------------------------------------------------------
define('URL_SITE', HTTP_ADRESS.HTTP_DIR_LOCATION, true);
define('DIR_SEP','\\', true);
define('DIR_BASE',dirname(__FILE__).DIR_SEP, true);

define('DIR_CONF', DIR_BASE.'config'.DIR_SEP, true);

define('BASE_FILE_SYSTEM', dirname(__FILE__).DIR_SEP.'System'.DIR_SEP, true );
define('PRIMARY_NAMESPACE',BASE_FILE_SYSTEM.'App'.DIR_SEP, true);

//------------------------------------------------------------------------------
//						BOOT
//------------------------------------------------------------------------------
define('NAME_BOOT','Bootstrap', true);
define('ClASS_AUTOLOAD','SplClassLoader', true);

//------------------------------------------------------------------------------
//				LES MODULES
//------------------------------------------------------------------------------
define('DIR_SYSTEM', DIR_BASE.'System'.DIR_SEP, true );
define('DIR_MODULES',DIR_SYSTEM.'Modules'.DIR_SEP, true);
define('MODULES_NAMESPACE',BASE_FILE_SYSTEM.'Modules'.DIR_SEP, true);

//------------------------------------------------------------------------------
//				LES FICHIERS
//------------------------------------------------------------------------------
// Classe standard
define('EXT_STD_CLASSE','.class.php', true);

define('ARTWORK',DIR_BASE.'artwork'.DIR_SEP, true);
define('PATH_VIEW',ARTWORK.'{theme}'.DIR_SEP.'view'.DIR_SEP, true);
define('EXT_VIEW','.php', true);

//------------------------------------------------------------------------------
//				LES RESSOURCES (URL)
//------------------------------------------------------------------------------
define('URL_RESSOURCES',URL_SITE.'artwork/', true);
define('THEME_NAME','default/', true);
define('DIR_CSS',URL_RESSOURCES.THEME_NAME.'css/', true);
define('DIR_IMG',URL_RESSOURCES.THEME_NAME.'img/', true);
define('DIR_JS',URL_RESSOURCES.THEME_NAME.'js/', true);
define('DIR_FONT',URL_RESSOURCES.THEME_NAME.'fonts/', true);


//------------------------------------------------------------------------------
//				CHARGEMENT DES CONFIG
//------------------------------------------------------------------------------
if (file_exists(DIR_CONF.'database.php')) {
	require_once DIR_CONF.'database.php';
}
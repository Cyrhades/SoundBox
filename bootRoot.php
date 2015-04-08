<?php
if (!isset($_SERVER['REQUEST_TIME_FLOAT'])) {
    $_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);
}
//------------------------------------------------------------------------------
//				CHARGEMENT DES CONSTANTES
//------------------------------------------------------------------------------
// Chargement des constantes
$_sFileConstante = dirname(__FILE__).'/constantes.php';
if (file_exists($_sFileConstante) && is_readable($_sFileConstante) ) {
	require_once $_sFileConstante;
	unset($_sFileConstante);
} else {
	// @todo Rediriger vers l'installation
	throw new Exception('SoundBox non installé.');
}

//------------------------------------------------------------------------------
//				CHARGEMENT DES RESSOURCES D'UN MODULES
//------------------------------------------------------------------------------
if (sizeof($_GET) > 0 && isset($_GET['sndbx_artwork'])) {
	
	// On enleve les ".." pour ne pas redescendre dans les dossiers
	$sFile = str_replace('..','', $_GET['sndbx_artwork']);
	if (preg_match( '/.*\.(css|js)$/', $sFile,$aExt)) {
		if ($aExt[1] === 'css') {
			header("Content-type: text/css");
		}
		$sFileRessource = DIR_MODULES.ucfirst(trim( $sFile, '/'));
		if (file_exists($sFileRessource) && is_readable($sFileRessource) ) {
			readfile($sFileRessource);
		}
	}
	// On renvoi un fichier vide si on a pas trouvé
	die();
}

//------------------------------------------------------------------------------
//			CHARGEMENT STANDARD
//------------------------------------------------------------------------------
header('Content-Type: text/html; charset=utf-8');
// Chargement de SoundBox
if (defined('PRIMARY_NAMESPACE') && defined('NAME_BOOT') && defined('EXT_STD_CLASSE')) {
	$_sBootPath = PRIMARY_NAMESPACE.NAME_BOOT.EXT_STD_CLASSE;
	if (file_exists($_sBootPath) && is_readable($_sBootPath)) {
		// Chargement du bootstrap
		require_once $_sBootPath;
		$_sNameBoot = NAME_BOOT;
		new $_sNameBoot;
		// On libére la mémoire
		unset($_sBootPath); 
		unset($_sNameBoot); 
	} else {
		// @todo Rediriger vers l'installation
		throw new Exception('Erreur : SoundBox à échoué lors de l\'installation ou des parametres ne sont plus corrects.');
	}
}

//-- Chargement des évenements
App\Modules::getInstance();

// Premier évenement !!!
App\Modules::getInstance()->execute('LOAD_PAGE');

//-- Chargement de la vue
require App\Http\Viewer::getInstance()->pathView('index');

die();
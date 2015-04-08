<?php
/**
 * Chargement des Modules
 */
namespace App;
class Modules extends Commun
{
	private $aModules = array();
	private $aEvents = array();
	
	/**
	 * Chargement de tous les modules
	 *
	 * @param <type> $p_sNameModule
	 * @param <type> $p_aCallMethod
	 */
	public function loadModules() 
	{
		if (file_exists(DIR_MODULES) && is_dir(DIR_MODULES)) {
			$hModule = opendir(DIR_MODULES);
			// On boucle sur tous les modules
			while (($sModule = readdir($hModule)) !== false) {
				$this->loadModule($sModule);
			}
		}
	}
	
	/**
	 * Chargement d'un module
	 *
	 * @param <string> Nom du module
	 * @return <booleen> true si le module a été chargé
	 */
	public function loadModule($p_sModuleName) 
	{
		$bRetour = false;
		$sPathModule = DIR_MODULES.$p_sModuleName;
		// On charge le XML
		if (file_exists($sPathModule) 
			&& is_dir($sPathModule)
			&& $p_sModuleName != '.' 
			&& $p_sModuleName != '..'
		) {
			$sFileXml = $sPathModule.DIR_SEP.'/module.xml';
			if (file_exists($sFileXml) && is_readable($sFileXml)) {
				$bRetour = $this->analyseModule($sFileXml);
			}
		}
		return $bRetour;
	}
		
	/**
	 * Analyse d'un module
	 *
	 * @param <string> $p_sFileXml Path du fichier xml
	 */
	private function analyseModule($p_sFileXml)
	{
		$bRetour = false;
		libxml_use_internal_errors(true);
		$aXmlModule = simplexml_load_file($p_sFileXml);
		$aErrors = libxml_get_errors();
		if (empty($aErrors)) {
			if (is_object($aXmlModule)) {

				$sModuleName = (string) $aXmlModule->version->attributes()->name;
				$aDepencies = array();
				
				$aData = array(
					'name' 			=> $aXmlModule->version->attributes()->version,
					'author'		=> $aXmlModule->version->attributes()->author,
					'dependances' 	=> $aDepencies,
				);
				
				//-- @todo controler les dépendances
				if (true) {
					$this->addModule($sModuleName, $aData);
					foreach ($aXmlModule->execs->exec as $aExec) {

						$sEvent = (string) $aExec->attributes()->event;
						$aCallMethod = array(
							'class' 		=> (string) $aExec->attributes()->classe,
							'method'		=> (string) $aExec->attributes()->method
						);
						if (isset($aExec->params) && isset($aExec->params->param)) {
							$aParams = array();
							foreach ($aExec->params->param as $aParam) {
								$aParams[(string) $aParam->attributes()->name] = (string) $aParam;						
							}
							$aCallMethod['params'][] = $aParams;
						}
						
						if (isset($aExec->ressources) && isset($aExec->ressources->ressource)) {
							$aRessources = array();
							foreach ($aExec->ressources->ressource as $aRessource) {
								$aRessources[(string) $aRessource->attributes()->type][] = 
									(string) $aRessource->attributes()->path;						
							}
							$aCallMethod['ressources'][$sEvent] = $aRessources;
						}
						$this->addEventInModule($sModuleName, $sEvent, $aCallMethod);
						//-- @todo A gérer correctement
						$bRetour = true;
					}
				}
			}
		}
		return $bRetour;
	}
	
	/**
	 * Ajout d'un evenement et les infos pour son execution
	 *
	 * @param <string> $p_sNameModule
	 * @param <array> $p_aDataModule
	 */
	private function addModule($p_sNameModule = '', $p_aDataModule = array())
	{
		//----- DECLARATIONS DU MODULES SI PAS ENCORE DECLARE
		if (!isset($this->aModules[$p_sNameModule])) {
			$this->aModules[$p_sNameModule] = $p_aDataModule;
		}
	}
	
	/**
	 * Ajoute un evenement à un module
	 *
	 * @param <string> $p_sNameModule
	 * @param <array> $p_aDataModule
	 */
	private function addEventInModule($p_sNameModule = '', $p_sNameEvent = '', $p_aCallMethod = array())
	{
		//----- DECLARATIONS D'UN EVENT SUR LE MODULE
		if (!isset($this->aModules[$p_sNameModule])) {
			$this->aModules[$p_sNameModule] = array();
		}
		if (!isset($this->aModules[$p_sNameModule]['events'])) {
			$this->aModules[$p_sNameModule]['events'] = array();
		}
		$this->aModules[$p_sNameModule]['events'][$p_sNameEvent] = $p_aCallMethod;
		//-- Cela permettra detrouver rapidement notre module
		$this->addEvent($p_sNameEvent, $p_sNameModule);
	}
	
	/**
	 * Ajout un module à un evenement
	 *
	 * @param <string> $p_sNameModule
	 * @param <array> $p_aDataModule
	 */
	private function addEvent($p_sNameEvent = '', $p_sNameModule = '')
	{
		//----- DECLARATIONS D'UN EVENT
		if (isset($this->aModules[$p_sNameModule])) {
			// On ajoute à notre évenement notre module
			if (!isset($this->aEvents[$p_sNameEvent])) {
				$this->aEvents[$p_sNameEvent] = array();
			}
			// On ajoute notre module aux événements
			$this->aEvents[$p_sNameEvent][] = $p_sNameModule;
		}
	}
	
	/**
	 * Execution d'un evenement 
	 * @param <string> $p_sNameEvent nom de l'événement
	 * @[params] func_get_args()
	 */
	public static function execute($p_sNameEvent = '')
	{
		$o_Modules = Modules::getInstance();
		if (isset($o_Modules->aEvents[$p_sNameEvent])) {
			// Boucle sur les modules
			foreach ((array) $o_Modules->aEvents[$p_sNameEvent] as $k => $sNameModule) {
				// Si on n'a pas d'event sur le module on passe à la suite
				if (!isset($o_Modules->aModules[$sNameModule]['events'][$p_sNameEvent])) continue;
				$aInfosModule = $o_Modules->aModules[$sNameModule]['events'][$p_sNameEvent];
				
				if (! empty($aInfosModule['class']) && ! empty($aInfosModule['method'])) {
					// Récupération des parametres
					if (!isset($aInfosModule['params'])) {
						$aInfosModule['params'] = array();
					}
					elseif (!is_array($aInfosModule['params'])) { 
						logError( 'E-0100','Erreur params doit être un tableau dans la liste des événements.' );
					}
					if (method_exists($aInfosModule['class'], $aInfosModule['method']))	{
						$tParams = func_get_args();
						unset($tParams[0]); // $p_sNameEvent nom de l'événement
						// Instance du module
						$oModuleInstance = $aInfosModule['class']::getInstance();
						if (isset($aInfosModule['ressources'][$p_sNameEvent])) {
							$oModuleInstance->loadRessource($aInfosModule['ressources'][$p_sNameEvent]);
						}
						// Execution
						call_user_func_array(
							array( 
								$oModuleInstance,
								$aInfosModule['method'] 
							), 
							array_merge( 
								$aInfosModule['params'],
								$tParams 
							) 
						);
					}
				}				
			}
		}
	}	
	
	/**
	 * Initialisation du module
	 */
	public function init_menu()
	{
		// Ajout dans le menu
		\App\Hook::getInstance()->add('MENU', array($this,'addMenu'), func_get_args());
	}
	
	/**
	 * Ajout au menu (avec parametres)
	 */
	public function addMenu()
	{
		$aParams = func_get_args();
		if ($aParams >= 1) {
			if (isset($aParams[0])) {
				return $aParams[0];
			}
		}
	}
	
	/**
	 * Chargement des ressources JS et CSS
	 */
	public function loadRessource($p_aInfosModule)
	{
		foreach ((array)$p_aInfosModule as $sTypeRes => $aRes) {
		
			if (count($aRes)>0) {
				switch ($sTypeRes) {
					case 'css' :
							foreach ((array)$aRes as $iKey => $sPathRes) {
								$oMethod = \App\Http\Viewer::getInstance();
								Hook::getInstance()->add(
									'HEADER_CSS', 
									array($oMethod,'getPathCSS'),
									$sPathRes
								);
							}
						break;
					case 'javascript' :
						foreach ((array)$aRes as $iKey => $sPathRes) {
								$oMethod = \App\Http\Viewer::getInstance();
								Hook::getInstance()->add(
									'HEADER_JS', 
									array($oMethod,'getPathJS'),
									$sPathRes
								);
							}
						break;
				}
			}
		}
	}
	
	
}
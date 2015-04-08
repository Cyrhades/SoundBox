<?php
/**
 * ControllerGeneric 0.1 
 *
 * @author LECOMTE Cyril <cyrhades76@gmail.com>
 * @version 14/09/2015
 * @since 14/09/2015
 */
namespace App\Controller;
class Generic extends \App\Commun
{
	/**
	 * Chargement du controller
	 */
	public function load($p_sNameController)
	{
		// On crée tout simplement un evenement
		\App\Modules::getInstance()->execute('START_CONTROLLER_'.$this->eventName($p_sNameController));
	}
	
	/**
	 * Gestion du nom des evenements
	 */
	private function eventName($p_sNameController)
	{
		// Remplace les caracteres accentue
 		$sName = preg_replace(
			array('/[àáâãä]/i','/[éèëê]/i','/[ç]/i','/[ìíîï]/i','/[ñ]/i','/[òóôõö]/i','/[ùúûü]/i','/[ýÿ]/i'),
			array('a','e','c','i','n','o','u','y'),
			$p_sNameController
		);
		$sName = trim($sName,'_'); 

		return strtoupper($sName);
	}
}
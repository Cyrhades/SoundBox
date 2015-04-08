<?php
namespace App;
abstract class Commun
{
	/**
	 * Multi single instance ^^ 
	 * Permet de travailler via des instance en multi niveau
	 * Exemple : 	- Commande->getInstance('WEB')->valider();
	 *				- Commande->getInstance('ADMIN')->valider();
	 * On peut dans ce cas travailler sur 2 instances différentes 
	 * en gérant du single avec un niveau supplémentaire.
	 */
	final public static function getInstance($p_sNameInstance = null)
	{
        static $aoInstance = array();

        $calledClassName = get_called_class();
		if (!empty($p_sNameInstance)) {
			if (!isset($aoInstance[$p_sNameInstance][$calledClassName]))	{
				$aoInstance[$p_sNameInstance][$calledClassName] = new $calledClassName();
			}
			$oRetour = $aoInstance[$p_sNameInstance][$calledClassName];
		} else {
			if (!isset($aoInstance[$calledClassName]))	{
				$aoInstance[$calledClassName] = new $calledClassName();
			}
			$oRetour = $aoInstance[$calledClassName];
		}
        return $oRetour;
    }
}
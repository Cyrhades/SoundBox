<?php
/**
 * Hook 0.2 gére la création d'un hook et l'éxécution
 *
 * @author  LECOMTE Cyril <cyrhades76@gmail.com>
 * @modified 03/03/2015
 * @since 17/12/2009
 */
namespace App;
class Hook extends Commun
{
	protected $tListeHook = array();
	
	/**
	 * ajoute un hook
	 *
	 * @Author : LECOMTE Cyril <cyrhades76@gmail.com>
	 */
	public function add($p_sHookName = '', $p_sFonctionCallback = '')
	{
		if (!isset( $this->$p_sHookName) || !is_array($this->$p_sHookName)) {
			$this->$p_sHookName = array();
			$this->tListeHook[$p_sHookName] = array();
		}
		// on controle le nombre d'arguments reçu
		$numArgs = func_num_args();
		// si on en a au moins 2 arguments
		if ($numArgs >= 2)	{
			$hookArguments = array();
			// si il y a plus de 2 arguments
			if ($numArgs > 2) {
				// on crée un tableau à partir du 3eme element
				for ($i = 2; $i < $numArgs; $i++)  {
					$mData = func_get_arg($i);
					if (is_array($mData)) {
						// Pour lancer une liste de parametre avec un tableau
						foreach( (array)$mData as $mKey => $mValue) {
							$hookArguments[$mKey] = $mValue;
						}
					} else {
						$hookArguments[] = func_get_arg($i);
					}
				}
			}
			if (!empty($p_sHookName) && !empty($p_sFonctionCallback)) {
				 // on eneregistre les arguments
				array_push($this->tListeHook[$p_sHookName],$hookArguments);
				// on energistre la fonction
				array_push($this->$p_sHookName, $p_sFonctionCallback);
				
			}
		}
		// on a pas reçu les 2 premiers argument indispensable
		else throw new Exception( 'Erreur utilisation hook.' ); 
	}
	
	/**
	 * execute un hook
	 *
	 * @Author : LECOMTE Cyril <cyrhades76@gmail.com>
	 */
	public function run($p_sHookName = '')
	{
		$mInfosHook = array();
		if (
			!empty($p_sHookName)
			&& isset($this->$p_sHookName)
			&& is_array($this->$p_sHookName) 
		) {
			foreach ($this->$p_sHookName as $num => $tCallback ) {
				if (method_exists($tCallback[0],$tCallback[1])) {
					if (isset($this->tListeHook[$p_sHookName][$num])) {
						// function avec les arguments
						$mInfosHook[] = call_user_func_array(
							array($tCallback[0],$tCallback[1]),
							$this->tListeHook[$p_sHookName][$num]
						);
					} else {
						// function
						$mInfosHook[] = call_user_func(array($tCallback[0],$tCallback[1]));
					}
				}
				// @todo Gérer simple fonction
			}
		}

		return $mInfosHook;
	}
	
	/**
	 * Fonction generic pour faire une simple retour d'une variable
	 *
	 * @Author : LECOMTE Cyril <cyrhades76@gmail.com>
	 */
	public function getReturn($p_mReturn = null)
	{
		return $p_mReturn;
	}
}
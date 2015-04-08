<?php
namespace App\Debug;

class Time extends \App\Commun
{	
    /**
     * @var microtime 
     */
    public $sStartTime = null;
    
	/**
	 * Démarre le chrono pour cette instance
	 */
	public function __construct()
	{
		$this->sStartTime = $this->getTime();
	}
	
	/**
	 * Retourne le temps courant
	 */
	private static function getTime()
	{
		return microtime(true);
	}
	
    /**
     * Retourne le temps de l' instance
     * @param string  nombre de décimal
     * @return float Temps d'un instance
     */
	public function timeSinceStartInstance($p_iDecimal = 3)
	{
		return round(self::getTime()-$this->sStartTime,$p_iDecimal);
	}
    
    /**
     * Retourne le temps depuis le début du chargement PHP
     * @param string  nombre de décimal
     * @return float Temps d'un instance
     */
    public function totalPageTime($p_iDecimal = 3)
    {
        return round(self::getTime()-$_SERVER['REQUEST_TIME_FLOAT'],$p_iDecimal);
    }
}
<?php
namespace App\Http;

class Params extends \App\Commun
{
	/**
	 * Retourne les parametres reçu en POST
	 */
	public function post($p_sVariable = null)
	{
		$mParams = array();
		if ($_SERVER['REQUEST_METHOD']==="POST") {
            if ($p_sVariable !== null) {
                $mParams = (isset($_POST[$p_sVariable]) 
                    ? $_POST[$p_sVariable] 
                    : null);
            } else {
                $mParams = $_POST;
            }
		}
		return $mParams;
	}
	
    /**
	 * Retourne les parametres reçu en FILES
	 */
	public function files($p_sVariable = null)
	{
		$aParams = array();
        if (isset($_FILES)) {
            if ($p_sVariable !== null) {     
                echo \App\Debug\Dump::getInstance()->printr($_FILES[$p_sVariable], true);
                $aParams = (isset($_FILES[$p_sVariable]) 
                    ? $_FILES[$p_sVariable] 
                    : null);
            } else {
                $aParams = $_FILES;
            }
        }

		return $aParams;
	}
	/**
	 * Retourne les parametres reçu en GET
	 */
	public function get($p_sVariable = null)
	{
        $mParams = array();
        if ($p_sVariable !== null) {
            $mParams = (isset($_GET[$p_sVariable]) 
                ? $_GET[$p_sVariable] 
                : null);
        } else {
            $mParams = $_GET;
        }
		
		return $mParams;
	}	
	
	/**
	 * Retourne les parametres reçu en PUT
	 */
	public function put()
	{
		$aParams = array();
		if ($_SERVER['REQUEST_METHOD']==="PUT") {
			parse_str(
				file_get_contents(
					'php://input', false, null, -1, $_SERVER['CONTENT_LENGTH']
				), 
				$aParams
			);
		}
		return $aParams;
	}	
    
   	/**
	 * Retourne la taille d'un type de paramétre
	 */
    public function sizeOf($p_sType)
    {
        $iSizeof = 0;
        switch ($p_sType) {
            case 'post' :
            case 'POST' :
                $iSizeof = \sizeof($_POST);
                break;
            case 'get' :
            case 'GET' :
                $iSizeof = \sizeof($_GET);
                break;
        }
        return $iSizeof;
    }
}
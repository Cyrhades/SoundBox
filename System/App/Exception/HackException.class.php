<?php
namespace App\Exception;

class HackException extends ClientException { 

	public function __construct($p_sMessage, $p_sCode = 0) {
		// Enregistrement de l'attaque
		$this->saveDetection($p_sMessage, $p_sCode);
		// Envoi d'une ExceptionClient
		parent::__construct($p_sMessage, $p_sCode);
    }

	/**
	 * Enregistrement d'une détection d'attaque
	 */
	private function saveDetection($p_sMessage, $p_sCode)
    {
		
	}
}
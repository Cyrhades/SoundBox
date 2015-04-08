<?php
namespace Modules\Upload\lib;

class Upload extends \App\Modules
{
    const MAX_FILE_SIZE = 30000;
    
	/**
	 * Chargement du Controller
	 */
	public function loadController($p_aParam) 
	{
		// Chargement du controller
		UploadController::getInstance()->controlFormUpload();
		
		// Chargement de la vue
		if (isset($p_aParam['view']) && is_string($p_aParam['view'])) {
			\App\Hook::getInstance()->add(
				'HTML_BODY', 
				array(	
					\App\Http\Viewer::getInstance(),
					'loadModuleView'
				),
				$p_aParam['view']
			);
		}	
	}
	
	/**
	 * Préparation du formulaire
	 */
	public function initFormUpload()
	{
        $sMp3Name = \App\Http\Params::getInstance()->post('mp3_name'); 
        $sName = '';
        if (!empty($sMp3Name)) {
            $sName = $sMp3Name;
        }

        $aElements = array();
		$aElements[] = array(
			'ordre'		=> 10,
			'label' 	=> array(
				'for'		=> 'nom',
				'text'		=> \App\Language\Traduction::text('Nom du MP3')
			),
			'input'		=> array(
				'type' 		=>	'text',
				'id' 		=>	'mp3_name',
				'name' 		=>	'mp3_name',
                'value'     =>  \App\Http\Viewer::printText($sName)
			)
		);

		$aElements[] = array(
			'ordre'		=> 19,
			'input'		=> array(
				'type' 		=> 'hidden',
				'name' 		=> 'MAX_FILE_SIZE',
				'value'		=> self::MAX_FILE_SIZE
			)
		);
		$aElements[] = array(
			'ordre'		=> 20,
			'label' 	=> array(
				'for'		=> 'file',
				'text'		=> \App\Language\Traduction::text('Fichier MP3')
			),
			'input'		=> array(
				'type' 		=>	'file',
				'id' 		=>	'mp3_file',
				'name' 		=>	'mp3_file'					
			)
		);
		// On boucle sur chaque élément du tableau
		foreach ((array) $aElements as $iOrdre => $aData) {
			\App\Hook::getInstance()->add('INIT_FORM_UPLOAD_MP3',array(\App\Hook::getInstance(),'getReturn'), array($aData) );
		}
	}
	
	/**
	 * La methode qui retournera les infos au Hook pour le formulaire
	 */
	public function constructFormUpload($p_aElements)
	{
		return $p_aElements;
	}
	
	
	/**
	 *
	 */
	public function uploadFile()
	{

	}
	
	/**
	 *
	 */
	private function saveFile()
	{
		if (defined('BDD_ENABLE') && BDD_ENABLE===true) {
			// @todo save in BDD
		}
	}
}

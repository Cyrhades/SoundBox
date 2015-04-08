<?php
namespace Modules\Upload\lib;

class UploadController extends \App\Controller\Generic
{
    /**
     * Prise en compte du formulaire
     * @return boolean
     * @throws UploadException
     * @throws \App\Exception\HackException
     */
	public function controlFormUpload()
	{
        try {
            $this->controlFormulaire();
        } catch (\Exception $e) {
            \App\Hook::getInstance()->add(
				'PRINT_CLIENT_MESSAGE', 
				array(	
					\App\Http\Viewer::getInstance(),
					'printError'
				),
				$e->getMessage()
			);
        }
	}
  
    /**
     * 
     */
    private function controlFormulaire()
    {
        $bRetour = false;
        if (\App\Http\Params::getInstance()->sizeOf('post') > 0) {
            $iMaxFile = (int) \App\Http\Params::getInstance()->post('MAX_FILE_SIZE');
            // Vérifie la cohérence des données
            if ($iMaxFile==Upload::MAX_FILE_SIZE) {
                $sMp3Name = \App\Http\Params::getInstance()->post('mp3_name');
                //echo \App\Debug\Dump::getInstance()->printr($sMp3Name, true);
                if (!empty($sMp3Name)) {
                    $aMp3File = \App\Http\Params::getInstance()->files('mp3_file');
                    if(is_array($aMp3File) && isset($aMp3File['error'])) {
                        if ($aMp3File['error'] === UPLOAD_ERR_OK) {
                            $bRetour = $this->loadMP3File($aMp3File);
                        } else {
                            throw new \App\Exception\UploadException($aMp3File['error']);
                        } 
                    }
                }
            } else {
                throw new \App\Exception\HackException(
                    \App\Language\Traduction::text('Erreur formulaire modifié.')
                );
            }
        }
        
        return $bRetour;
    }    
    
    /**
     * 
     * @param array $p_aMp3File $_FILES format
     */
    private function loadMP3File($p_aMp3File)
    {
        echo \App\Debug\Dump::getInstance()->printr($p_aMp3File, true);
        return true;
    }
}

<?php
namespace App\Exception;
class UploadException extends ClientException
{
    public function __construct($p_sCode) {
        $sMessage = $this->codeTosMessage($p_sCode);
        parent::__construct($sMessage, $p_sCode);
    }

    private function codeTosMessage($p_sCode)
    {
        switch ($p_sCode) {
            case UPLOAD_ERR_INI_SIZE:
                $sMessage = \App\Language\Traduction::text(
                    'La taille de votre fichier est trop importante.'
                );
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $sMessage = \App\Language\Traduction::text(
                    'La taille de votre fichier est trop importante.'
                );
                break;
            case UPLOAD_ERR_PARTIAL:
                $sMessage = \App\Language\Traduction::text(
                    'La fichier n\'a pas été reçu entiérement.'
                );
                break;
            case UPLOAD_ERR_NO_FILE:
                $sMessage = \App\Language\Traduction::text(
                    'Aucun fichier reçu.'
                );
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $sMessage = \App\Language\Traduction::text(
                    'Le fichier temporaire est introuvable.'
                );
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $sMessage = \App\Language\Traduction::text(
                    'L\'écriture du fichier sur le serveur a échoué.'
                );
                break;
            case UPLOAD_ERR_EXTENSION:
                $sMessage = \App\Language\Traduction::text(
                    'Le fichier a une extension non autorisé.'
                );
                break;

            default:
                $sMessage = \App\Language\Traduction::text(
                    'Erreur inconnu.'
                );
                break;
        }
        return $sMessage;
    }
} 
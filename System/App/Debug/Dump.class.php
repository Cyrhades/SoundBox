<?php
namespace App\Debug;

class Dump extends \App\Commun
{	
    /**
     * @var array Liste des dumps 
     */
    private $aDump = array();
    
    /**
     * Dump en affichage sans capture
     * @param mixed $p_mValue Information à printer
     * @param booleen $p_bWithMarker Print un à marqueur à l'endroit du dump
     */
    public function printr($p_mValue)
    {
        return '<pre>'.print_r($p_mValue, true).'</pre>';

    }
    /**
     * 
     * @param mixed $p_mValue Information à printer
     * @param booleen $p_bWithMarker Print un à marqueur à l'endroit du dump
     */
    public function capture($p_mValue, $p_bWithMarker = false)
    {
        $sNameDump = (string) uniqid('dm_');
        $this->aDump[$sNameDump] = $p_mValue;
        if ($p_bWithMarker) {
            return $this->marker($sNameDump);
        }
        return '';
    }

    /**
     * Ecrit un marker
     * @param type $p_sNameDump
     */
    private function marker($p_sNameDump)
    {
        if (!empty($p_sNameDump)) {
            return '<span class="dumpMarker" id="'.$p_sNameDump.'"></span>';
        }
        return '';
    }
}
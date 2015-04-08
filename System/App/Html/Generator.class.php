<?php
namespace App\Html;

class Generator extends \App\Html\Element
{
    /**
     * @var object 
     */
    private $oParent = null;
    
    /**
     * @var array/object 
     */
    private $oElements = null;
    
    /**
     * @var object 
     */
    private $oCurrentElement = null;
    
    /**
     * Crée un élément Html
     * @param string $p_sTagName Tag de l'élément
     * @return object
     */
    public function addElement($p_sTagName){
        
        if (!isset($this->aTagsHtml5[$p_sTagName])) return $this;
        
        $sNameElement = uniqid();
        // Si il y a un parent
        if ($this->oCurrentElement !== null) {
            $this->oParent = $this->oCurrentElement;
            $this->oParent->children[$sNameElement] = self::getInstance($sNameElement);
            $this->oParent->children[$sNameElement]->sTagName = $p_sTagName;
            // l'élément créé devient l'élément courant
            $this->oCurrentElement = $this->oParent->children[$sNameElement];
        } else {
            $this->oElements[$sNameElement] = self::getInstance($sNameElement);
            $this->oElements[$sNameElement]->sTagName = $p_sTagName;
            $this->oCurrentElement = $this->oElements[$sNameElement];
        }
        return $this;
    }
    

    public function setText($p_sText = '')
    {
        $this->oCurrentElement->sText = (string) $p_sText;
        return $this;
    }
    
    public function setAttr($p_sAttribut, $p_sValue = '')
    {
        if (!empty($p_sAttribut)) {
            $this->oCurrentElement->aAttributs[$p_sAttribut] = (string) $p_sValue;
        }
        return $this;
    }
    
    /**
     * Retourne le parent de l'élément courant
     * @param string $p_sNameElement Nom de l'élément
     * @param string $p_sTagName Tag de l'élément
     * @return object
     */
    public function parent()
	{
        if ($this->oParent !== null) {
            $this->oCurrentElement = $this->oParent;
        } else {
            $this->oCurrentElement = null;
        }
        return $this;
	}

    
    
    /**
     * Retourne le code Html
     * @return type
     */
    public function __toString()
    {
        return (string) $this->generateHtml($this->oElements);
    }
    
    /**
     * Génére le code Html à partir des éléments
     */
    private function generateHtml($p_oElements)
    {
        $sHtml = '';
        if (!empty($p_oElements)) {
            foreach ((array) $p_oElements as $oElement) {
                $sHtml .= '<'.$oElement->sTagName;      
                // On boucle pour créer les attributs
                foreach ((array)$oElement->aAttributs as $sAttribut => $sValue) {
                    $sHtml .= ' '.\App\Http\Viewer::printText($sAttribut);
                    $sHtml .= '="'.\App\Http\Viewer::printText($sValue).'"';
                }
                if ($this->aTagsHtml5[$oElement->sTagName]['autoclosed'] === true) {
                    $sHtml .= ' />';
                } else {
                    $sHtml .= '>';
                    if (!empty($oElement->children)) {
                        $sHtml .= $this->generateHtml($oElement->children);
                    }
                    if (!empty($oElement->sText)) {
                        $sHtml .= \App\Http\Viewer::printText($oElement->sText);
                    }
                    $sHtml .= '</'.$oElement->sTagName.'>';  
                }
            }
        }
        return $sHtml;
    }
    
     /**
     * Génére le code Html à partir des éléments
     */
    private function createTag()
    {
        
    }
}

<?php
namespace App\Html;

abstract class Element extends Html5
{
    /**
	 * @var Attributs
	 */
	public $aAttributs = array();
        
    /**
	 * @var Les enfants de l'élément
	 */
	public $children = array();
    
    /**
	 * @var TagName
	 */
    public $sTagName = null;
    
    /**
	 * @var Texte
	 */
    public $sText = '';
  
    
}
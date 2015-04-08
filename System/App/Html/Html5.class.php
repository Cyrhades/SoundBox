<?php
namespace App\Html;

abstract class Html5 extends \App\Commun
{
    /**
	 * @var array Tags
	 */
	public $aTagsHtml5 = array(
        'form'=>array(
            'autoclosed'=>true,
            'attributs'=> array('action'=>'#','method'=>'POST')
        ),
        'label'=>array(
            'autoclosed'=>false,
            'attributs'=> array()
        ),
        'input'=>array(
            'autoclosed'=>true,
            'attributs'=> array('type'=>'text','value'=>'')
        ),    
        'span'=>array('autoclosed'=>false)
    );

}
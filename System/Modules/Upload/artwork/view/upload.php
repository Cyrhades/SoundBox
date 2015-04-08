<?php
	// INIT INIT_FORM_UPLOAD_MP3
	App\Modules::getInstance()->execute('INIT_FORM_UPLOAD_MP3');
	// On récupére le retour du Hook
	$aElementsForm = App\Hook::getInstance()->run('INIT_FORM_UPLOAD_MP3');

	// Si on a des éléments dans le tableau
	if (count($aElementsForm) > 0) {		
		// Trie du tableau par priorité (ordre d'affichage)
		usort($aElementsForm, function($a, $b){
			return (isset($a['ordre']) && isset($b['ordre']) && $a['ordre']>$b['ordre']);
		});
?>	
<div class="form_upload">
	<h2>
        <?php echo \App\Language\Traduction::text('Envoyer un mp3 pour la soundBox !'); ?>
    </h2>
	<form enctype="multipart/form-data" action="#" method="post">
	<?php    
        //echo \App\Debug\Dump::getInstance()->printr($aElementsForm, true);
		$oForm = App\Html\Generator::getInstance('form_upload_mp3');
		foreach ((array)$aElementsForm as $iKey => $aElement) {
            //-- Création du span
            $oForm->addElement('span');
            // Création du label
            if (isset($aElement['label'])) {
                $oForm->addElement('label');
                // Ajout du texte dans le label
                if (isset($aElement['label']['text'])) {
                    $oForm->setText($aElement['label']['text']);
                }
                if (isset($aElement['label']['for'])) {
                    $oForm->setAttr('for', $aElement['label']['for']);
                } 
            }
            // On remonte au parent
            $oForm->parent();
            if (isset($aElement['input'])) {
                $oForm->addElement('input');
                foreach ((array)$aElement['input'] as $sAttr => $sValue) {
                    $oForm->setAttr($sAttr, $sValue);
               }
            }
            $oForm->parent();
		}
        echo $oForm;
        //echo \App\Debug\Dump::getInstance()->printr($oForm, true);
	?>
        <br /><br />
        <progress style="height:20px; width:100%;"  value="20" max="100"></progress>
		<div class="submit_button">
			<button type="submit" name="submit" value="mp3_send"><i class="fa fa-music"></i> &nbsp; Envoyer mon MP3</button>
		</div>
	</form>
</div>
<?php
}

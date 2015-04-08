<?php 
	// INIT MENU
	App\Modules::getInstance()->execute('INIT_MENU');
	// On récupére le retour du Hook
	$aElementsMenu = App\Hook::getInstance()->run('MENU');
	// Si on a des éléments dans le tableau
	if (count($aElementsMenu) > 0) {
		// Trie du tableau par priorité (ordre d'affichage)
		usort($aElementsMenu, function($a, $b){
			return (isset($a['ordre']) && isset($b['ordre']) && $a['ordre']>$b['ordre']);
		});
?>
			<header role="banner">
				<nav role="navigation" class="navbar navbar-default ng-hide">
					<div class="navbar-header">
						<button class="navbar-toggle" type="button">
							<i class="fa fa-reorder"></i>
						</button>
					</div>
					<div id="horizontal-navbar">
						<ul class="nav navbar-nav">
		<?php
			foreach ((array)$aElementsMenu as $iKey => $aMenu) {
				echo
				'<li'.(!empty($aMenu['class']) 
							? ' class="'.App\Http\Viewer::printText($aMenu['class']).'"'
							:''
						).'>
					<a href="'.App\Http\Viewer::printText(URL_SITE.$aMenu['url']).'">
						'.(!empty($aMenu['fa_icone']) 
							? '<i class="fa fa-'.App\Http\Viewer::printText($aMenu['fa_icone']).'"></i>'
							:''
						).'
						<span>'.App\Http\Viewer::printText($aMenu['texte']).'</span>
					</a>
				</li>';
			}
		?>
						</ul>
					</div>
				</nav>
			</header>
<?php
}
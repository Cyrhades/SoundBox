<?php
namespace App\Http;

class Viewer extends \App\Commun
{
	/**
	 * Affiche une vue pour un module
	 */
	public function loadModuleView($p_sPathView)
	{
		require (substr($p_sPathView,0,1)=='\\' 
					? DIR_SYSTEM: '')
				.trim($p_sPathView,'\\');
	}
	
	/**
	 * Affiche une vue
	 */
	public function loadView($p_sNameView,$p_sTheme=null)
	{
		require $this->pathView($p_sNameView,$p_sTheme=null);
	}
	
	/**
	 * Retourne le chemin d'un fichier JS
	 *
	 * @param string Nom du fichier JS
	 * @param string Nom du répertoire
	 * @return string Chemin du fichier JS
	 */
	public function getPathJS($p_sName, $p_sDir = '')
	{
		$sUrl = (substr($p_sName, 0, 1) == "/" 
			? URL_SITE.trim($p_sName,'/')
			: (!empty($p_sDir)
					? trim($p_sDir,'/').'/'.$p_sName
					: $p_sName
			)
		);
		echo '<script src="'.(self::printText($sUrl)).'"></script>';
	}
	
	/**
	 * Retourne le chemin d'un fichier CSS
	 *
	 * @param string Nom du fichier CSS
	 * @return string Chemin du fichier CSS
	 */
	public function getPathCSS($p_sName, $p_sDir = '', $p_sDMedia = 'screen')
	{
		$sUrl = (substr($p_sName, 0, 1) == "/" 
			? URL_SITE.trim($p_sName,'/')
			: (!empty($p_sDir)
					? trim($p_sDir,'/').'/'.$p_sName
					: $p_sName
			)
		);

		echo '<link rel="stylesheet" type="text/css" href="'.(self::printText($sUrl)).
				'" media="'.(self::printText($p_sDMedia)).'" />'."\n";
	}
	
	/**
	 * Retourne le chemin d'une vue
	 */
	public function pathView($p_sNameView,$p_sTheme=null)
	{
		$sTheme = 'default';
		if ($p_sTheme!==null) {
			$sTheme = $p_sTheme;
		}
		return $this->rootPathView($sTheme).$p_sNameView.EXT_VIEW;
	}
	
	/**
	 * @todo : Gérer en fonction d'ou on se trouve la racine de la vue
	 */
	private function rootPathView($p_sTheme)
	{
		return str_replace('{theme}',$p_sTheme,PATH_VIEW);
	}
	
	
    public static function printInfo($p_sText)
	{
		echo '<div class="lc-info">'
            . '<i class="fa fa-info-circle"></i>'.self::printText($p_sText)
            .'</div>';
	}
    
    public static function printSuccess($p_sText)
	{
		echo '<div class="lc-success">'
            . '<i class="fa fa-check"></i>'.self::printText($p_sText)
            .'</div>';
	}
    
    public static function printError($p_sText)
	{
		echo '<div class="lc-error">'
            . '<i class="fa fa-times-circle"></i>'.self::printText($p_sText)
            .'</div>';
	}
    
    public static function printWarning($p_sText)
	{
		echo '<div class="lc-warning">'
            . '<i class="fa fa-warning"></i>'.self::printText($p_sText)
            .'</div>';
	}
    
	/**
	 * Protection contre les failles XSS
	 *
	 * @param <string> Texte à afficher
	 * @return <string> Texte protégé affichable
	 */
	public static function printText($p_sText)
	{
		return htmlspecialchars($p_sText);
	}

	public static function addHookJs($p_sName, $p_sDir = '')
	{
		return (!empty($p_sDir)?trim($p_sDir,'/').'/':'').$p_sName;
	}
	
	public static function addHookCSS($p_sName, $p_sDir = '')
	{
		return (!empty($p_sDir)?trim($p_sDir,'/').'/':'').$p_sName;
	}
	
	/**
	 * printJs :
	 * Tres utile pour le syteme de Hook en appelant cette fonction dans le hook
	 * l'appel du fichier javascript sera ajouté dans le header
	 *
	 * @param $p_fileJavascript (string) Nom du fichier javascript
	 */
	public static function printJs( $p_sContentJavascript = '' )
	{
		echo "\t\t".'<script type="text/javascript">'.$p_sContentJavascript.'</script>'."\n";
	}
	
	/**
	 * printFileCss :
	 */
	public function printFileCss($p_sFile = '')
	{
		if (file_exists($p_sFile)) {
			return $this->printCss(file_get_contents($p_sFile));
		}
	}
	
	/**
	 * printCss :
	 * Tres utile pour le syteme de Hook en appelant cette fonction dans le hook
	 * l'appel du fichier javascript sera ajouté dans le header
	 */
	public function printCss($p_sContentCss = '')
	{
		return "\t\t".'<style>'.$this->compressCss($p_sContentCss).'</style>'."\n";
	}

	public function compressCss($p_sBuffer = '') 
	{
		// Suppression des commentaires
		$p_sBuffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $p_sBuffer);
		// Suppression des tabulations, espaces multiples, retours à la ligne, etc.
		$p_sBuffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	 ', '	 '), '', $p_sBuffer);
		// Suppression des derniers espaces inutiles
		$p_sBuffer = str_replace(array(' { ',' {','{ '), '{', $p_sBuffer);
		$p_sBuffer = str_replace(array(' } ',' }','} '), '}', $p_sBuffer);
		$p_sBuffer = str_replace(array(' : ',' :',': '), ':', $p_sBuffer);
		$p_sBuffer = str_replace(array(' ; ',' ;','; '), ':', $p_sBuffer);
		
		return $p_sBuffer;
	}
	
	/**
	 *  Minified CSS
	 * @param <string> $p_sNameCss : Nom du fichier css  "style" => "style.css"
	 * @param <array> $p_tFiles  /!\ Attention l'ordre d'inclusion est important
	 * @param <booleen> $p_bMinified true, false, if true $p_sNameCss = "style" => "style-min.css"
	 */
	public function regrouperCss($p_sNameCss = '', $p_tFiles = array(), $p_bMinified = false)
	{
		$sCss = '';
		foreach ((array) $p_tFiles as $sFileCss) {
			$sCss .= file_get_contents($sFileCss);
		}
		return $sCss;
	}
	
	
	
}
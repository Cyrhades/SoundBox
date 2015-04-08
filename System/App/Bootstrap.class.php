<?php
/**
 * Classe de Boot
 */
class Bootstrap
{
	/**
	 * @var object Class Autoload
	 */
	public $oSplClassLoader;

	public function __construct()
	{
		// Chargement de l'autoload
		$this->autoload();
		// Chargement des évenements
		App\Modules::getInstance()->loadModules();
	}
	
	
	/**
	 * atuoload (utilise SplClassLoader) 
	 */
	private function autoload()
	{
		if (defined('EXT_STD_CLASSE') && defined('ClASS_AUTOLOAD')) {
			if (file_exists(BASE_FILE_SYSTEM.ClASS_AUTOLOAD.EXT_STD_CLASSE) 
				&& is_readable(BASE_FILE_SYSTEM.ClASS_AUTOLOAD.EXT_STD_CLASSE)) {
				require_once BASE_FILE_SYSTEM.ClASS_AUTOLOAD.EXT_STD_CLASSE;
				$sAutoLoad = ClASS_AUTOLOAD;
				$this->oSplClassLoader = new $sAutoLoad;
				$this->oSplClassLoader->setFileExtension(EXT_STD_CLASSE);
				$this->oSplClassLoader->register();
			} else {
				// @todo Rediriger vers l'installation
				throw new Exception('Erreur [1024] : '.APP_NAME.' à échoué lors de l\'installation ou des parametres ne sont plus corrects.');
			}
		} else {
			// @todo Rediriger vers l'installation
			throw new Exception('Erreur [1023] : '.APP_NAME.' à échoué lors de l\'installation ou des parametres ne sont plus corrects.');
		}
		return $this;
	}
	
}
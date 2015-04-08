<?php
/**
 * UrlRewriting 0.1 : systeme de gestion de l'url rewriting
 *
 * @author LECOMTE Cyril <cyrhades76@gmail.com>
 * @version 12-09-07
 * @version 10-01-16
 */
namespace Modules\UrlRewriting\lib;
class UrlRewriting extends \App\Modules
{
	/**
	 * decodeUrlRewrite : decoupe l'url puis fais une requete SQL pour gérer
	 * l'url rewirting en question
	 */
	public function decodeUrlRewrite()
	{
		$sNameController = trim(
			str_replace( 
				HTTP_DIR_LOCATION, 
				'', 
				$_SERVER['REQUEST_URI']
			),
			'/'
		);

		// CREATE EVENT FOR CONTROLLER
		\App\Controller\Generic::getInstance()->load($sNameController);
	}
}
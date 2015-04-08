<?php
namespace App\Language;
/**
 * Classe de Boot
 */
class Traduction
{
	public static function text($p_sValue, $p_sCodeLangue = 'FR')
	{
		return \App\Http\Viewer::printText($p_sValue);
	}
}
<!DOCTYPE html>
<html lang="<?php echo (isset($sCodeIso2) ? App\Http\Viewer::getInstance()->printText($sCodeIso2) : 'fr');?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo App\Http\Viewer::getInstance()->printText(APP_NAME); ?></title>
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta name="description" content="SoundBox, Banque sons">
			<meta name="author" content="LECOMTE Cyril">

			<link rel="icon" type="image/png" href="/favicon.png">
			<?php echo App\Http\Viewer::getInstance()->getPathCSS('reset.css',DIR_CSS);?>
			<?php echo App\Http\Viewer::getInstance()->getPathCSS('style.css',DIR_CSS);?>
			
			<?php App\Hook::getInstance()->run('HEADER_CSS');?>

			<?php App\Hook::getInstance()->run('HEADER_JS');?>

	</head>
	<body>
		<div id="_SD_Container">
            
            

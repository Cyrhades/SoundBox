<?php
// L'entete HTML
App\Http\Viewer::getInstance()->loadView('header');
// Menu
App\Http\Viewer::getInstance()->loadView('menu');

// Les messages
App\Hook::getInstance()->run('PRINT_CLIENT_MESSAGE');

// Contenu de Body
App\Hook::getInstance()->run('HTML_BODY');
// Le footer HTML
App\Http\Viewer::getInstance()->loadView('footer');

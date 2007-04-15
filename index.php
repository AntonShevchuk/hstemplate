<?php
/**
 * High Speed Template
 *
 * @author   AntonShevchuk (AntonShevchuk@gmail.com)
 */
require_once('_loader.php');

$mod    = (isset($_GET["mod"]))?$_GET["mod"]:null;	//get $mod from _GET

// menu page (you must separated this page if you want to use object inner template)
$DisplayMenu = & $HSTemplate->getDisplay('menu', true);
$DisplayMenu->addTemplate('menu', 'menu.html');


// content page
$DisplayContent = & $HSTemplate->getDisplay('content', true);
$DisplayContent->assign('display', 'DISPLAY');
switch ($mod) {
	case 'test1':
		$DisplayContent->addTemplate('test1', 'test1.html');
		$DisplayContent->assign('template', 'TEMPLATE 1', 'test1');
		break;
	case 'test2':
		$DisplayContent->addTemplate('test2', 'test2.html');
		$DisplayContent->assign('template', 'TEMPLATE 2', 'test2');
		break;
	case 'test3':
		$DisplayContent->addTemplate('test3', 'test3.html');
		$DisplayContent->assign('template', 'TEMPLATE 3', 'test3');
		break;

	default:
		$DisplayContent->addTemplate('default', 'default.html');
		break;
}

// index page
$DisplayIndex = & $HSTemplate->getDisplay('index');

// assign objects
$DisplayIndex->assign('DisplayMenu',        $DisplayMenu);
$DisplayIndex->assign('DisplayContent',     $DisplayContent);

// add templates
$DisplayIndex->addTemplate('header', 'header.html');
$DisplayIndex->addTemplate('index' , 'index.html' );
$DisplayIndex->addTemplate('footer', 'footer.html');

// assign global variables
$HSTemplate->assignGlobal('mod',     $mod);
$HSTemplate->assignGlobal('global',  'GLOBAL');

// display all non separated 'display'
$HSTemplate->display();
?>
<?php
declare(strict_types=1);

/**
* Dispatcheur
*/
define('ROOT', dirname(__FILE__));

//define('WEBROOT', 'http://'.$_SERVER['SERVER_NAME']."/name/"); // Local
define('WEBROOT', 'http://'.$_SERVER['SERVER_NAME'].'/');  // Production

// On charge le Singleton
require ROOT . '/app/App.php';

// On appel la méthode statique Load()
App::Load();

/**
 *
 * Par défaut la page "index" est appelée, sinon on appelle la page contenue dans le $_GET
 */
$page = $_GET['p'] ?? 'home.index';

/**
 * On charge le controller en décortiquant $_GET['p'] ex nameController.index ou admin.nameController.index
 * On vérifie aussi si c'est l'admin que l'on veut ou une page public
 */

$page = explode('.', strtolower($page));
$paramController = $paramMethode = false;

/**
* Quelle page est appelé (Il faut que j'améliore cette partie)
*/

if($page[1] === 'index')
{
	$controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
	$action = $page[1];
}
elseif($page[0] === 'admin')
{
	$controller = '\App\Controller\\'.ucfirst($page[0]).'\\' . ucfirst($page[1]) . 'Controller';
	$action = $page[2];
}

/*
 * On instancie le contrôleur
 */
$controller = new $controller($paramController);

if(method_exists($controller,$action)){ $controller->$action($paramMethode);  }else{ header('HTTP/1.0 404 Not Found'); die('Page Introuvable');  }
<?php
session_start();

if (!isset($_REQUEST['p'])) {
    header("Location:index.php?p=accueil");
    exit();
}
$page = $_REQUEST['p'];

define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("AJAX", ROOT . 'ajaxController' . DIRECTORY_SEPARATOR);
define("PUBLIC_FOLDER", ROOT . DIRECTORY_SEPARATOR);
define("CONTROLLER", ROOT . 'controller' . DIRECTORY_SEPARATOR);
define("USER_CONTROLLER", CONTROLLER . 'user' . DIRECTORY_SEPARATOR);
define("BDD", ROOT . 'BDD' . DIRECTORY_SEPARATOR);
define("VUES", ROOT . 'pages' . DIRECTORY_SEPARATOR);
define("VUES_ADMIN", VUES . 'admin' .DIRECTORY_SEPARATOR);
define("VUES_CLIENT", VUES . 'client' .DIRECTORY_SEPARATOR);
define("VUES_VISITEUR", VUES . 'visiteur' .DIRECTORY_SEPARATOR);

define("ELEMENTS", ROOT . 'elements' . DIRECTORY_SEPARATOR);
define("CARTE_PRODUIT", ELEMENTS . 'carteProduit' . DIRECTORY_SEPARATOR); 
define("FONCTIONS", ROOT . 'fonctions' . DIRECTORY_SEPARATOR);

define("CSS", 'CSS' . DIRECTORY_SEPARATOR);
define("FONT_AWESOME", CSS . 'fontawesome' . DIRECTORY_SEPARATOR);
define("JS", 'JS' . DIRECTORY_SEPARATOR);

require_once BDD . 'Commun.php';
require_once FONCTIONS . 'helper.php';

$pdo = new Commun;
$estConnecte = $pdo->estConnecte();
$monIdentifiant = $pdo->getMonIdentifiant();

if ($page === 'ajax') {
    require_once AJAX . 'index.php';
}

$role = NULL;
$credit = NULL;

ob_start();
$swapController = '';

if (!$estConnecte) {
    require_once CONTROLLER . 'visiteur.php';
} else {
    require_once USER_CONTROLLER . 'index.php';
}

if (!empty($swapController)) {
    require_once CONTROLLER . 'commun.php';
}

$pageContent = ob_get_clean();
require_once ELEMENTS . 'layout.php';
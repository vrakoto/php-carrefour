<?php
session_start();

if (!isset($_REQUEST['p'])) {
    header("Location:index.php?p=accueil");
    exit();
}
$page = $_REQUEST['p'];

define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("PUBLIC_FOLDER", ROOT . DIRECTORY_SEPARATOR);
define("CONTROLLER", ROOT . 'controller' . DIRECTORY_SEPARATOR);
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

ob_start();
if (!$estConnecte) {
    require_once CONTROLLER . 'visiteur.php';
} else {
    $identifiant = $_SESSION['identifiant'];
    $role = $pdo->getRole($identifiant);
    
    switch ($role) {
        case 'ADMIN':
            require_once CONTROLLER . 'admin.php';
        break;

        case 'CLIENT':
            require_once CONTROLLER . 'client.php';
        break;
    }
}
$pageContent = ob_get_clean();
require_once ELEMENTS . 'layout.php';
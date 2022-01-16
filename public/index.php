<?php
session_start();
$uri = $_SERVER['PATH_INFO'] ?? '/accueil';
$page = array_filter(explode("/", $uri));

$css = 'CSS' . DIRECTORY_SEPARATOR . 'main.css';
$js = 'JS' . DIRECTORY_SEPARATOR . 'main.js';

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fonctions' . DIRECTORY_SEPARATOR . 'helper.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'header.php';

switch ($page[1]) {
    case 'accueil':
        $title = "Accueil";
        require_once 'pages/accueil.php';
    break;

    case 'produit':
        require_once 'pages/produit.php';
    break;

    case 'panier':
        $title = "Panier";
        require_once 'pages/panier.php';
    break;

    case 'credit':
        $title = "Credit";
        require_once 'pages/credit.php';
    break;

    case 'historiqueAchats':
        $title = "Mes historiques d'achats";
        require_once 'pages/historiqueAchats.php';
    break;

    case 'notification':
        $title = "Mes notifications";
        require_once 'pages/notification.php';
    break;

    default:
        $title = "Erreur 404";
        require_once 'pages/404.php';
    break;
}
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'footer.php';
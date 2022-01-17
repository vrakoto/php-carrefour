<?php
switch ($page[1]) {
    case 'panier':
        require_once 'pages/panier.php';
    break;

    case 'credit':
        require_once 'pages/credit.php';
    break;

    case 'historiqueAchats':
        require_once 'pages/historiqueAchats.php';
    break;

    case 'notification':
        require_once 'pages/notification.php';
    break;

    case 'deconnexion':
        unset($_SESSION['id']);
        header("Location:accueil");
        exit();
    break;
}
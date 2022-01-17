<?php
switch ($page[1]) {
    case 'listeProduits':
        require_once 'pages/listeProduits.php';
    break;

    case 'ajouterProduit':
        require_once 'pages/ajouterProduit.php';
    break;

    case 'deconnexion':
        unset($_SESSION['id']);
        header("Location:accueil");
        exit();
    break;
}
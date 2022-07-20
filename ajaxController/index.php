<?php
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}

if ($estConnecte) {
    $role = $pdo->getRole($monIdentifiant);

    if ($role === 'CLIENT') {
        require_once AJAX . 'client' . DIRECTORY_SEPARATOR . 'index.php';
    }
}

// controller commun
switch ($action) {
    case 'rechercherProduit':
        $erreur = '';
        $laRecherche = htmlentities(strtolower($_POST['q']));

        $lesProduits = $pdo->getLesProduits();
        $nbProduits = 0;
        foreach ($lesProduits as $produit) {
            $nomProduit = htmlentities(strtolower($produit['ref']));

            if (str_contains($nomProduit, $laRecherche)) {
                $id = (int)$produit['id'];
                require CARTE_PRODUIT . 'variables.php';
                require ELEMENTS . 'carteProduit.php';
                $nbProduits++;
            }
        }

        if ($nbProduits <= 0) {
            $erreur = 'Aucun produit ne correspond à votre recherche.';
        }

        echo $erreur;
    break;

    case 'updateAccueil':
        $lesProduits = $pdo->getLesProduits();
        $lesProduitsPopulaires = $pdo->getLesProduitsPopulaires();
        $lesNouveauxProduits = $pdo->getLesNouveauxProduits();
        require_once AJAX_PAGES . 'accueil.php';
    break;
}
exit();
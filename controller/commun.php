<?php
if ($inCommonController === TRUE) {
    switch ($swapController) {
        case 'accueil':
            $title = "Accueil";
            // $lesProduits = $pdo->getLesProduits();
            // $lesProduitsPopulaires = $pdo->getLesProduitsPopulaires();
            // $lesNouveauxProduits = $pdo->getLesNouveauxProduits();
            require_once VUES . 'accueil.php';
        break;
    
        case 'produit':
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $title = 'Produit n°' . $id;
                
                try {
                    require_once CARTE_PRODUIT . 'variables.php';
                } catch (\Throwable $th) {
                    $textError = "Produit inexistant";
                    require_once VUES . '404.php';
                    exit();
                }
                require_once VUES . 'ficheProduit.php';
            }
        break;
    
        case 'avis':
            // Tous les avis d'un produit spécifique
            if (isset($_GET['id'])) {
                $idProduit = (int)$_GET['id'];
                $title = 'Avis produit n°' . $idProduit;
    
                $lesAvis = $pdo->getLesAvis($idProduit);
                if (count($lesAvis) <= 0) {
                    echo "<h4>Aucun avis sur ce produit</h4>";
                } else {
                    $noteMoyenne = (float)$pdo->getInfosAvis($idProduit)['noteMoyenne'];
                    $noteRestante = (int)(5-$noteMoyenne);
                    require_once VUES . 'avis.php';
                }
            }
        break;
    
        default:
            $title = "Projet Commerce - 404 Not Found";
            require_once VUES . '404.php';
        break;
    }
}
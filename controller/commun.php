<?php
if ($inCommonController === TRUE) {
    switch ($swapController) {
        case 'accueil':
            $lesProduits = $pdo->getLesProduits();
            require_once VUES . 'accueil.php';
        break;
    
        case 'produit':
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
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
            if (isset($_GET['id'])) {
                $idProduit = (int)$_GET['id'];
    
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
            require_once VUES . '404.php';
        break;
    }
}
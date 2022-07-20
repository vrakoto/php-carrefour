<?php
$inCommonController = FALSE;
if ($inUserController === TRUE) {
    define("CLIENT_MODEL", BDD . 'client' . DIRECTORY_SEPARATOR);
    require_once CLIENT_MODEL . 'Client.php';

    $client = new Client();
    $monSolde = $client->getMonSolde();
    $credit = $monSolde . ' &euro;';
    $nbProduitsPanier = count($client->getLesProduitsPanier());

    switch ($swapController) {
        case 'panier':
            $title = "Mon Panier";
            require_once VUES_CLIENT . 'panier.php';
        break;

        case 'credit':
            $title = "Mon crédit";
            require_once VUES_CLIENT . 'credit.php';
        break;

        case 'historiqueAchats':
            $title = "Mes historiques d'achats";
            $mesAchatsPanier = $client->getMesPaniersAchats();

            // Consulter détails panier après achat
            if (isset($_GET['id'])) {
                $idPanier = (int)$_GET['id'];
                $lesProduits = $client->getLesProduitsPanierAchetes($idPanier);
                $sums = [];
                require_once VUES_CLIENT . 'detailsAchat.php';
            } else {
                require_once VUES_CLIENT . 'historiqueAchats.php';
            }
        break;

        case 'donnerAvis':
            $title = "Donner avis sur un produit";
            $lesProduits = $client->produitAchetesSansAvis();
            require_once VUES_CLIENT . 'donnerAvis.php';
        break;

        case 'notification':
            $title = "Mes notifications produits";
            $mesNotifications = $client->getMesNotifications();
            $produitsArrives = $client->getLesProduitsArrives();
            require_once VUES_CLIENT . 'notification.php';
        break;

        default:
            $swapController = $page;
            $inCommonController = TRUE;
        break;
    }
}
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
            $lesProduits = $client->getLesProduitsPanier();
            $nbProduits = (int)count($lesProduits);
            require_once VUES_CLIENT . 'panier.php';
        break;

        case 'paiement':
            $sums = [];
            $lesProduits = $client->getLesProduitsPanier();
            $nbProduits = (int)count($lesProduits);
            foreach ($lesProduits as $produit) {
                $idProduit = (int)$produit['idProduit'];
                $prixUnit = (float)$pdo->getLeProduit($idProduit)['prixUnit'];
                $quantite = (int)$produit['quantite'];
                $sums[] = ($prixUnit*$quantite);
            }
            $total = array_sum($sums);
            $erreur = '';

            if ($total > $monSolde) {
                $erreur = "Solde insuffisant, veuillez recharger votre crédit.";
            }


            if (empty($erreur)) {
                try {
                    $client->payer();
                    $pdo->creerPanier($monIdentifiant);
                    $client->retirerCredit(array_sum($sums));
                    foreach ($lesProduits as $produit) {
                        $idProduit = (int)$produit['idProduit'];
                        $quantite = (int)$produit['quantite'];
                        $client->updateQuantiteProduit($idProduit, $quantite);
                    }
                    header("Location:index.php?p=panier");
                    exit();
                } catch (\Throwable $th) {
                    $erreur = "Erreur lors de l'achat";
                }
            }
        break;

        case 'credit':
            if (isset($_POST['montant'])) {
                $montant = (int)$_POST['montant'];

                if (!empty(trim($montant))) {
                    try {
                        $client->crediter($montant);
                        $success = "Votre solde a été crédité !";
                    } catch (\Throwable $th) {
                        $erreur = "Erreur 505, impossible de créditer l'utilisateur pour le moment.";
                    }
                } else {
                    $erreur = "Le montant est vide.";
                }
            }
            $solde = $client->getMonSolde();
            require_once VUES_CLIENT . 'credit.php';
        break;

        case 'historiqueAchats':
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
            $lesProduits = $client->listeProduitsAchetes();
            $titre = (int)count($lesProduits) > 0 ? "Sélectionnez un produit" : "Aucun produit disponible pour émettre un avis";
            require_once VUES_CLIENT . 'donnerAvis.php';
        break;

        case 'notification':
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
<?php
define("CLIENT_MODEL", BDD . 'client' . DIRECTORY_SEPARATOR);

require_once CLIENT_MODEL . 'Client.php';
$client = new Client($identifiant);
$monSolde = $client->getMonSolde();
$credit = $monSolde . ' &euro;';
$nbProduitsPanier = (int)count($client->getLesProduitsPanier());

switch ($page) {
    case 'accueil':
        $lesProduits = $pdo->getLesProduits();
        $cp_file = ELEMENTS . 'carteProduit' . DIRECTORY_SEPARATOR . 'cp_client.php';
        require_once VUES . 'accueil.php';
    break;

    // CLIENT
    case 'panier':
        $lesProduits = $client->getLesProduitsPanier();
        $nbProduits = (int)count($lesProduits);
        require_once VUES_CLIENT . 'panier.php';
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

        // Consulter détails panier
        if (isset($_GET['id'])) {
            $idPanier = (int)$_GET['id'];
            $lesProduits = $client->getLesProduitsPanierAchetes($idPanier);
            $sums = [];
            foreach ($lesProduits as $produit) {
                $id = (int)$produit['idProduit'];
                require CARTE_PRODUIT . 'variables.php';
                $quantiteUtilisateur = (int)$produit['quantite'];
                $totalProduit = ($quantiteUtilisateur*$prixUnit);
                $sums[] = ($quantiteUtilisateur*$prixUnit);
                require VUES_CLIENT . 'detailsAchat.php';
            }
            $total = floor((array_sum($sums)*100))/100;
            echo "<h4 class='mt-5'>Total TTC : " . $total . " &euro;</h4>";
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

    case 'deconnexion':
        unset($_SESSION['identifiant']);
        header("Location:index.php?action=deconnexion");
        exit();
    break;
}
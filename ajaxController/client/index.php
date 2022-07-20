<?php
define("CLIENT_MODEL", BDD . 'client' . DIRECTORY_SEPARATOR);
require_once CLIENT_MODEL . 'Client.php';
$client = new Client;
$monSolde = $client->getMonSolde();

switch ($action) {
    case 'updateAccueil':
        $lesProduits = $pdo->getLesProduits();
        $lesProduitsPopulaires = $pdo->getLesProduitsPopulaires();
        $lesNouveauxProduits = $pdo->getLesNouveauxProduits();
        require_once AJAX_PAGES . 'accueil.php';
    break;

    case 'crediter':
        $erreur = '';
        $prixMax = 15000;
        $montant = (float)$_POST['montant'];

        if (empty(trim($montant))) {
            $erreur = 'Le montant est vide.';
        }

        if ($montant > $prixMax) {
            $erreur = 'Le montant est beaucoup trop élevé.';
        }

        if ($montant <= 0) {
            $erreur = 'Le montant ne doit pas être inférieur ou égal à 0';
        }

        if ($monSolde >= $prixMax) {
            $erreur = 'Votre solde est déjà très élevé.';
        }

        if (empty($erreur)) {
            try {
                $client->crediter($montant);
            } catch (\Throwable $th) {
                $erreur = "Erreur interne, impossible de créditer pour le moment.";
            }
        }

        echo $erreur;
    break;

    case 'updateSolde':
        echo $monSolde . ' €';
    break;

    case 'updateProduit':
        $id = (int)$_POST['idProduit'];
        require_once CARTE_PRODUIT . 'variables.php';
        require_once ELEMENTS . 'carteProduit.php';
    break;

    case 'updateQuantite':
        $erreur = '';
        $idProduit = (int)$_POST['idProduit'];
        $prixUnit = (float)$_POST['prixUnit'];
        $quantiteUtilisateur = (int)$_POST['quantite'];
        $leProduit = $pdo->getLeProduit($idProduit); // produit provenant de la BDD

        if ($prixUnit !== (float)$leProduit['prixUnit']) {
            $erreur = "Le prix unitaire du produit est incorrect";
        }

        if ($quantiteUtilisateur <= 0) {
            $erreur = "La quantité est inférieur ou égale à 0";
        }

        if ($quantiteUtilisateur > (int)$leProduit['quantite']) {
            $erreur = "La quantité est supérieur à l'offre";
        }

        if (empty($erreur)) {
            try {
                $client->updateMaQuantite($idProduit, $quantiteUtilisateur);
            } catch (\Throwable $th) {
                $erreur = "Erreur rencontrée lors de la mise à jour de la quantité";
            }
        }
        echo $erreur;
    break;

    case 'updatePanier':
        $erreur = '';
        $lesProduits = (array)$client->getLesProduitsPanier();
        $nbProduits = (int)count($lesProduits);

        $sums = [];
        foreach ($lesProduits as $produit) {
            $idProduit = (int)$produit['idProduit'];
            $quantite = (int)$produit['quantite'];
            $prixUnit = $pdo->getLeProduit($idProduit)['prixUnit'];
            $sums[] = ($prixUnit*$quantite);
        }
        $total = array_sum($sums);

        $soldeSuffisant = ($monSolde >= $total);
        if (!$soldeSuffisant) {
            $erreur = "Votre solde est insuffisant pour effectuer ce paiement, veuillez le recharger.";
        }
        require_once AJAX_PAGES . 'panier.php';
    break;

    case 'paiement':
        $erreur = '';
        $sums = [];
        $lesProduits = $client->getLesProduitsPanier();
        foreach ($lesProduits as $produit) {
            $idProduit = (int)$produit['idProduit'];
            $prixUnit = (float)$pdo->getLeProduit($idProduit)['prixUnit'];
            $quantite = (int)$produit['quantite'];
            $sums[] = ($prixUnit*$quantite);
        }
        $total = array_sum($sums);

        try {
            $client->payer();
            $pdo->creerPanier($monIdentifiant);
            $client->retirerCredit($total);
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
        require_once VUES_CLIENT . 'panier.php';
    break;


    case 'notifierProduit':
        $erreur = '';
        $idProduit = (int)$_POST['idProduit'];
        try {
            $client->notifierProduit($idProduit);
        } catch (\Throwable $th) {
            $erreur = "Erreur général notification";
            if ($th->getCode() === "23000") {
                $erreur = "Le produit a déjà été notifié.";
            }
        }
        echo $erreur;
    break;

    case 'retirerNotification':
        $erreur = '';
        $idProduit = (int)$_POST['idProduit'];
        try {
            $client->retirerNotification($idProduit);
        } catch (\Throwable $th) {
            $erreur = "Erreur général notification";
        }
        echo $erreur;
    break;

    case 'ajouterProduitPanier':
        $erreur = '';
        $idProduit = (int)$_POST['idProduit'];
        $quantite = (int)$_POST['quantite'];

        if ($quantite <= 0) {
            $erreur = "La quantité ne doit pas être inférieur ou égale à 0";
        }

        if ($quantite > $pdo->getLeProduit($idProduit)['quantite']) {
            $erreur = "La quantité demandée est supérieure à l'offre";
        }

        if (empty($erreur)) {
            try {
                $idPanier = $client->getMonPanier();
                $client->ajouterProduitPanier($idPanier, $idProduit, $quantite);
            } catch (\Throwable $th) {
                $erreur = "Erreur interne, le produit n'est sûrement plus disponible";
                if ($th->getCode() === "23000") {
                    $erreur = "Le produit a déjà été ajouté dans le panier.";
                }
            }
        }
        echo $erreur;
    break;

    case 'supprimerProduitPanier':
        $erreur = '';
        $idProduit = (int)$_POST['idProduit'];
        try {
            $client->supprimerProduitPanier($idProduit);
        } catch (\Throwable $th) {
            $erreur = "Erreur lors de la suppresion du produit dans votre panier";
        }
        echo $erreur;
    break;

    case 'listeProduitSansAvis':
        $lesProduits = $client->produitAchetesSansAvis();
        require_once VUES_CLIENT . 'donnerAvis.php';
    break;

    case 'envoyerAvis':
        $erreur = '';
        $idProduit = (int)$_POST['idProduit'];
        $commentaire = htmlentities($_POST['commentaire']);
        $note = (int)$_POST['note'];

        if (empty($pdo->getLeProduit($idProduit)['id'])) {
            $erreur = "Produit inexistant";
        }

        if ($note <= 0 || $note > 5) {
            $erreur = "La note ne doit pas être inférieur ou égal à 0 ni supérieur à 5";
        }

        if (empty($erreur)) {
            try {
                $client->envoyerAvis($idProduit, $commentaire, $note);
            } catch (\Throwable $th) {
                $erreur = "Erreur général";
            }
        }
        echo $erreur;
    break;
}
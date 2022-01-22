<?php
$action = $_REQUEST['action'];
switch ($action) {

    case 'crediter':
        $erreur = '';
        $montant = (float)$_POST['montant'];

        if ($montant <= 0) {
            $erreur = "Le montant ne doit pas être inférieur ou égal à 0";
        }

        if ($montant > 50000) {
            $erreur = "Le montant ne doit pas être supérieur à 50.000";
        }

        if (empty($erreur)) {
            try {
                $client->crediter($montant);
            } catch (\Throwable $th) {
                $erreur = "Erreur général";
            }
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
            $erreur = "La quantité demandée est supérieur à l'offre";
        }

        if (empty($erreur)) {
            try {
                $idPanier = $client->getMonPanier()['id'];
                $client->ajouterProduitPanier($idPanier, $idProduit, $quantite);
            } catch (\Throwable $th) {
                $erreur = "Erreur général";
            }
        }
        echo $erreur;
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

    case 'updateTotal':
        $idPanier = (int)$client->getMonPanier()['id'];
        $lesProduits = (array)$client->getMesProduits();

        (float)$sums = [];
        foreach ($lesProduits as $produit) {
            $idProduit = (int)$produit['idProduit'];
            $quantite = (int)$produit['quantite'];
            $prixUnit = $pdo->getLeProduit($idProduit)['prixUnit'];
            $sums[] = ($prixUnit*$quantite);
        }
        echo array_sum($sums);
    break;

    case 'payer':
        $erreur = '';
        $sums = [];
        $lesProduits = (array)$client->getMesProduits();
        foreach ($lesProduits as $produit) {
            $idProduit = (int)$produit['idProduit'];
            $prixUnit = (float)$pdo->getLeProduit($idProduit)['prixUnit'];
            $quantite = (int)$produit['quantite'];
            $client->updateQuantiteProduit($idProduit, $quantite);
            $sums[] = ($prixUnit*$quantite);
        }
        $total = array_sum($sums);

        if ($total > $monSolde) {
            $erreur = "Solde insuffisant, veuillez recharger votre crédit.";
        }

        if (empty($erreur)) {
            try {
                $client->payer();
                $pdo->creerPanier($sid);
                $client->retirerCredit(array_sum($sums));
            } catch (\Throwable $th) {
                $erreur = "Erreur lors de l'achat";
            }
        }
        echo $erreur;
    break;
}
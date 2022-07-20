<?php
$leProduit = $pdo->getLeProduit($id);
$imagePrincipale = htmlentities($leProduit['image']);
$idCategorie = (int)$leProduit['idCategorie'];
$categorie = (string)$pdo->getLaCategorie($idCategorie);
$ref = htmlentities($leProduit['ref']);
$quantite = (int)$leProduit['quantite'];
$produitDisponible = ($quantite > 0);
$opacity = "";
if ($role === 'CLIENT') {
    $produitNotifier = $client->estNotifier($id);
    $produitDansPanier = $client->produitExistantPanier($id);
}
$prixUnit = $leProduit['prixUnit'];
$description = htmlentities($leProduit['description']);
$noteMoyenne = $pdo->getInfosAvis($id)['noteMoyenne'];
$nbAvis = $pdo->getInfosAvis($id)['nbAvis'];

$phraseAvis = $nbAvis > 0 ? $noteMoyenne . '/5' . ' ('. $nbAvis . ' avis)' : 'Aucun avis';
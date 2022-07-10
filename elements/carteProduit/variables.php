<?php
$leProduit = (array)$pdo->getLeProduit($id);
$imagePrincipale = htmlentities($leProduit['image']);
$idCategorie = (int)$leProduit['idCategorie'];
$categorie = (string)$pdo->getLaCategorie($idCategorie);
$ref = htmlentities($leProduit['ref']);
$quantite = (int)$leProduit['quantite'];
$produitDisponible = ($quantite > 0);
$opacity = "";
if (isset($role) && $role === 'CLIENT') {
    $produitNotifier = (bool)$client->estNotifier($id);
}
$prixUnit = (float)$leProduit['prixUnit'];
$description = htmlentities($leProduit['description']);
$noteMoyenne = (float)$pdo->getInfosAvis($id)['noteMoyenne'];
$nbAvis = (int)$pdo->getInfosAvis($id)['nbAvis'];

$phraseAvis = $nbAvis > 0 ? $noteMoyenne . '/5' . '('. $nbAvis . 'avis)' : 'Aucun avis';
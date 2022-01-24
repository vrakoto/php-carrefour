<?php
$leProduit = (array)$pdo->getLeProduit($id);
$imagePrincipale = htmlentities($leProduit['image']);
$idCategorie = (int)$leProduit['idCategorie'];
$categorie = (string)$pdo->getLaCategorie($idCategorie);
$ref = htmlentities($leProduit['ref']);
$quantite = (int)$leProduit['quantite'];
$produitDisponible = ($quantite > 0);
$opacity = "";
if ($role === 'CLIENT') {
    $produitNotifier = (bool)$client->estNotifier($id);
}
$prixUnit = (float)$leProduit['prixUnit'];
$description = htmlentities($leProduit['description']);
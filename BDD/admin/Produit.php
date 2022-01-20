<?php

class Produit extends Commun {
    private $image;
    private $categorie;
    private $ref;
    private $quantite;
    private $prixUnit;
    private $description;

    function __construct(int $categorie, string $image, string $ref, string $quantite, string $prixUnit, string $description)
    {
        parent::__construct(); // Hériter le PDO
        $this->categorie = $categorie;
        $this->image = $image;
        $this->ref = $ref;
        $this->quantite = $quantite;
        $this->prixUnit = $prixUnit;
        $this->description = $description;
    }

    function verifierProduit(): bool
    {
        return empty($this->getErreurs());
    }

    function getErreurs(): array
    {
        $erreurs = [];

        if ($this->categorie === 0) {
            $erreurs['categorie'] = "Categorie incorrect";
        }

        if (strlen($this->ref) < 2) {
            $erreurs['ref'] = "Nom du produit trop court";
        }

        if ($this->quantite <= 0) {
            $erreurs['quantite'] = "Quantité inférieur ou égal à 0";
        }

        if ($this->prixUnit <= 0) {
            $erreurs['prixUnit'] = "Prix Unitaire inférieur ou égal à 0";
        }

        if (strlen($this->description) < 2) {
            $erreurs['description'] = "Description trop courte";
        }

        return $erreurs;
    }

    function ajouterProduit(): bool
    {
        $req = "INSERT INTO produit (idCategorie, image, ref, quantite, prixUnit, description) VALUES (:idCategorie, :image, :ref, :quantite, :prixUnit, :description)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idCategorie' => $this->categorie,
            'image' => $this->image,
            'ref' => $this->ref,
            'quantite' => $this->quantite,
            'prixUnit' => $this->prixUnit,
            'description' => $this->description
        ]);
    }
}
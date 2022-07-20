<?php
class Admin extends Commun {
    function __construct()
    {
        parent::__construct(); // Hériter le PDO
    }

    function supprimerProduit(int $id): bool
    {
        $req = "DELETE FROM produit WHERE id = :id";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'id' => $id
        ]);
    }

    function ajouterCategorie(string $ref): bool
    {
        $req = "INSERT INTO categorie (ref) VALUES (:ref)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'ref' => $ref
        ]);
    }

    function supprimerCategorie(int $id): bool
    {
        $req = "DELETE FROM categorie WHERE id = :id";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'id' => $id
        ]);
    }

    function modifierProduit(int $id, string $image, string $idCategorie, string $ref, float $prixUnit, int $quantite, string $description): bool
    {
        $req = "UPDATE produit SET image = :image, idCategorie = :idCategorie, ref = :ref, prixUnit = :prixUnit, quantite = :quantite, description = :description
                WHERE id = :id";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'id' => $id,
            'image' => $image,
            'idCategorie' => $idCategorie,
            'ref' => $ref,
            'prixUnit' => $prixUnit,
            'quantite' => $quantite,
            'description' => $description
        ]);
    }
}
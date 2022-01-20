<?php

class Commun {
    protected $pdo;

    function __construct()
    {
        $this->pdo = new PDO('sqlite:../BDD/commerce.db', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function verifierAuth(string $id, string $mdp): bool
    {
        $req = "SELECT * FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);

        return !empty($p->fetch()) && password_verify($mdp, $this->getUtilisateur($id)['mdp']);
    }

    function getUtilisateur($id): array
    {
        $req = "SELECT * FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);

        return $p->fetch();
    }

    function getRole($id): string
    {
        $req = "SELECT role FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);
        return $p->fetch()['role'];
    }

    function getLesProduits(): array
    {
        $req = "SELECT * FROM produit ORDER by dateAjout DESC";
        $p = $this->pdo->query($req);
        return $p->fetchAll();
    }

    function getLesCategories(): array
    {
        $req = "SELECT * FROM categorie ORDER by id";
        $p = $this->pdo->query($req);
        return $p->fetchAll();
    }

    function getLaCategorie(string $idCategorie): string
    {
        $req = "SELECT categorie.ref as categorieRef FROM categorie
                JOIN produit on categorie.id = produit.idCategorie
                WHERE produit.idCategorie = :idCategorie";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idCategorie' => $idCategorie
        ]);
        return $p->fetch()['categorieRef'] ?? '';
    }

    function getLesProduitsCategorie(int $idCategorie): array 
    {
        $req = "SELECT * FROM produit
                JOIN categorie on categorie.id = produit.idCategorie
                WHERE produit.idCategorie = :idCategorie";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idCategorie' => $idCategorie
        ]);
        return $p->fetchAll();
    }

    function getLeProduit(string $id): array
    {
        $req = "SELECT * FROM produit WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);
        return $p->fetch();
    }

    
}
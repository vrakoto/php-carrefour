<?php

class Commun {
    protected $pdo;

    function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=commerce;host=localhost', 'root', null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function estConnecte(): bool
    {
        return isset($_SESSION['identifiant']);
    }

    function verifierAuth(string $identifiant, string $mdp): bool
    {
        $req = "SELECT * FROM utilisateur WHERE identifiant = :identifiant";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'identifiant' => $identifiant
        ]);

        return !empty($p->fetch()) && password_verify($mdp, $this->getUtilisateur($identifiant)['mdp']);
    }

    function creerPanier(string $identifiant_utilisateur): bool
    {
        $req = "INSERT INTO panier (identifiant_utilisateur, statut) VALUES (:identifiant_utilisateur, 'EN COURS')";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'identifiant_utilisateur' => $identifiant_utilisateur,
        ]);
    }

    function getUtilisateur(string $identifiant): array
    {
        $req = "SELECT * FROM utilisateur WHERE identifiant = :identifiant";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'identifiant' => $identifiant
        ]);

        return $p->fetch();
    }

    function getRole(string $identifiant): string
    {
        $req = "SELECT role FROM utilisateur WHERE identifiant = :identifiant";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'identifiant' => $identifiant
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

    function getLeProduit(int $idProduit): array
    {
        $req = "SELECT * FROM produit WHERE id = :idProduit";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idProduit' => $idProduit
        ]);
        return $p->fetch();
    }

    function getLesAvis(int $idProduit): array
    {
        $req = "SELECT * FROM avis WHERE idProduit = :idProduit";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idProduit' => $idProduit
        ]);
        return $p->fetchAll();
    }

    function getInfosAvis(int $idProduit): array
    {
        $req = "SELECT COUNT(*) as nbAvis, ROUND(SUM(note)/COUNT(*)) as noteMoyenne
                FROM avis WHERE idProduit = :idProduit";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idProduit' => $idProduit
        ]);
        return $p->fetch();
    }
}
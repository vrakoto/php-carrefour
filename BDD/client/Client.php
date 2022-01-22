<?php

class Client extends Commun {
    function __construct()
    {
        parent::__construct(); // Hériter le PDO
    }

    function getMonSolde(): float
    {
        $req = "SELECT solde FROM utilisateur WHERE id = :utilisateurActuel";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);

        return $p->fetch()['solde'];
    }

    function crediter(float $montant): bool
    {
        $req = "UPDATE utilisateur SET solde = (solde + :credit) WHERE id = :utilisateurActuel";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'credit' => $montant,
            'utilisateurActuel' => $_SESSION['id']
        ]);
    }

    function getMonPanier(): array
    {
        $req = "SELECT * FROM panier
                WHERE idUtilisateur = :utilisateurActuel AND statut = 'EN COURS'";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);

        return $p->fetch();
    }

    // Dans mon panier
    function getMesProduits(): array
    {
        $req = "SELECT * FROM produit_panier
                WHERE idPanier =
                    (SELECT id FROM panier
                    WHERE idUtilisateur = :utilisateurActuel
                    AND statut = 'EN COURS')";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);
        
        return $p->fetchAll();
    }

    function ajouterProduitPanier(int $idPanier, int $idProduit, int $quantite): bool
    {
        $req = "INSERT INTO produit_panier (idPanier, idProduit, quantite) VALUES (:idPanier, :idProduit, :quantite)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idPanier' => $idPanier,
            'idProduit' => $idProduit,
            'quantite' => $quantite
        ]);
    }

    function supprimerProduitPanier(int $idProduit): bool
    {
        $req = "DELETE FROM produit_panier WHERE idPanier =
                    (SELECT id FROM panier WHERE idUtilisateur = :utilisateurActuel AND statut = 'EN COURS')
                AND idProduit = :idProduit";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'utilisateurActuel' => $_SESSION['id'],
            'idProduit' => $idProduit
        ]);
    }

    function produitExistantPanier(int $idProduit): bool
    {
        $req = "SELECT idProduit FROM produit_panier
                WHERE idProduit = :idProduit
                AND idPanier = (SELECT id FROM panier WHERE idUtilisateur = :utilisateurActuel AND statut = 'EN COURS')";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idProduit' => $idProduit,
            'utilisateurActuel' => $_SESSION['id']
        ]);
        return !empty($p->fetch());
    }

    function payer(): bool
    {
        $req = "UPDATE panier SET statut = 'VENDU'
                WHERE statut = 'EN COURS'
                AND idUtilisateur = :utilisateurActuel";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);
        return !empty($p->fetch());
    }

    function updateMaQuantite(int $idProduit, int $quantite): bool
    {
        $req = "UPDATE produit_panier SET quantite = :quantite WHERE idPanier = :idPanier AND idProduit = :idProduit";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'quantite' => $quantite,
            'idPanier' => (int)$this->getMonPanier()['id'],
            'idProduit' => $idProduit
        ]);
    }

    function updateQuantiteProduit(int $idProduit, int $quantite): bool
    {
        $req = "UPDATE produit SET quantite = (quantite - :quantite) WHERE id = :idProduit";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'quantite' => $quantite,
            'idProduit' => $idProduit
        ]);
    }

    function retirerCredit(float $total): bool
    {
        $req = "UPDATE utilisateur SET solde = (solde - :total) WHERE id = :utilisateurActuel";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'total' => $total,
            'utilisateurActuel' => $_SESSION['id']
        ]);
    }
}
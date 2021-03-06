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

    function getMesPaniersAchats(): array
    {
        $req = "SELECT id, date FROM panier
                WHERE idUtilisateur = :utilisateurActuel
                AND statut = 'VENDU'
                ORDER BY id DESC";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);
        
        return $p->fetchAll();
    }

    function getLesProduitsPanier(): array
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

    function getLesProduitsPanierAchetes(int $idPanier): array
    {
        $req = "SELECT * FROM produit_panier
                WHERE idPanier = (SELECT id FROM panier
                                WHERE id = :idPanier
                                AND idUtilisateur = :utilisateurActuel
                                AND statut = 'VENDU')";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPanier' => $idPanier,
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
        $req = "UPDATE panier SET statut = 'VENDU', date = date('now')
                WHERE idUtilisateur = :utilisateurActuel
                AND statut = 'EN COURS'";
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

    
    function listeProduitsAchetes(): array
    {
        $req = "SELECT idProduit FROM produit_panier
                WHERE idPanier IN
                    (SELECT id FROM panier
                    WHERE idUtilisateur = :utilisateurActuel
                    AND statut = 'VENDU')
                AND NOT idProduit IN
                    (SELECT idProduit FROM avis
                    WHERE idUtilisateur = :utilisateurActuel)
                GROUP BY idProduit";

        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);
        
        return $p->fetchAll();
    }

    function notifierProduit(int $idProduit): bool
    {
        $req = "INSERT INTO notification (idProduit, idUtilisateur) VALUES (:idProduit, :utilisateurActuel)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idProduit' => $idProduit,
            'utilisateurActuel' => $_SESSION['id']
        ]);
    }

    function retirerNotification(int $idProduit): bool
    {
        $req = "DELETE FROM notification WHERE idProduit = :idProduit AND idUtilisateur = :utilisateurActuel";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idProduit' => $idProduit,
            'utilisateurActuel' => $_SESSION['id']
        ]);
    }

    function estNotifier(int $idProduit): bool
    {
        $req = "SELECT idProduit FROM notification
                WHERE idProduit = :idProduit
                AND idUtilisateur = :utilisateurActuel";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idProduit' => $idProduit,
            'utilisateurActuel' => $_SESSION['id']
        ]);

        return !empty($p->fetch());
    }

    function getMesNotifications(): array
    {
        $req = "SELECT * FROM notification
                WHERE idUtilisateur = :utilisateurActuel
                AND idProduit IN (SELECT id FROM produit WHERE quantite = 0)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);

        return $p->fetchAll();
    }

    function getLesProduitsArrives(): array
    {
        $req = "SELECT * FROM notification
                JOIN produit on produit.id = notification.idProduit
                WHERE idUtilisateur = :utilisateurActuel
                AND idProduit IN (SELECT id FROM produit WHERE quantite > 0)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'utilisateurActuel' => $_SESSION['id']
        ]);

        return $p->fetchAll();
    }


    /* function getLes(int $idProduit): array
    {

    } */

    
    function envoyerAvis(int $idProduit, $commentaire, $note): bool
    {
        $req = "INSERT INTO avis (idProduit, idUtilisateur, commentaire, note) VALUES (:idProduit, :utilisateurActuel, :commentaire, :note)";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'idProduit' => $idProduit,
            'utilisateurActuel' => $_SESSION['id'],
            'commentaire' => $commentaire,
            'note' => $note
        ]);
    }
}
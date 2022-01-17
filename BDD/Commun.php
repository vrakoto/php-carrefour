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
}
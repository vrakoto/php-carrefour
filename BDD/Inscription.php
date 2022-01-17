<?php

class Inscription extends Commun {
    private $id;
    private $ville;
    private $mdp;
    private $mdp_confirm;

    function __construct(string $id, string $ville, string $mdp, string $mdp_confirm)
    {
        parent::__construct(); // Hériter le PDO
        $this->id = $id;
        $this->ville = $ville;
        $this->mdp = $mdp;
        $this->mdp_confirm = $mdp_confirm;
    }

    function identifiantExistant(string $id): bool
    {
        $req = "SELECT id FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);

        return !empty($p->fetch());
    }

    function verifierInscription(): bool
    {
        return empty($this->getErreurs());
    }

    function getErreurs(): array
    {
        $erreurs = [];
        if (strlen($this->id) < 2) {
            $erreurs['id'] = "Identifiant trop court";
        }

        if ($this->identifiantExistant($this->id)) {
            $erreurs['id'] = "Identifiant déjà prit";
        }
        
        if (strlen($this->ville) < 2) {
            $erreurs['ville'] = "Ville trop courte";
        }

        if (strlen($this->mdp) < 2) {
            $erreurs['mdp'] = "Mot de passe trop court";
        }

        if ($this->mdp !== $this->mdp_confirm) {
            $erreurs['mdp'] = "Les mots de passe ne correspondent pas";
        }

        return $erreurs;
    }

    function inscrire(): bool
    {
        $req = "INSERT INTO utilisateur (id, ville, mdp, role) VALUES (:id, :ville, :mdp, 'CLIENT')";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'id' => $this->id,
            'ville' => $this->ville,
            'mdp' => password_hash($this->mdp,  PASSWORD_DEFAULT, ['cost' => 12])
        ]);
    }
}
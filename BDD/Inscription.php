<?php

class Inscription extends Commun {
    private $identifiant;
    private $ville;
    private $mdp;
    private $mdp_confirm;

    function __construct(string $identifiant, string $ville, string $mdp, string $mdp_confirm)
    {
        parent::__construct(); // Hériter le PDO
        $this->identifiant = $identifiant;
        $this->ville = $ville;
        $this->mdp = $mdp;
        $this->mdp_confirm = $mdp_confirm;
    }

    function identifiantExistant(string $identifiant): bool
    {
        $req = "SELECT identifiant FROM utilisateur WHERE identifiant = :identifiant";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'identifiant' => $identifiant
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
        if (strlen($this->identifiant) < 2) {
            $erreurs['identifiant'] = "Identifiant trop court";
        }

        if ($this->identifiantExistant($this->identifiant)) {
            $erreurs['identifiant'] = "Identifiant déjà prit";
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
        $req = "INSERT INTO utilisateur (identifiant, ville, mdp, role) VALUES (:identifiant, :ville, :mdp, 'CLIENT')";
        $p = $this->pdo->prepare($req);
        return $p->execute([
            'identifiant' => $this->identifiant,
            'ville' => $this->ville,
            'mdp' => password_hash($this->mdp,  PASSWORD_DEFAULT, ['cost' => 12])
        ]);
    }
}
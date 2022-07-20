<?php
$inCommonController = FALSE;
switch ($page) {
    case 'connexion':
        $title = "Page connexion";
        if (isset($_POST['identifiant'], $_POST['mdp'])) {
            $identifiant = htmlentities($_POST['identifiant']);
            $mdp = htmlentities($_POST['mdp']);

            if ($pdo->verifierAuth($identifiant, $mdp)) {
                $_SESSION['identifiant'] = $identifiant;
                header("Location:index.php?p=accueil");
                exit();
            } else {
                $erreur = "Authentification incorrecte";
            }
        }
        require_once VUES_VISITEUR . 'connexion.php';
    break;

    case 'inscription':
        $title = "Page inscription";
        
        require_once BDD . 'Inscription.php';
        if (isset($_POST['identifiant'], $_POST['ville'], $_POST['mdp'], $_POST['mdp_confirm'])) {
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'BDD' . DIRECTORY_SEPARATOR . 'Inscription.php';
            $identifiant = htmlentities($_POST['identifiant']);
            $ville = htmlentities($_POST['ville']);
            $mdp = htmlentities($_POST['mdp']);
            $mdp_confirm = htmlentities($_POST['mdp_confirm']);

            $inscription = new Inscription($identifiant, $ville, $mdp, $mdp_confirm);
            if (!$inscription->verifierInscription()) {
                $erreur = "Le formulaire est incorrecte :";
                $erreurs = $inscription->getErreurs();
            } else {
                $inscription->inscrire();
                $pdo->creerPanier($identifiant);
                header("Location:index.php?p=connexion");
                exit();
            }
        }
        require_once VUES_VISITEUR . 'inscription.php';
    break;

    default:
        $swapController = $page;
        $inCommonController = TRUE;
    break;
}
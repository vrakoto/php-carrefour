<?php
$role = NULL;
$credit = NULL;

switch ($page) {
    case 'accueil':
        $lesProduits = $pdo->getLesProduits();
        $cp_file = ELEMENTS . 'carteProduit' . DIRECTORY_SEPARATOR . 'cp_visiteur.php';
        require_once VUES . 'accueil.php';
    break;

    case 'connexion':
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

    case 'produit':
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            
            try {
                require_once CARTE_PRODUIT . 'variables.php';
            } catch (\Throwable $th) {
                $textError = "Produit inexistant";
                require_once VUES . '404.php';
                exit();
            }
            require_once VUES . 'ficheProduit.php';
        }
    break;

    case 'avis':
        if (isset($_GET['id'])) {
            $idProduit = (int)$_GET['id'];

            $lesAvis = $pdo->getLesAvis($idProduit);
            if (count($lesAvis) <= 0) {
                echo "<h4>Aucun avis sur ce produit</h4>";
            } else {
                $noteMoyenne = (float)$pdo->getInfosAvis($idProduit)['noteMoyenne'];
                $noteRestante = (int)(5-$noteMoyenne);
                require_once VUES . 'avis.php';
            }
        }
    break;
}
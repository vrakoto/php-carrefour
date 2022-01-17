<?php
session_start();
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'BDD' . DIRECTORY_SEPARATOR . 'Commun.php';
$pdo = new Commun;
$sid = $_SESSION['id'] ?? '';
if (!empty($sid)) {
    $role = $pdo->getRole($sid);
}

$uri = $_SERVER['PATH_INFO'] ?? '/accueil';
$page = array_filter(explode("/", $uri));

$css = 'CSS' . DIRECTORY_SEPARATOR . 'main.css';
$js = 'JS' . DIRECTORY_SEPARATOR . 'main.js';

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fonctions' . DIRECTORY_SEPARATOR . 'helper.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'header.php';

if (!empty($sid)) {
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . 'index.php';
}

switch ($page[1]) {
    case 'accueil':
        require_once 'pages/accueil.php';
    break;

    case 'connexion':
        if ($sid) {
            header("Location:accueil");
            exit();
        }
        if (isset($_POST['id'], $_POST['mdp'])) {
            $id = htmlentities($_POST['id']);
            $mdp = htmlentities($_POST['mdp']);

            if ($pdo->verifierAuth($id, $mdp)) {
                $_SESSION['id'] = $id;
                header("Location:accueil");
                exit();
            } else {
                $erreur = "Authentification incorrecte";
            }
        }
        require_once 'pages/connexion.php';
    break;

    case 'inscription':
        if ($sid) {
            header("Location:accueil");
            exit();
        }
        if (isset($_POST['id'], $_POST['ville'], $_POST['mdp'], $_POST['mdp_confirm'])) {
            require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'BDD' . DIRECTORY_SEPARATOR . 'Inscription.php';
            $id = htmlentities($_POST['id']);
            $ville = htmlentities($_POST['ville']);
            $mdp = htmlentities($_POST['mdp']);
            $mdp_confirm = htmlentities($_POST['mdp_confirm']);

            $inscription = new Inscription($id, $ville, $mdp, $mdp_confirm);
            if (!$inscription->verifierInscription()) {
                $erreur = "Formulaire d'inscription incorrecte :";
                $erreurs = $inscription->getErreurs();
            } else {
                $inscription->inscrire();
                header("Location:connexion");
                exit();
            }
        }
        require_once 'pages/inscription.php';
    break;
    
    default:
        if (isset($role)) {
            if ($role === 'CLIENT') {
                require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'roles' . DIRECTORY_SEPARATOR . 'client' . DIRECTORY_SEPARATOR . 'index.php';
            } else if ($role === 'ADMIN') {
                require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'roles' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'index.php';
            }
        } else {
            require_once 'pages/404.php';
        }
    break;
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'footer.php';
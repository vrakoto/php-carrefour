<?php
session_start();
$css = 'CSS' . DIRECTORY_SEPARATOR . 'main.css';
$js = 'JS' . DIRECTORY_SEPARATOR . 'main.js';

if (!isset($_REQUEST['p'])) {
    header("Location:index.php?p=accueil");
    exit();
}
$page = $_REQUEST['p'];

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$bdd = $root . 'BDD' . DIRECTORY_SEPARATOR;
$pages = $root . 'pages' . DIRECTORY_SEPARATOR;
$pagesAdmin = $pages . 'admin' . DIRECTORY_SEPARATOR;
$pagesClient = $pages . 'client' . DIRECTORY_SEPARATOR;

$elements = $root . 'elements' . DIRECTORY_SEPARATOR;
$fonctions = $root . 'fonctions' . DIRECTORY_SEPARATOR;

require_once $root . 'BDD' . DIRECTORY_SEPARATOR . 'Commun.php';
$pdo = new Commun;

// Gére les différents accès
$access = [
    "accueil",
    "produit",
    "connexion",
    "inscription",
    "produit"
];

$sid = $_SESSION['id'] ?? '';
$role = null;
$credit = null;
$nbProduitsPanier = 0;

if (!empty($sid)) {
    $access = ["accueil", "produit", "deconnexion"];
    $role = $pdo->getRole($sid);

    switch ($role) {
        case 'CLIENT':
            array_push($access, "panier", "credit", "historiqueAchats", "notification");
            require_once $bdd . 'client' . DIRECTORY_SEPARATOR . 'Client.php';
            $client = new Client($sid);
            $monSolde = $client->getMonSolde();
            $credit = $monSolde . ' &euro;';
            $nbProduitsPanier = (int)count($client->getMesProduits());
            if ($page === 'ajax') {
                require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ajaxController' . DIRECTORY_SEPARATOR . 'client' . DIRECTORY_SEPARATOR . 'index.php';
                exit();
            }
        break;

        case 'ADMIN':
            array_push($access, "listeProduits", "modifierProduit", "supprimerProduit", "listeCategories", "supprimerCategorie", "parametreAdmin");
            require_once $bdd . 'admin' . DIRECTORY_SEPARATOR . 'Admin.php';
            require_once $bdd . 'admin' . DIRECTORY_SEPARATOR . 'Produit.php';
            $admin = new Admin($sid);
        break;
    }
}

require_once $fonctions . 'helper.php';
require_once $elements . 'header.php';

if (!in_array($page, $access)) {
    $page = 404;
}

switch ($page) {
    case 'accueil':
        $lesProduits = $pdo->getLesProduits();
        require_once $pages . 'accueil.php';
    break;

    case 'connexion':
        if (isset($_POST['id'], $_POST['mdp'])) {
            $id = htmlentities($_POST['id']);
            $mdp = htmlentities($_POST['mdp']);

            if ($pdo->verifierAuth($id, $mdp)) {
                $_SESSION['id'] = $id;
                header("Location:index.php?p=accueil");
                exit();
            } else {
                $erreur = "Authentification incorrecte";
            }
        }
        require_once $pages . 'connexion.php';
    break;

    case 'inscription':
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
                $pdo->creerPanier($id);
                header("Location:index.php?p=connexion");
                exit();
            }
        }
        require_once $pages . 'inscription.php';
    break;

    case 'produit':
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            
            try {
                require_once $elements . 'varProduit.php';
            } catch (\Throwable $th) {
                $textError = "Produit inexistant";
                require_once $pages . '404.php';
                exit();
            }
            require_once $pages . 'ficheProduit.php';
        }
    break;

    // ADMIN
    case 'listeProduits':
        $lesCategories = $pdo->getLesCategories(); // catégories pour ajouter un produit
        $lesProduits = $pdo->getLesProduits();

        // Ajouter produit
        if (isset($_POST['image'], $_POST['categorie'], $_POST['ref'], $_POST['quantite'], $_POST['prixUnit'], $_POST['description'])) {
            $categorie = (int)$_POST['categorie'];
            $image = htmlentities($_POST['image']);
            $ref = htmlentities($_POST['ref']);
            $quantite = (int)$_POST['quantite'];
            $prixUnit = (float)$_POST['prixUnit'];
            $description = htmlentities($_POST['description']);

            $produit = new Produit($categorie, $image, $ref, $quantite, $prixUnit, $description);
            
            try {
                if (!$produit->verifierProduit()) {
                    $erreur = "Le produit est invalide";
                    $erreurs = $produit->getErreurs();
                } else {
                    $produit->ajouterProduit();
                    $success = "Produit ajouté !";
                    header("Location:index.php?p=listeProduits");
                    exit();
                }
            } catch (\Throwable $th) {
                $erreur = $th->getMessage();
            }
        }
        require_once $pagesAdmin . 'listeProduits.php';
    break;

    case 'modifierProduit':
        // Consulter la modification
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            try {
                $lesCategories = $pdo->getLesCategories();
                require_once $elements . 'varProduit.php';
            } catch (\Throwable $th) {
                $erreur = "Erreur général";
            }

            // Modifier le produit
            if (isset($_POST['image'], $_POST['idCategorie'], $_POST['ref'], $_POST['quantite'], $_POST['prixUnit'], $_POST['description'])) {
                $erreurs = [];
                $image = htmlentities($_POST['image']);
                $ref = htmlentities($_POST['ref']);
                $idCategorie = (int)$_POST['idCategorie'];
                $quantite = (int)$_POST['quantite'];
                $prixUnit = (float)$_POST['prixUnit'];
                $description = htmlentities($_POST['description']);
    
                if (strlen($ref) < 2) {
                    $erreurs['ref'] = "Nom du produit trop court";
                }

                if ($quantite <= 0) {
                    $erreurs['quantite'] = "Quantité inférieur ou égale à 0";
                }

                if ($prixUnit <= 0) {
                    $erreurs['prixUnit'] = "Prix inférieur ou égale à 0";
                }

                if (strlen($prixUnit) < 2) {
                    $erreurs['description'] = "Description trop court";
                }

                if (!empty($erreurs)) {
                    $erreur = "Le formulaire est incorrect";
                } else {
                    $admin->modifierProduit($id, $image, $idCategorie, $ref, $prixUnit, $quantite);
                    $success = "Produit modifié !";
                }
            }
            require_once $pagesAdmin . 'modifierProduit.php';
        }
    break;

    case 'supprimerProduit':
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $admin->supprimerProduit($id);
            header("Location:index.php?p=listeProduits");
            exit();
        } else if (isset($_POST['lesProduits'])) {
            $lesProduits = $_POST['lesProduits'];
            foreach ($lesProduits as $id => $checkEtat) {
                $admin->supprimerProduit($id);
            }
            header("Location:index.php?p=listeProduits");
            exit();
        }
    break;

    case 'listeCategories':
        $lesCategories = $pdo->getLesCategories();
        
        if (isset($_POST['ref'])) {
            $ref = htmlentities($_POST['ref']);

            if (mb_strlen($ref) < 2) {
                $erreur = 'Nom de la catégorie trop courte';
            } else {
                try {
                    $admin->ajouterCategorie($ref);
                    header("Location:index.php?p=listeCategories");
                    exit();
                } catch (\Throwable $th) {
                    if ($th->getCode() === "23000") {
                        $erreur = 'La catégorie existe déjà';
                    } else {
                        $erreur = 'Erreur général';
                        echo $th;
                    }
                }
            }
        }
        require_once $pagesAdmin . 'listeCategories.php';
    break;

    case 'supprimerCategorie':
        if (isset($_GET['id'])) {
            $id = htmlentities($_GET['id']);
            $admin->supprimerCategorie($id);
            header("Location:index.php?p=listeCategories");
            exit();
        } else if (isset($_POST['lesCategories'])) {
            $lesCategories = $_POST['lesCategories'];
            foreach ($lesCategories as $id => $checkEtat) {
                $admin->supprimerCategorie($id);
            }
            header("Location:index.php?p=listeCategories");
            exit();
        }
    break;


    // CLIENT
    case 'panier':
        $lesProduits = $client->getMesProduits();
        $nbProduits = (int)count($lesProduits);
        require_once $pagesClient . 'panier.php';
    break;

    case 'credit':
        $solde = $client->getMonSolde();
        require_once $pagesClient . 'credit.php';
    break;

    case 'historiqueAchats':
        require_once $pagesClient . 'historiqueAchats.php';

    break;

    case 'notification':
        require_once $pagesClient . 'notification.php';
    break;

    case 'deconnexion':
        unset($_SESSION['id']);
        header("Location:index.php?action=deconnexion");
        exit();
    break;
    
    default:
        require_once $pages . '404.php';
    break;
}
require_once $elements . 'footer.php';
<?php
$inCommonController = FALSE;
if ($inUserController === TRUE) {
    define("ADMIN_MODEL", BDD . 'admin' . DIRECTORY_SEPARATOR);

    require_once ADMIN_MODEL . 'Admin.php';
    require_once ADMIN_MODEL . 'Produit.php';
    $admin = new Admin();


    switch ($page) {
        case 'listeProduits':
            $lesCategories = $pdo->getLesCategories();
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
            require_once VUES_ADMIN . 'listeProduits.php';
            break;

        case 'modifierProduit':
            // Consulter la modification
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                try {
                    $lesCategories = $pdo->getLesCategories();
                    require_once CARTE_PRODUIT . 'variables.php';
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
                        $admin->modifierProduit($id, $image, $idCategorie, $ref, $prixUnit, $quantite, $description);
                        $success = "Produit modifié !";
                    }
                }
                require_once VUES_ADMIN . 'modifierProduit.php';
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
            require_once VUES_ADMIN . 'listeCategories.php';
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

        default:
            $swapController = $page;
            $inCommonController = TRUE;
        break;
    }
}
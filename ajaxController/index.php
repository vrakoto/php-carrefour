<?php
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}

if ($estConnecte) {
    $role = $pdo->getRole($monIdentifiant);

    switch ($role) {
        case 'ADMIN':
            require_once AJAX . 'admin' . DIRECTORY_SEPARATOR . 'index.php';
        break;

        case 'CLIENT':
            require_once AJAX . 'client' . DIRECTORY_SEPARATOR . 'index.php';
        break;
    }
}

// controller commun
switch ($action) {
    case 'rechercherProduit':
        $leProduit = htmlentities(strtolower($_POST['q']));
        
        $produitsATrouver = [];
        $id = '';
        foreach ($pdo->getLesProduits() as $produit) {
            $ref = htmlentities(strtolower($produit['ref']));

            if (str_contains($ref, $leProduit)) {
                $id = (int)$produit['id'];
                $produitsATrouver[] = $produit;
            }
        }

        if (!empty($produitsATrouver)) {
            foreach ($produitsATrouver as $leProduit) {
                $id = (int)$leProduit['id'];
                $lesAvis = $pdo->getLesAvis($id);

                require CARTE_PRODUIT . 'variables.php';
                require ELEMENTS . 'carteProduit.php';
            }
        } else {
            echo json_encode(['msg' => 'Aucun produit disponible']);
        }
    break;
}
exit();
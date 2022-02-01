<?php
$action = $_REQUEST['action'];
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

                require $elements . 'varProduit.php';
                require $elements . 'carteProduit.php';
            }
        } else {
            echo json_encode(['msg' => 'Aucun produit disponible']);
        }
    break;
}
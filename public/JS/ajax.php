<?php

$action = $_REQUEST['action'];
switch ($action) {
    case 'ajouterProduit':
        echo "ok";
    break;
    
    case 'supprimerProduit':
        $id = (int)$_POST['id'];
        $erreur = [];

        try {
            $admin->supprimerProduit($id);
        } catch (\Throwable $th) {
            $erreur = $th->getMessage();
        }
        echo json_encode(['erreur' => $erreur]);
    break;
}
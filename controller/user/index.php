<?php
$inUserController = FALSE;
switch ($page) {
    case 'deconnexion':
        unset($_SESSION['identifiant']);
        header("Location:index.php?p=accueil");
        exit();
    break;

    default:
        $swapController = $page;
        $inUserController = TRUE;
    break;
}

$role = $pdo->getRole($monIdentifiant);
switch ($role) {
    case 'ADMIN':
        require_once USER_CONTROLLER . 'admin.php';
    break;

    case 'CLIENT':
        require_once USER_CONTROLLER . 'client.php';
    break;
}
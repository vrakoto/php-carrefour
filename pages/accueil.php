<div class="d-flex justify-content-center flex-wrap">
    <?php foreach ($lesProduits as $leProduit) {
        $id = (int)$leProduit['id'];
        $lesAvis = $pdo->getLesAvis($id);
        
        require $elements . 'varProduit.php';
        require $elements . 'carteProduit.php';
    }
    ?>
</div>
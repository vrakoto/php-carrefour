<div class="d-flex justify-content-center flex-wrap">
    <?php foreach ($lesProduits as $produit):
        $id = (int)$produit['id'];
        $idCategorie = (int)$produit['idCategorie'];
        $imagePrincipale = htmlentities($produit['image']);
        $ref = htmlentities($produit['ref']);
        $categorie = $pdo->getLaCategorie($idCategorie);
        $quantite = (int)$produit['quantite'];
        $prixUnit = (float)$produit['prixUnit'];
        $description = htmlentities($produit['description'])
    ?>
        <?php require $elements . 'carteProduit.php' ?>
    <?php endforeach ?>

</div>
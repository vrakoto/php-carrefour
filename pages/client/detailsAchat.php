<div class="d-flex flex-wrap align-items-center p-2 bg-white mt-4 px-3 rounded" style="max-width: 750px;">
    <div class="mr-1">
        <img class="rounded" src="<?= $imagePrincipale ?>" width="70">
    </div>

    <div class="product-details mx-3">
        <span class="font-weight-bold"><?= $ref ?></span>
    </div>

    <div class="product-details mx-3">
        <span class="font-weight-bold">Quantité : <?= $quantiteUtilisateur ?></span>
    </div>

    <div class="product-details mx-3">
        <span class="font-weight-bold">Prix : <?= $prixUnit ?> &euro;</span>
    </div>

    <div class="product-details">
        <span class="font-weight-bold">Total : <?= $totalProduit ?> &euro;</span>
    </div>

    <div class="ms-auto">
        <a class="mx-2" href="index.php?p=produit&id=<?= $id ?>"><i class="fas fa-file-alt fa-lg mb-1 text-primary"></i></a>
    </div>
</div>
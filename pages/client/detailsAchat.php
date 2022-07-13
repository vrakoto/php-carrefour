<div>
    <a href="index.php?p=historiqueAchats" class="text-black"><i class="fas fa-arrow-left mr-2"></i> Retourner en arrière</a>
</div>

<?php foreach ($lesProduits as $produit):
    $id = (int)$produit['idProduit'];
    require CARTE_PRODUIT . 'variables.php';
    $quantiteUtilisateur = (int)$produit['quantite'];
    $totalProduit = ($quantiteUtilisateur * $prixUnit);
    $sums[] = ($quantiteUtilisateur * $prixUnit);
?>
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
<?php endforeach ?>
<?php $total = floor((array_sum($sums) * 100)) / 100 ?>
<h4 class='mt-5'>Total TTC : <?= $total ?> &euro;</h4>
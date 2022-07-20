<div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#notification">Mes notifications</button>
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#produitsArrives">Les produits arrivés</button>
</div>

<div class="tab-content">

    <div class="tab-pane fade show active" id="notification">
        <?php foreach ($mesNotifications as $produit) : $id = (int)$produit['idProduit'];
            require CARTE_PRODUIT . 'variables.php' ?>
            <div class="d-flex flex-row flex-wrap justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded" style="max-width: 500px;">
                <div class="mr-1">
                    <img class="rounded" src="<?= $imagePrincipale ?>" width="70">
                </div>

                <div class="product-details">
                    <span class="font-weight-bold"><?= $ref ?></span>
                </div>

                <div class="ms-auto">
                    <a class="mx-2" href="index.php?p=produit&id=<?= $id ?>"><i class="fas fa-file-alt fa-lg mb-1 text-primary"></i></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="tab-pane fade" id="produitsArrives">
        <?php foreach ($produitsArrives as $produit) : $id = (int)$produit['idProduit'];
            require CARTE_PRODUIT . 'variables.php' ?>
            <div class="d-flex flex-wrap align-items-center p-2 bg-white mt-4 px-3 rounded" style="max-width: 500px;">
                <div class="mr-1">
                    <img class="rounded" src="<?= $imagePrincipale ?>" width="70">
                </div>

                <div class="product-details mx-3">
                    <span class="font-weight-bold"><?= $ref ?></span>
                </div>

                <div class="product-details mx-3">
                    <span class="font-weight-bold">x<?= $quantite ?></span>
                </div>

                <div class="product-details">
                    <span class="font-weight-bold"><?= $prixUnit ?> &euro;</span>
                </div>

                <div class="ms-auto">
                    <a class="mx-2" href="index.php?p=produit&id=<?= $id ?>"><i class="fas fa-file-alt fa-lg mb-1 text-primary"></i></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
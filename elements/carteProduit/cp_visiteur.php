<div class="leProduit d-flex justify-content-center align-items-center ms-5 text-center" id="produit">
    <div class="d-flex justify-content-evenly card p-3">
        <?php if (!$produitDisponible): $opacity = "opacity-25"; ?>
            <h1 class="position-absolute hors-stock">HORS STOCK</h1>
        <?php endif ?>

        <div class="<?= $opacity ?>">
            <h4 class="text-uppercase"><?= $categorie ?></h4>
            <div class="text-center">
                <img src="<?= $imagePrincipale ?>" width="200">
            </div>

            <hr>

            <h1 class="main-heading mb-0" id="leProduit-nom"><?= $ref ?></h1>
            <p><?= $description ?></p>
            <p><?= $prixUnit ?> &euro;</p>
            <div class="d-flex justify-content-center user-ratings">
                <div class="ratings">
                    <?php for ($i = 1; $i <= $noteMoyenne; $i++): ?>
                        <i class="fa fa-star"></i>
                    <?php endfor ?>
                </div>
            </div>
            <a href="index.php?p=avis&id=<?= $id ?>" class="text-muted mx-1"><?= $phraseAvis ?></a>
        </div>
    </div>
</div>
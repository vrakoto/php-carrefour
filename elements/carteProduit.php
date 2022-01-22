<div class="d-flex justify-content-center align-items-center ms-5 text-center" id="produit">
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

            <h1 class="main-heading mb-0"><?= $ref ?></h1>
            <p><?= $description ?></p>
            <p><?= $prixUnit ?> &euro;</p>
            <div class="d-flex justify-content-center flex-row user-ratings">
                <div class="ratings">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <a href="/avis" class="text-muted mx-1">4/5</a>
            </div>

            <?php if ($role === 'CLIENT' && $produitDisponible && !$client->produitExistantPanier($id)): ?>
                <div id="interaction">
                    <input class="form-control mt-3" type="number" id="quantite" placeholder="Insérer une quantité" min="1" max="<?= $quantite ?>">
                    <button class="btn btn-danger mt-3" onclick="ajouterProduitPanier(<?= $id ?>, this)"><i class="fas fa-cart-plus"></i> Ajouter le produit</button>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
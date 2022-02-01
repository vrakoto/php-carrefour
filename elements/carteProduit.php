<div class="leProduit d-flex justify-content-center align-items-center ms-5 text-center" id="produit">
    <div class="d-flex justify-content-evenly card p-3">
        <?php if (!$produitDisponible): $opacity = "opacity-25"; ?>
            <?php if (isset($produitNotifier)): ?>
                <?php if (!$produitNotifier): ?>
                    <i class="position-absolute fas fa-bell fa-2x notification text-primary" onclick="notifierProduit(<?= $id ?>, this)"></i>
                <?php else: ?>
                    <i class='position-absolute fas fa-bell-slash fa-2x notification retirerNotification text-danger' onclick='retirerNotification(<?= $id ?>, this)'></i>
                <?php endif ?>
            <?php endif ?>
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

            <?php if ($role === 'CLIENT' && $produitDisponible && !$client->produitExistantPanier($id)): ?>
                <div id="interaction">
                    <input class="form-control mt-3" type="number" id="quantite" placeholder="Insérer une quantité" min="1" max="<?= $quantite ?>">
                    <button class="btn btn-danger mt-3" onclick="ajouterProduitPanier(<?= $id ?>, this)"><i class="fas fa-cart-plus"></i> Ajouter le produit</button>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
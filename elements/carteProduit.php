<div class="d-flex justify-content-center align-items-center ms-5 text-center" id="produit">
    <div class="d-flex justify-content-evenly card p-3">
        <h4 class="text-uppercase"><?= $categorie ?></h4>
        <div class="text-center">
            <img src="<?= $imagePrincipale ?>" width="200">
        </div>

        <hr>

        <h1 class="main-heading mb-0"><?= $ref ?></h1>
        <p><?= $description ?>.</p>
        <div class="d-flex justify-content-center flex-row user-ratings">
            <div class="ratings">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <a href="/avis" class="text-muted mx-1">4/5</a>
        </div>

        <input class="form-control mt-3" type="number" name="quantite" placeholder="Insérer une quantité">
        <button class="btn btn-danger mt-3" onclick="ajouterProduit(<?= $id ?>)"><i class="fas fa-cart-plus"></i> Ajouter le produit</button>
    </div>
</div>
<div class="avis-lesProduits">
    <h4 id="titleAvis"><?= $titre ?></h4>
    <?php foreach ($lesProduits as $produit):
        $id = (int)$produit['idProduit'];
        require CARTE_PRODUIT . 'variables.php';
    ?>

    <div class="avisProduit d-flex flex-wrap align-items-center p-2 bg-white mt-4 px-3 rounded" onclick="structureAvis(<?= $id ?>)">
        <div class="mr-1">
            <img class="rounded" src="<?= $imagePrincipale ?>" width="70">
        </div>

        <div class="product-details mx-3">
            <span class="font-weight-bold"><?= $ref ?></span>
        </div>

        <div class="ms-auto">
            <a class="mx-2" href="index.php?p=produit&id=<?= $id ?>"><i class="fas fa-file-alt fa-lg mb-1 text-primary"></i></a>
        </div>
    </div>

    <?php endforeach ?>
</div>

<div class="structureAvis d-flex d-none flex-column">
    <button class="btn btn-secondary" onclick="retourListeProduitsAvis()"><- Retourner</button>

    <div class="card mt-3">
        <div class="card-body text-center"> <span class="myratings"></span>
            <h4 class="mt-1">Attribuez une note</h4>
            <fieldset class="rating">
                <input type="radio" id="star5" name="rating" value="5"/>
                <label class="full" for="star5"></label>

                <input type="radio" id="star4" name="rating" value="4"/>
                <label class="full" for="star4"></label>

                <input type="radio" id="star3" name="rating" value="3"/>
                <label class="full" for="star3"></label>

                <input type="radio" id="star2" name="rating" value="2"/>
                <label class="full" for="star2"></label>

                <input type="radio" id="star1" name="rating" value="1"/>
                <label class="full" for="star1"></label>
            </fieldset>
        </div>
    </div>
    
    <textarea style="max-width: 345px;" class="form-control mt-3" id="commentaire" placeholder="Votre commentaire"></textarea>
    <button class="btn btn-primary mt-3" onclick="envoyerAvis()">Envoyer mon avis</button>
</div>
<?php if (isset($erreur)): ?>
    <div class="container text-center alert alert-danger">
        <?= $erreur ?>
        <ul class="mt-2">
            <?php foreach ($erreurs as $erreur): ?>
                <li><?= $erreur ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<?php if (isset($success)): ?>
    <div class="container text-center alert alert-success">
        <?= $success ?>
    </div>
<?php endif ?>

<div class="form-body">
    <a class="btn btn-primary" href="index.php?p=listeProduits">Retour</a>
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Modifier le produit : <?= $ref ?> n°<?= $id ?></h3>
                    
                    <form action="index.php?p=modifierProduit&id=<?= $id ?>" class="requires-validation" method="POST">
                        <img src="<?= $imagePrincipale ?>" height="120" width="120" alt="Image du produit">
                        <div class="col-md-12">
                            <label for="image" class="form-label mt-3 mb-0">Image en lien URL</label>
                            <input class="form-control mt-0" type="text" id="image" name="image" placeholder="http(s)://www..." autofocus value="<?= $imagePrincipale ?>">
                        </div>

                        <div class="col-md-12">
                            <label for="ref" class="form-label mt-3 mb-0">Nom du produit</label>
                            <input class="form-control mt-0" id="ref" type="text" name="ref" placeholder="Nom du produit" value="<?= $ref ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="categorie" class="form-label mt-3 mb-0">Catégorie</label>
                            <select class="form-select" name="idCategorie" id="categorie">
                                <?php foreach ($lesCategories as $categorie): $idCategorie = (int)$categorie['id']; $ref = htmlentities($categorie['ref']) ?>
                                    <option value="<?= $idCategorie ?>" <?php if ($idCategorie == $pdo->getLeProduit($id)['idCategorie']): ?> selected <?php endif ?>><?= $ref ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="quantite" class="form-label mt-3 mb-0">Quantité</label>
                            <input class="form-control mt-0" id="quantite" type="number" name="quantite" placeholder="Quantité" value="<?= $quantite ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="prixUnit" class="form-label mt-3 mb-0">Prix Unitaire TTC</label>
                            <input class="form-control mt-0" id="prixUnit" type="number" name="prixUnit" placeholder="Prix unitaire TTC" value="<?= $prixUnit ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label mt-3 mb-0">Description</label>
                            <input class="form-control mt-0" id="description" type="text" name="description" placeholder="Description du produit" value="<?= $description ?>" required>
                        </div>

                        <div class="form-button mt-3">
                            <button type="submit" class="btn btn-primary">Modifier les informations</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
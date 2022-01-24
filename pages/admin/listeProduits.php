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

<div class="container text-center">

    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Ajouter un produit</h3>

                        <form action="index.php?p=listeProduits" class="requires-validation" method="POST">

                            <div class="col-md-12">
                                <input class="form-control" type="text" name="image" placeholder="Image du produit en URL uniquement" value="<?= keepInputValue('image') ?>" required>
                            </div>

                            <div class="col-md-12 mt-3">
                                <select class="form-select" name="categorie">
                                    <option value="0" selected>-- Sélectionner une catégorie ---</option>
                                    <?php foreach ($lesCategories as $categorie) :
                                        $id = (int)$categorie['id'];
                                        $ref = htmlentities($categorie['ref'])
                                    ?>
                                        <option value="<?= $id ?>"><?= $ref ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="text" name="ref" placeholder="Nom du produit" value="<?= keepInputValue('ref') ?>" required>
                            </div>

                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="number" step="1" name="quantite" placeholder="Quantité" value="<?= keepInputValue('quantite') ?>" required>
                            </div>

                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="number" step="0.01" name="prixUnit" placeholder="Prix unitaire en €" value="<?= keepInputValue('prixUnit') ?>" required>
                            </div>

                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="text" name="description" placeholder="Description" value="<?= keepInputValue('description') ?>" required>
                            </div>

                            <div class="form-button mt-3">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="input-group">
        <input type="search" class="form-control rounded" id="rechercherProduit" placeholder="Rechercher un produit" />
        <button type="button" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </div>

    <form action="index.php?p=supprimerProduit" method="POST">
        <button type="submit" class="d-none supCat btn btn-danger fa-4x mt-3"><i class="fas fa-trash"></i> Suppression multiples</button>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">Sélection</th>
                    <th scope="col">Image principale</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Référence</th>
                    <th scope="col">Prix Unitaire TTC</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Date Ajout</th>
                    <th scope="col">Intéraction</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lesProduits as $produit) :
                    $id = (int)$produit['id'];
                    $idCategorie = htmlentities($produit['idCategorie']);
                    $categorie = $pdo->getLaCategorie($idCategorie);
                    $imagePrincipale = htmlentities($produit['image']);
                    $ref = htmlentities($produit['ref']);
                    $quantite = (int)$produit['quantite'];
                    $prixUnit = (float)$produit['prixUnit'];
                    $description = htmlentities($produit['description']);
                    $dateAjout = htmlentities($produit['dateAjout'])
                ?>
                    <tr class="leProduit">
                        <th scope="row"><input type="checkbox" name="lesProduits[<?= $id ?>]" class="leProduit-supprimer" onchange="selectMultiples(this)"></th>
                        <th scope="row"><img src="<?= $imagePrincipale ?>" width="80" alt="Image du produit"></th>
                        <td><?= $categorie ?></td>
                        <td><span class="leProduit-nom"><?= $ref ?></span></td>
                        <td><?= $prixUnit ?></td>
                        <td><?= $quantite ?></td>
                        <td><?= $dateAjout ?></td>
                        <td>
                            <a href="index.php?p=produit&id=<?= $id ?>" class="btn btn-primary"><i class="fas fa-file-alt"></i></a>
                            <a href="index.php?p=modifierProduit&id=<?= $id ?>" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                            <a href="index.php?p=supprimerProduit&id=<?= $id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </form>
</div>
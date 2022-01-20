<?php if (isset($erreur)) : ?>
    <div class="container text-center alert alert-danger">
        <?= $erreur ?>
    </div>
<?php endif ?>

<div class="form-body">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Ajouter une catégorie</h3>

                    <form action="index.php?p=listeCategories" class="requires-validation" method="POST">
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="ref" placeholder="La catégorie" required>
                        </div>

                        <div class="form-button mt-3">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="container-categorie text-center">
                <div class="input-group">
                    <input type="search" class="form-control rounded" id="rechercherProduit" placeholder="Rechercher un produit" />
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <form action="index.php?p=supprimerCategorie" method="POST" class="mt-3">
                    <button type="submit" class="d-none supCat btn btn-danger fa-4x"><i class="fas fa-trash"></i> Suppression multiples</button>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Sélectionner</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Nombre de produits</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lesCategories as $categorie) :
                                $id = htmlentities($categorie['id']);
                                $ref = htmlentities($categorie['ref']);
                                $nbProduits = (int)count($pdo->getLesProduitsCategorie($id));
                            ?>
                                <tr class="leProduit">
                                    <th scope="row"><input type="checkbox" name="lesCategories[<?= $id ?>]" class="leProduit-supprimer" onchange="selectMultiples(this)"></th>
                                    <th scope="row"><?= $id ?></th>
                                    <th scope="row"><span class="leProduit-nom"><?= $ref ?></span></th>
                                    <td><?= $nbProduits ?></td>
                                    <td>
                                        <a href="index.php?p=supprimerCategorie&id=<?= $id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
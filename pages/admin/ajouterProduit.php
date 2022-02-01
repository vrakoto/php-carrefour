<?php if (isset($erreur)) : ?>
    <div class="container text-center alert alert-danger">
        <?= $erreur ?>
        <ul class="mt-2">
            <?php foreach ($erreurs as $erreur) : ?>
                <li><?= $erreur ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<?php if (isset($success)) : ?>
    <div class="container text-center alert alert-success">
        <?= $success ?>
    </div>
<?php endif ?>

<div class="form-body">
    <h3>Ajouter un produit</h3>

    <form action="index.php?p=ajouterProduit" class="requires-validation" method="POST">

        <div class="col-md-12">
            <input class="form-control" type="text" name="image" placeholder="Image du produit en URL uniquement" value="<?= keepInputValue('image') ?>" required>
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
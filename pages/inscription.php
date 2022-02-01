<?php if (isset($erreurs)) : ?>
    <div class="container text-center alert alert-danger">
        <?= $erreur ?>
        <ul class="mt-1">
            <?php foreach ($erreurs as $erreur) : ?>
                <li><?= $erreur ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="form-body">
    <h3>Inscription</h3>

    <form action="index.php?p=inscription" class="requires-validation" method="POST">
        <div class="col-md-12">
            <input class="form-control" type="text" name="id" placeholder="Identifiant" value="<?= keepInputValue('id') ?>" autofocus required>
        </div>

        <div class="col-md-12">
            <input class="form-control" type="text" name="ville" placeholder="Ville" value="<?= keepInputValue('ville') ?>" required>
        </div>

        <div class="col-md-12">
            <input class="form-control" type="password" name="mdp" placeholder="Mot de passe" required>
        </div>

        <div class="col-md-12">
            <input class="form-control" type="password" name="mdp_confirm" placeholder="Mot de passe à confirmer" required>
        </div>

        <div class="form-button mt-3">
            <button id="submit" type="submit" class="btn btn-primary">S'inscrire</button>
        </div>
    </form>

</div>
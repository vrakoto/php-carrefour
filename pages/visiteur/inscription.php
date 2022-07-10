<div class="w-75 m-auto">
    <?php if (isset($erreurs)) : ?>
        <div class="alert alert-danger text-center">
            <i class="fa-solid fa-triangle-exclamation"></i> <?= $erreur ?>
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
                <input class="form-control" type="text" name="identifiant" placeholder="Identifiant" value="<?= keepInputValue('identifiant') ?>" autofocus>
            </div>

            <div class="col-md-12">
                <input class="form-control" type="text" name="ville" placeholder="Ville" value="<?= keepInputValue('ville') ?>">
            </div>

            <div class="col-md-12">
                <input class="form-control" type="password" name="mdp" placeholder="Mot de passe">
            </div>

            <div class="col-md-12">
                <input class="form-control" type="password" name="mdp_confirm" placeholder="Mot de passe à confirmer">
            </div>

            <div class="form-button mt-3">
                <button id="submit" type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
        </form>
    </div>
</div>
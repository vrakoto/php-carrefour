<?= includeCSS('inscription') ?>

<?php if (isset($erreurs)): ?>
    <div class="container text-center alert alert-danger">
        <?= $erreur ?>
        <ul class="mt-1">
            <?php foreach ($erreurs as $erreur): ?>
                <li><?= $erreur ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="form-body">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Inscription</h3>
                    
                    <form action="/inscription" class="requires-validation" method="POST" required>
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="id" placeholder="Identifiant" required>
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" type="text" name="ville" placeholder="Ville" required>
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" type="password" name="mdp" placeholder="Mot de passe" required>
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" type="password" name="mdp_confirm" placeholder="Mot de passe à confirmer" required >
                        </div>

                        <div class="form-button mt-3">
                            <button id="submit" type="submit" class="btn btn-primary">S'inscrire</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
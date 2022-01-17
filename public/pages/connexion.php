<?= includeCSS('inscription') ?>

<?php if (isset($erreur)): ?>
    <div class="container text-center alert alert-danger">
        <?= $erreur ?>
    </div>
<?php endif ?>

<div class="form-body">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Connexion</h3>
                    
                    <form action="/connexion" class="requires-validation" method="POST">
                        <div class="col-md-12">
                            <input class="form-control" type="text" name="id" placeholder="Identifiant" required>
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" type="password" name="mdp" placeholder="Mot de passe" required>
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
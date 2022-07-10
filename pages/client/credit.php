<div class="w-75 m-auto">
    <?php if (isset($erreur)) : ?>
        <div class="text-center alert alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i> <?= $erreur ?>
        </div>
    <?php endif ?>

    <?php if (isset($success)) : ?>
        <div class="text-center alert alert-success">
            <i class="fa-solid fa-money-bill"></i> <?= $success ?>
        </div>
    <?php endif ?>

    <form class="form-body" method="post" action="index.php?p=credit">
        <h3>Votre solde actuelle : <?= $solde ?> €</h3>
        <hr>
        <h3>Ajouter du crédit</h3>

        <div class="col-md-12 mt-2">
            <input class="form-control" type="number" name="montant" placeholder="Montant" id="montant" autofocus required>
        </div>

        <div class="form-button mt-3">
            <button type="submit" class="btn btn-success">Ajouter</button>
        </div>
    </form>
</div>
<?php if (isset($erreur)): ?>
    <div class="alert alert-danger">
        <?= $erreur ?>
    </div>
<?php endif ?>

<?php require $elements . 'carteProduit.php' ?>
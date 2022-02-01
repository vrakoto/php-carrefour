<div class="form-body">
    <h3>Votre solde actuelle : <?= $solde ?> €</h3>
    <hr>
    <h3>Ajouter du crédit</h3>

    <div class="col-md-12 mt-2">
        <input class="form-control" type="number" placeholder="Montant" id="montant" autofocus required>
    </div>

    <div class="form-button mt-3">
        <button type="submit" class="btn btn-primary" onclick="crediter()">Ajouter</button>
    </div>
</div>
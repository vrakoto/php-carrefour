<section>
    <div class="container">
        <div class="row w-100">
            <div class="col-lg-12 col-md-12 col-12">
                <h3 class="display-5 mb-2 text-center">Mon historique d'achats</h3>
                <table id="shoppingCart" class="table table-condensed table-responsive mt-5 text-center">
                    <thead>
                        <tr>
                            <th>Numéro panier</th>
                            <th>Date de l'achat</th>
                            <th>Voir en détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesAchatsPanier as $panier):
                            $id = (int)$panier['id'];
                            $dateAchat = htmlentities($panier['date']);
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td id="dateAchat"><?= convertDate($dateAchat, TRUE) ?></td>
                                <td>
                                    <a href="index.php?p=historiqueAchats&id=<?= $id ?>" class="btn btn-primary">Voir en détail</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
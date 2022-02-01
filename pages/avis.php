<div class="container">

    <div class="row">
        <div class="col-sm-3">
            <div class="rating-block">
                <h4>Note moyenne</h4>
                <h2 class="bold padding-bottom-7"><?= $noteMoyenne ?> <small>/ 5</small></h2>

                <div class="ratings">
                    <?php for ($i = 1; $i <= $noteMoyenne; $i++) : ?>
                        <i class="fa fa-star"></i>
                    <?php endfor ?>

                    <?php for ($i = 1; $i <= $noteRestante; $i++) : ?>
                        <i class="fa fa-star noteRestante"></i>
                    <?php endfor ?>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($lesAvis as $avis) :
        $id = (int)$avis['idProduit'];
        $idUtilisateur = htmlentities($avis['idUtilisateur']);
        $commentaire = $avis['commentaire'];
        $note = (int)$avis['note'];
        $date = htmlentities($avis['date']);
        require $elements . 'varProduit.php';
    ?>
        <div class="row">
            <div class="col-sm-7">
                <hr />
                <div class="review-block">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="review-block-name"><?= $idUtilisateur ?></div>
                            <div class="review-block-date"><?= convertDate($date, TRUE) ?></div>
                        </div>
                        <div class="col-sm-9">
                            <div class="ratings">
                                <?php for ($i = 1; $i <= $note; $i++) : ?>
                                    <i class="fa fa-star"></i>
                                <?php endfor ?>
                            </div>
                            <div class="review-block-description mt-3"><?= $commentaire ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

</div>
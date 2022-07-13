<div class="container">
    <input class="form-control" type="text" id="searchProduct">
    <button class="btn btn-primary mt-2 mb-5" id="btnSearchProduct">Rechercher le produit</button>

    <div class="d-flex flex-row flex-wrap justify-content-center" id="lesRecherches"></div>

    <div class="categories-populaires border">
        <h2>Catégories populaires</h2>

        <div class="d-flex justify-content-center flex-wrap">
            <?php foreach ($lesProduits as $leProduit) {
                $id = (int)$leProduit['id'];
                $lesAvis = $pdo->getLesAvis($id);

                require CARTE_PRODUIT . 'variables.php';
                require ELEMENTS . 'carteProduit.php';
            }
            ?>
        </div>

        <div class="separator"></div>
        <h2>Nouveautés</h2>
    </div>
</div>
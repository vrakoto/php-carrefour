<input class="form-control mb-5 w-75 m-auto" type="text" oninput="rechercherProduit(this)" placeholder="Rechercher un produit">

<div class="d-flex flex-row flex-wrap justify-content-center" id="lesRecherches"></div>

<div class="accueil-content border" id="accueil-content">
    <h2>Produits populaires</h2>

    <div class="d-flex justify-content-center flex-wrap">
        <?php foreach ($lesProduitsPopulaires as $leProduit) {
            $id = (int)$leProduit['id'];
            $lesAvis = $pdo->getLesAvis($id);

            require CARTE_PRODUIT . 'variables.php';
            require ELEMENTS . 'carteProduit.php';
        }
        ?>
    </div>

    <div class="separator"></div>
    <h2>Nouveautés</h2>
    <div class="d-flex justify-content-center flex-wrap">
        <?php foreach ($lesNouveauxProduits as $leProduit) {
            $id = (int)$leProduit['id'];
            $lesAvis = $pdo->getLesAvis($id);

            require CARTE_PRODUIT . 'variables.php';
            require ELEMENTS . 'carteProduit.php';
        }
        ?>
    </div>
</div>
<div class="container">
    <a href="index.php?p=accueil" class="text-black"><i class="fas fa-arrow-left mr-2"></i>Retourner en arrière</a>

    <div class="mt-5 row w-100">
        <div class="col-lg-12 col-md-12 col-12">
            <h3 class="display-5 mb-2 text-center">Mon Panier</h3>
            <p class="mb-5 text-center">
                <i class="font-weight-bold" id="nbProduitsPanier"><?= $nbProduits ?></i> produit<?= ($nbProduits > 1) ? "s" : '' ?> dans votre panier
            </p>
            <table id="shoppingCart" class="table table-condensed table-responsive">
                <thead>
                    <tr>
                        <th style="width:60%">Produit</th>
                        <th style="width:12%">Prix</th>
                        <th style="width:10%">Quantité</th>
                        <th style="width:16%"></th>
                        <th style="width:16%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lesProduits as $produit) :
                        $id = (int)$produit['idProduit'];
                        $quantiteUtilisateur = (int)$produit['quantite'];
                        require CARTE_PRODUIT . 'variables.php';
                        $totalProduit = ($quantiteUtilisateur * $prixUnit);
                    ?>
                        <tr class="leProduit-panier">
                            <td>
                                <div class="row">
                                    <div class="col-md-3 text-left">
                                        <img src="<?= $imagePrincipale ?>" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                    </div>
                                    <div class="col-md-9 text-left mt-sm-2">
                                        <p class="font-weight-light"><?= $ref ?></p>
                                    </div>
                                </div>
                            </td>

                            <td data-th="Price" id="prix"><?= $prixUnit ?></td>

                            <td data-th="Quantity">
                                <input type="number" oninput="updateQuantite(<?= $id ?>, <?= $prixUnit ?>, this)" class="form-control form-control text-center quantiteUtilisateur" value="<?= $quantiteUtilisateur ?>" min="1" max="<?= $quantite ?>">
                            </td>

                            <td class="actions">
                                <div class="text-right">
                                    <button class="btn btn-danger" onclick="supprimerProduitPanier(<?= $id ?>, this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>

                            <td data-th="Total" class="totalProduit"><?= $totalProduit ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <h4>Total : <span id="totalPanier"><?= $total ?? 0 ?></span> €</h4>
    
    <?php if (!empty($erreur)): ?>
        <div class="d-inline-block alert alert-danger text-center">
            <?= $erreur ?>
        </div>
    <?php endif ?>

    <?php if ($nbProduits > 0 && $soldeSuffisant) : ?>
        <button class="btn btn-primary btn-lg pl-5 pr-5" onclick="paiement()">Payer</button>
    <?php endif ?>
</div>
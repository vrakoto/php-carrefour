$(function () {
    switch (request_uri) {
        case 'accueil':
            updateAccueil();
        break;

        case 'panier':
            updatePanier();
        break;
    }
});

function updateSolde() {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=updateSolde'
    });

    request.done(function (res) {
        $('#credit').empty();
        $('#credit').append(res);
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne lors du paiement");
    });
}

function crediter() {
    const montant = parseFloat($('#montant').val());

    let request = $.ajax({
        method: 'post',
        data: 'montant=' + montant,
        url: 'index.php?p=ajax&action=crediter'
    });

    request.done(function (hasError) {
        let msgTitle = '';
        $('#messageModal .modal-body').empty();
        $('#messageModal').modal('show');

        if (hasError) {
            msgTitle = "Erreur lors de l'ajout du produit dans votre panier";
            $('#messageModal .modal-body').text(hasError);
        } else {
            msgTitle = "Votre solde a bien été mise à jour.";
            updateSolde();
        }
        $('#messageModal .modal-title').text(msgTitle);
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne lors du créditement");
    });
}

function paiement() {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=paiement'
    });

    request.done(function (hasError) {
        updatePanier();
        updateSolde();
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne lors du paiement");
    });
}

function updateProduit(idProduit, currentProduit) {
    const produit = $(currentProduit).closest('#produit')

    let request = $.ajax({
        method: 'post',
        data: 'idProduit=' + idProduit,
        url: 'index.php?p=ajax&action=updateProduit'
    });

    request.done(function (res) {
        $(produit).replaceWith(res);
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne lors de l'update du produit");
    });
}

function updateQuantite(idProduit, prixUnit, produitActuel) {
    const qtyUser = $(produitActuel).closest('.leProduit-panier').find('.quantiteUtilisateur').val();

    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=updateQuantite',
        data: 'idProduit=' + idProduit + '&prixUnit=' + prixUnit + '&quantite=' + qtyUser
    });

    request.done(function (hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text("Erreur lors du changement de quantité");
            // $('#messageModal .modal-body').text(hasError);
        } else {
            updatePanier();
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur internal update quantité");
    });
}

function updatePanier() {
    let request = $.ajax({
        method: 'get',
        url: 'index.php?p=ajax&action=updatePanier'
    });

    request.done(function (res) {
        $('#panier').empty();
        $('#panier').append(res);
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne lors de l'update panier");
    });
}


function notifierProduit(idProduit, iconeActuel) {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=notifierProduit',
        data: 'idProduit=' + idProduit
    });

    request.done(function (hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text(hasError);
        } else {
            updateAccueil();
            updateProduit(idProduit, iconeActuel);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne notification");
    });
}

function retirerNotification(idProduit, produitActuel) {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=retirerNotification',
        data: 'idProduit=' + idProduit
    })

    request.done(function (hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text("Erreur lors de la suppression de la notification");
        } else {
            updateAccueil();
            updateProduit(idProduit, produitActuel);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne notification");
    });
}


function ajouterProduitPanier(idProduit, produitActuel) {
    const quantite = $(produitActuel).parent().find('#quantite').val();

    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=ajouterProduitPanier',
        data: 'idProduit=' + idProduit + '&quantite=' + quantite
    })

    request.done(function (hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text("Erreur lors de l'ajout du produit dans votre panier");
            $('#messageModal .modal-body').text(hasError);
        } else {
            updateAccueil();
            updateProduit(idProduit, produitActuel);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne ajout produit");
    });
}

function supprimerProduitPanier(idProduit, produitActuel) {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=supprimerProduitPanier',
        data: 'idProduit=' + idProduit
    });

    request.done(function (hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            // $('#messageModal .modal-body').text(hasError);
        } else {
            updatePanier();
            updateAccueil();
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur interne suppression produit");
    });
}


/* Partie Avis */
var selectedProduit = '';
var cardSelectedProduit = '';
function structureAvis(idProduit, cardProduit) {
    selectedProduit = idProduit;
    cardSelectedProduit = cardProduit
    $('.avis-lesProduits').css({ display: "none" });
    $('.structureAvis').addClass('toggleStructureAvis');
}

$("input[type='radio']").click(function () {
    const sim = $("input[type='radio']:checked").val();
    const ratingText = $('.myratings');

    if (sim < 3) {
        ratingText.css('color', 'red');
        ratingText.text(sim);
    } else {
        ratingText.css('color', 'green');
        ratingText.text(sim);
    }
});

function retourListeProduitsAvis() {
    $(".myratings").empty();
    $("#commentaire").val('');
    $("input[type='radio']").prop('checked', false);
    $('.structureAvis').removeClass('toggleStructureAvis');
    $('.avis-lesProduits').css({ display: "block" });
}

function envoyerAvis() {
    const commentaire = $('#commentaire').val();
    const note = $("input[type='radio']:checked").val();

    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=envoyerAvis',
        data: 'idProduit=' + selectedProduit + '&commentaire=' + commentaire + '&note=' + note
    });

    request.done(function (hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text("Erreur lors de l'envoie de l'avis");
            $('#messageModal .modal-body').text(hasError);
        } else {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text("Merci pour votre avis");
            $(cardSelectedProduit).closest('.avisProduit').remove();
            retourListeProduitsAvis();
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log("Erreur internal avis");
    });
}
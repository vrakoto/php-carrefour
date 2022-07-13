$(function () {
    updatePanier();
});

function notifierProduit(idProduit, iconeActuel) {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=notifierProduit',
        data: 'idProduit=' + idProduit
    });

    request.done(function(hasError) {
        let msg = "";
        $('#messageModal').modal('show');

        if (hasError) {
            msg = "Erreur lors de la notification du produit";
        } else {
            msg = "Produit notifié avec succès";
            $(iconeActuel).remove();
        }

        $('#messageModal .modal-title').text(msg);
    });
    
    request.fail(function(jqXHR, textStatus) {
        console.log("Erreur internal notification");
    });
}

function retirerNotification(idProduit, produitActuel) {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=retirerNotification',
        data: 'idProduit=' + idProduit
    })

    request.done(function(hasError) {
        let msg = '';
        $('#messageModal').modal('show');

        if (hasError) {
            msg = "Erreur lors de la suppression de la notification";
        } else {
            msg = "Notification du produit retiré avec succès";
            $(produitActuel).remove();
        }

        $('#messageModal .modal-title').text(msg);
    });
    
    request.fail(function(jqXHR, textStatus) {
        console.log("Erreur internal notification");
    });
}

function ajouterProduitPanier(idProduit, produitActuel) {
    const quantite = $(produitActuel).parent().find('#quantite').val();

    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=ajouterProduitPanier',
        data: 'idProduit=' + idProduit + '&quantite=' + quantite
    })

    request.done(function(hasError) {
        let msg = '';
        $('#messageModal').modal('show');
        
        if (hasError) {
            msg = "Erreur lors de l'ajout du produit dans votre panier";
            $('#messageModal .modal-body').text(hasError);
        } else {
            msg = "Produit ajouté dans le panier !";
            $(produitActuel).parent().remove();
        }
        
        $('#messageModal .modal-title').text(msg);
    });
    
    request.fail(function(jqXHR, textStatus) {
        console.log("Erreur internal ajout produit");
    });
}


/* Update le total panier + nbProduits dans le panier */
function updatePanier() {
    const lesProduits = $('.leProduit-panier');
    $('#nbProduitsPanier').text(lesProduits.length);

    if (lesProduits.length <= 0) {
        $('#payer').parent().remove();
    }

    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=updateTotal'
    });

    request.done(function(total) {
        $('#totalPanier').text(total + ' €');
    });

    request.fail(function(jqXHR, textStatus) {
        console.log("Erreur internal");
    });
}

function updateQuantite(idProduit, prixUnit, produitActuel) {
    const qtyUser = $(produitActuel).closest('.leProduit-panier').find('.quantiteUtilisateur').val();

    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=updateQuantite',
        data: 'idProduit=' + idProduit + '&prixUnit=' + prixUnit + '&quantite=' + qtyUser
    });

    request.done(function(hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            $('#messageModal .modal-title').text("Erreur lors du changement de quantité");
            // $('#messageModal .modal-body').text(hasError);
        } else {
            $(produitActuel).closest('.leProduit-panier').find('.totalProduit').text(parseFloat(($(produitActuel).val() * prixUnit).toFixed(2)));
            updatePanier();
        }
    });

    request.fail(function(jqXHR, textStatus) {
        console.log("Erreur internal update quantité");
    });
}

function supprimerProduitPanier(idProduit, produitActuel) {
    let request = $.ajax({
        method: 'post',
        url: 'index.php?p=ajax&action=supprimerProduitPanier',
        data: 'idProduit=' + idProduit
    });

    request.done(function(hasError) {
        if (hasError) {
            $('#messageModal').modal('show');
            // $('#messageModal .modal-body').text(hasError);
        } else {
            $(produitActuel).closest('.leProduit-panier').remove();
            updatePanier();
        }
    });

    request.fail(function(jqXHR, textStatus) {
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

    request.done(function(hasError) {
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

    request.fail(function(jqXHR, textStatus) {
        console.log("Erreur internal avis");
    });
}
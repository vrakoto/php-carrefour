$(function () {
  let titre = "Carrefour";
  let page = window.location.href.split('?p=')[1];
  switch (page) {
    case 'accueil':
      titre += " - Accueil";
    break;

    case 'panier':
      titre += " - Mon panier";
    break;

    case 'credit':
      titre += " - Ajouter Crédit";
    break;

    case 'historiqueAchats':
      titre += " - Historiques Achats";
    break;

    case 'donnerAvis':
      titre += " - Donner un Avis";
    break;

    case 'notification':
      titre += " - Mes Notifications";
    break;

    // ADMIN
    case 'listeProduits':
      titre += " - Liste des produits";
    break;

    case 'listeCategories':
      titre += " - Liste des catégories";
    break;

    default:
      titre += " - Erreur 404";
    break;
  }
  document.title = titre;


  $('#sidebarCollapse').on('click', function () {
    $('#sidebar, #content').toggleClass('active');
  });

  $('#fermerMenu').on('click', function () {
    $('#sidebar').removeClass('active');
  });

  updatePanier();
});


// partie admin
$('#rechercherProduit').on('input', function () {
  const input = $(this).val();
  const inputFilter = input.toLowerCase();

  $('.leProduit').each(function () {
    const leNom = $(this).find('.leProduit-nom').text().toLowerCase();
    if (leNom) {
      if (!leNom.includes(inputFilter)) {
        $(this).addClass("filtrerRechercheProduit");
      } else {
        $(this).removeClass("filtrerRechercheProduit");
      }
    }
  });
});

// partie accueil
$('#btnSearchProduct').on('click', function () {
  const laRecherche = $('#searchProduct').val();
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=rechercherProduit',
    data: 'q=' + laRecherche,
    success: (data) => {
      let error = true;
      try {
        JSON.parse(data);
      } catch (e) {
        error = false;
      }

      if (error) {
        const msg = JSON.parse(data).msg;
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors de la recherche");
        $('#messageModal .modal-body').text(msg);
      } else {
        $('.categories-populaires').remove();
        $('.categories-populaires').append(data);
        $('#lesRecherches').empty();
        $('#lesRecherches').append(data);
      }
    },
    error: (e) => {
      console.log("Erreur internal recherche");
    }
  });
});


function crediter() {
  const montant = $('#montant').val();
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=crediter',
    data: 'montant=' + montant,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors de la créditation");
        $('#messageModal .modal-body').text(error);
      } else {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Votre solde a été mis à jour");
        $('#messageModal .modal-body').text("Remplissez dès à présent votre panier.");
      }
    },
    error: (e) => {
      console.log("Erreur internal credit");
    }
  });
}

function notifierProduit(idProduit, produitActuel) {
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=notifierProduit',
    data: 'idProduit=' + idProduit,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors de la notification du produit");
      } else {
        $(produitActuel).remove();
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Produit notifié avec succès");
      }
    },
    error: (e) => {
      console.log("Erreur internal notification");
    }
  });
}

function retirerNotification(idProduit, produitActuel) {
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=retirerNotification',
    data: 'idProduit=' + idProduit,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors de la suppression de la notification");
      } else {
        $(produitActuel).remove();
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Notification du produit retiré avec succès");
      }
    },
    error: (e) => {
      console.log("Erreur internal notification");
    }
  });
}

function updateQuantite(idProduit, prixUnit, produitActuel) {
  const qtyUser = $(produitActuel).closest('.leProduit-panier').find('.quantiteUtilisateur').val();
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=updateQuantite',
    data: 'idProduit=' + idProduit + '&prixUnit=' + prixUnit + '&quantite=' + qtyUser,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors du changement de quantité");
        $('#messageModal .modal-body').text(error);
      } else {
        $(produitActuel).closest('.leProduit-panier').find('.totalProduit').text(parseFloat(($(produitActuel).val() * prixUnit).toFixed(2)));
        updatePanier();
      }
    },
    error: (e) => {
      console.log("Erreur internal");
    }
  });
}


function ajouterProduitPanier(idProduit, produitActuel) {
  const quantite = $(produitActuel).parent().find('#quantite').val();
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=ajouterProduitPanier',
    data: 'idProduit=' + idProduit + '&quantite=' + quantite,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors de l'ajout du produit dans votre panier");
        $('#messageModal .modal-body').text(error);
      } else {
        $(produitActuel).parent().remove();
      }
    },
    error: (e) => {
      console.log("Erreur internal");
    }
  });
}

function supprimerProduitPanier(idProduit, produitActuel) {
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=supprimerProduitPanier',
    data: 'idProduit=' + idProduit,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-body').text(error);
      } else {
        $(produitActuel).closest('.leProduit-panier').remove();
        updatePanier();
      }
    },
    error: (e) => {
      console.log(e);
    }
  });
}

/* Update le total panier + nbProduits dans le panier */
function updatePanier() {
  const lesProduits = $('.leProduit-panier');
  $('#nbProduitsPanier').text(lesProduits.length);

  if (lesProduits.length <= 0) {
    $('#payer').parent().remove();
  }

  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=updateTotal',
    success: (data) => {
      $('#totalPanier').text(data + ' €');
    },
    error: (e) => {
      console.log("Erreur internal");
    }
  });
}

function payer() {
  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=payer',
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors du paiement");
        $('#messageModal .modal-body').text(error);
      } else {
        location.reload();
      }
    },
    error: (e) => {
      console.log("Erreur internal paiement");
    }
  });
}

/* Partie Avis */
var idProduitAvis = '';
function structureAvis(idProduit) {
  idProduitAvis = idProduit;
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

  $.ajax({
    method: 'post',
    url: 'index.php?p=ajax&action=envoyerAvis',
    data: 'idProduit=' + idProduitAvis + '&commentaire=' + commentaire + '&note=' + note,
    success: (error) => {
      if (error) {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Erreur lors de l'envoie de l'avis");
        $('#messageModal .modal-body').text(error);
      } else {
        $('#messageModal').modal('show');
        $('#messageModal .modal-title').text("Merci pour votre avis");
        // updateListeProduitsAvis();
        retourListeProduitsAvis();
      }
    },
    error: (e) => {
      console.log("Erreur internal avis");
    }
  });
}

function selectMultiples(c) {
  const nbSelection = $('.leProduit-supprimer:checked').length;

  if (nbSelection > 0) {
    $('.supCat').addClass('suppressionMultiples');
  } else {
    $('.supCat').removeClass('suppressionMultiples');
  }
}
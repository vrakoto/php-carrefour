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
      titre += " - Mes historiques d'Achats";
    break;

    case 'notification':
      titre += " - Mes notifications";
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
  
  updatePanier();
});


$('#rechercherProduit').on('input', function () {
  const input = $(this).val();
  const inputFilter = input.toLowerCase();

  $('.leProduit').each(function () {
    const leNom = $(this).find('.leProduit-nom').text().toLowerCase();
    if (!leNom.includes(inputFilter)) {
      $(this).addClass("filtrerRechercheProduit");
    } else {
      $(this).removeClass("filtrerRechercheProduit");
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
        $(produitActuel).closest('.leProduit-panier').find('.totalProduit').text(parseFloat(($(produitActuel).val()*prixUnit).toFixed(2)));
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

function selectMultiples(c) {
  const nbSelection = $('.leProduit-supprimer:checked').length;

  if (nbSelection > 0) {
    $('.supCat').addClass('suppressionMultiples');
  } else {
    $('.supCat').removeClass('suppressionMultiples');
  }
}
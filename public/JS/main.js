$(function () {
  /* let titre = "Carrefour";
  switch (window.location.pathname) {
    case '/accueil':
      titre += " - Accueil";
      break;

    case '/panier':
      titre += " - Mon panier";
      break;

    case '/credit':
      titre += " - Ajouter Crédit";
      break;

    case '/historiqueAchats':
      titre += " - Mes historiques d'Achats";
      break;

    case '/notification':
      titre += " - Mes notifications";
      break;

    default:
      titre += " - Erreur 404";
      break;
  }
  document.title = titre; */


  $('#sidebarCollapse').on('click', function () {
    $('#sidebar, #content').toggleClass('active');
  });
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

function ajouterProduit() {
  $.ajax({
    method: 'post',
    url: 'JS/ajax.php?action=ajouterProduit',
    success: (data) => {
      console.log(data);
    },
    error: (e) => {
      console.log(e);
    }
  })
}

function selectMultiples(c) {
  const nbSelection = $('.leProduit-supprimer:checked').length;

  if (nbSelection > 0) {
    $('.supCat').addClass('suppressionMultiples');
  } else {
    $('.supCat').removeClass('suppressionMultiples');
  }
}
$(function () {
  let titre = "Carrefour";
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
  document.title = titre;


  $('#sidebarCollapse').on('click', function () {
    $('#sidebar, #content').toggleClass('active');
  });
});
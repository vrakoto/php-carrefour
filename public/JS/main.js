$(function () {
  $('#sidebarCollapse').on('click', function () {
    $('#sidebar, #content').toggleClass('active');
  });

  $('#fermerMenuMobile').on('click', function () {
    $('#sidebar').removeClass('active');
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
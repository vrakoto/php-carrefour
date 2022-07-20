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

function selectMultiples(c) {
    const nbSelection = $('.leProduit-supprimer:checked').length;

    if (nbSelection > 0) {
        $('.supCat').addClass('suppressionMultiples');
    } else {
        $('.supCat').removeClass('suppressionMultiples');
    }
}
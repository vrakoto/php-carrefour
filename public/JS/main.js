const request_uri = window.location.href.split('?p=').at(-1);
$(function () {
	$('#sidebarCollapse').on('click', function () {
		$('#sidebar, #content').toggleClass('active');
	});

	$('#fermerMenuMobile').on('click', function () {
		$('#sidebar').removeClass('active');
	});

	switch (request_uri) {
		case 'accueil':
			updateAccueil();
		break;
	}
});

function rechercherProduit(saisie) {
	const laRecherche = $(saisie).val();

	let request = $.ajax({
		method: 'post',
		url: 'index.php?p=ajax&action=rechercherProduit',
		data: 'q=' + laRecherche
	});

	request.done(function (res) {
		let error = true;
		try {
			JSON.parse(res);
		} catch (e) {
			error = false;
		}

		const displayResultat = $('#lesRecherches');
		$('#accueil-content').hide();

		if (error) {
			displayResultat.text('Aucun produit disponible');
		} else {
			displayResultat.empty();
			displayResultat.append(res);
		}
	});

	request.fail(function (jqXHR, textStatus) {
		console.log("Erreur internal lors de la recherche de produits");
	});
}

function updateAccueil() {
	let request = $.ajax({
		method: 'get',
		url: 'index.php?p=ajax&action=updateAccueil'
	});

	request.done(function (res) {
		$('#accueil').empty();
		$('#accueil').append(res);
	});

	request.fail(function (jqXHR, textStatus) {
		console.log("Erreur interne lors de l'update panier");
	});
}
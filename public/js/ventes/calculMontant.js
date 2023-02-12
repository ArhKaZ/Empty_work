jQuery(document).ready(function () {
    $('.mp-add').on('click', function () {
        updateHT();
    });
    $('.mp-warper')
        .on('click', '.mp-remove', function () {
            updateHT();
        })
        .on('change', '.qte', function () {
            updateHT();
        });
    $('#commande_client_frais_livraison').on('change', function () {
        updateHT()
    })
    $('#commande_client_remise').on('change', function () {
        updateMontant()
    })
});

function updateHT() {
    let produits = $('.produits');
    let prix = 0;
    for (let i = 0; i < produits['length']; i++) {
        let p = produits[i].value;
        p = p.substr(p.indexOf('_') + 1);
        prix += parseFloat(p) * parseInt($('.qte')[i].value);
    }
    prix += parseFloat($('#commande_client_frais_livraison').val());
    $('#commande_client_ttht').val(prix.toFixed(2))
    updateTVA()
}

function updateTVA() {
    $('#commande_client_tva').val(
        $('#commande_client_ttht').val() * 0.2
    )
    updateTTC()
}

function updateTTC() {
    $('#commande_client_ttc').val(
        parseFloat($('#commande_client_ttht').val()) + parseFloat($('#commande_client_tva').val())
    )
    updateMontant()
}

function updateMontant() {
    $('#commande_client_montant').val(
        parseFloat($('#commande_client_ttc').val()) - parseFloat($('#commande_client_remise').val())
    )
}
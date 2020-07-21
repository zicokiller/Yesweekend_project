$('#add-image').click(function(){
    // On récupère le numéro des futurs champs que je l'on va créer
    const index = +$('#widgets-counter').val();
    // On récupère le prototype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
    // injection du code au sein de la div
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    handelDeleteButtons();
});

function handelDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter(){
    const count = +$('#ad_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();

handelDeleteButtons();
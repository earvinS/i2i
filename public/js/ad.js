$('#add-image').click(function(){
    //récupération des numéro des futurs champs crée
    const index = +$('#widgets-counter').val();

    //Récupération des prototype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/_name_/g, index);
    
    //injection du code au sein de la div
    $('#ad-images').append(tmpl);
    
    $('#widgets-counter').val(index + 1);
    //Gestion du btn supprimer
    handelDeleteButtons();

})

function handelDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    })
}

function updateCounter(){
    const count = $('#ad_images div.form-group').length;

    $('#widgets-couter').val(count);
}

updateCounter();
handelDeleteButtons();
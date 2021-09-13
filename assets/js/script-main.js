var $jq = jQuery.noConflict();
$jq(document).ready(function(){


    $jq(document).on( 'click', '#close-popup', function(e){
        e.preventDefault();
        $jq('#resultado-popup').remove();
    });



    $jq(document).on( 'click', '#add-prato', function(){

        $fields_index = $jq('fieldset.prato').length;

        $jq('#pratos').append('\
        <fieldset class="prato">\
            <p class="form-fiel field-text">\
                <label>Nome do prato <span class="req">*</span>\
                    <input type="text" name="prato[' + $fields_index + '][nome_do_prato]" value="" required placeholder="Nome do prato">\
                </label>\
            </p>\
            <p class="form-fiel field-text">\
                <label>Descrição do prato <span class="req">*</span>\
                    <input type="text" name="prato[' + $fields_index + '][prato_description]" value="" required placeholder="Acompanhamento">\
                </label>\
            </p>\
            <p class="form-fiel field-text">\
                <label>Preços <span class="req">*</span>\
                    <textarea rows="3" cols="80" name="prato[' + $fields_index + '][precos]">Pequena: R$ 10,00\nGrande: 15,00</textarea>\
                </label>\
            </p>\
            <p class="form-fiel field-select">\
                <label>Separador de linhas</label>\
                <select name="prato[' + $fields_index + '][separador]">\
                    <option value="linha">Linha em branco</option>\
                    <option value="===========================">==</option>\
                    <option value="---------------------------">--</option>\
                </select>\
            </p>\
        </fieldset>');

    });


});
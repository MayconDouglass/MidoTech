$(function () {
    $("#tableBase").DataTable({
        "autoWidth": false
    });
    $('#example1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });

    $('.select2').select2({
        dropdownParent: $("#CadastroModal"),
        width: '100%'
    });
    $('.select-notsearch').select2({
        dropdownParent: $("#CadastroModal"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    $("#cnpjcpf").mask("999.999.999-99");
    $("#telefone").mask("(999) 99999-9999");
    $("#cep").mask("99999-999");

    $("#pessoa").change(function () {
        var e = $(this).find('option:selected').attr('value')
        if (e == '1') {
            $("#cnpjcpf").unmask().mask("99.999.999/9999-99")
        } else {
            $("#cnpjcpf").unmask().mask("999.999.999-99")
        }
    });

    $("#tipovendedor").change(function () {
        var e = $(this).find('option:selected').attr('value')

        if (e == '1') {
            $("#supervisorcad").prop('disabled', true);
            $("#gerentecad").prop('disabled', false);
            $("#supervisorcad").select2({dropdownParent: $("#CadastroModal"), width: '100%',
                minimumResultsForSearch: Infinity}).val(0).trigger("change");
        } else if (e == '2') {
            $("#supervisorcad").prop('disabled', true);
            $("#gerentecad").prop('disabled', true);
            $("#supervisorcad").select2({dropdownParent: $("#CadastroModal"), width: '100%',
            minimumResultsForSearch: Infinity}).val(0).trigger("change");
            $("#gerentecad").select2({dropdownParent: $("#CadastroModal"), width: '100%',
                minimumResultsForSearch: Infinity}).val(0).trigger("change");
        }else if (e == '0') {
            $("#supervisorcad").prop('disabled', false);
            $("#gerentecad").prop('disabled', false);
        }

    });



    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#logradouro").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }



    $("#cep").blur(function () {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#logradouro").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})

$('#AlterarTabPrecoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var tabPrecoCod = button.data('codigo')
    var descricaoAlt = button.data('descricao')
    var empCodAlt = button.data('empresa')
    var preVendaAlt = button.data('prevenda')
    var pedWebAlt = button.data('pedidoweb')
    var statusAlt = button.data('status')

    $("#empresa_alt").select2({
        dropdownParent: $("#AlterarTabPrecoModal"), width: '100%',
    }).val(empCodAlt).trigger("change");

    $("#prevenda_alt").select2({
        dropdownParent: $("#AlterarTabPrecoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(preVendaAlt).trigger("change");

    $("#pedweb_alt").select2({
        dropdownParent: $("#AlterarTabPrecoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(pedWebAlt).trigger("change");

    $("#status_alt").select2({
        dropdownParent: $("#AlterarTabPrecoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");

    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idTabPrecoAlt').val(tabPrecoCod)
    modal.find('#descrical_alt').val(descricaoAlt)
})

$('#VisualizarTabPrecoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var tabPrecoCod = button.data('codigo')
    var descricaoView = button.data('descricao')
    var empCodView = button.data('empresa')
    var preVendaView = button.data('prevenda')
    var pedWebView = button.data('pedidoweb')
    var statusView = button.data('status')

    $("#empresa_view").select2({
        dropdownParent: $("#VisualizarTabPrecoModal"), width: '100%',
    }).val(empCodView).trigger("change");

    $("#prevenda_view").select2({
        dropdownParent: $("#VisualizarTabPrecoModal"), width: '100%',
    }).val(preVendaView).trigger("change");

    $("#pedweb_view").select2({
        dropdownParent: $("#VisualizarTabPrecoModal"), width: '100%',
    }).val(pedWebView).trigger("change");

    $("#status_view").select2({
        dropdownParent: $("#VisualizarTabPrecoModal"), width: '100%',
    }).val(statusView).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idTabPreco_view').val(tabPrecoCod)
    modal.find('#descricao_view').val(descricaoView)
})
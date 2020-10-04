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
});

$("#cnpjcpf").mask("999.999.999-99");

$("#pessoa").change(function () {
    var e = $(this).find('option:selected').attr('value')
    if (e == '1') {
        $("#cnpjcpf").unmask().mask("99.999.999/9999-99")
    } else {
        $("#cnpjcpf").unmask().mask("999.999.999-99")
    }
});

$("#cnpjcpf").blur(function () {
    var cnpj = $("#cnpjcpf").val().replace(/\D/g, '');
    var emp = $('#empresa').val();

    var e = $("#pessoa").find('option:selected').attr('value')

    $.ajax({
        type: 'get',
        dataType: 'json',
        url: "/emp/" + emp + "/cliente/" + cnpj,
        success: function (dados) {
            $('#idCliente').val(dados.id_cliente);
            $('#idDisabled').val(dados.id_cliente);
            $('#razao').val(dados.razao_social);
            $('#receita').val("Ok");
        },
        error: function (resultError) {
            $('#receita').val(resultError.responseJSON.erro);

        }

    })

    if ((e > '0')) {
        $.ajax({
            url: 'https://www.receitaws.com.br/v1/cnpj/' + cnpj,
            method: 'GET',
            dataType: 'jsonp',
            complete: function (xhr) {


                response = xhr.responseJSON;

                // Na documentação desta API tem esse campo status que retorna "OK" caso a consulta tenha sido efetuada com sucesso
                if (response.status == 'OK') {

                    // Agora preenchemos os campos com os valores retornados
                    $('#razao').val(response.nome);
                    $('#receita').val("Ok");

                    // Aqui exibimos uma mensagem caso tenha ocorrido algum erro
                } else {
                    //alert(response.message); // Neste caso estamos imprimindo a mensagem que a própria API retorna
                    $("#razao").val("");
                    $("#idCliente").val("");
                    $("#idDisabled").val("");
                    $('#receita').val(response.message);
                }
            }
        });
    }


});

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})

$('#AlterarModCobModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var modCobCodAlt = button.data('codigo')
    var descricaoAlt = button.data('descricao')
    var situacaoAlt = button.data('situacao')
    var naturezaAlt = button.data('natureza')
    var liberacaoAlt = button.data('liberacao')
    var pagNfeAlt = button.data('pagnfe')
    var statusAlt = button.data('status')
    var obsAlt = button.data('observacao')
    var usuCadAlt = button.data('usucad')
    var dataCadAlt = button.data('datacad')
    var usuAltAlt = button.data('usualt')
    var dataAltAlt = button.data('dataalt')

    $("#forma_alt").select2({
        dropdownParent: $("#AlterarModCobModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(pagNfeAlt).trigger("change");

    $("#situacao_alt").select2({
        dropdownParent: $("#AlterarModCobModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(situacaoAlt).trigger("change");

    $("#liberacao_alt").select2({
        dropdownParent: $("#AlterarModCobModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(liberacaoAlt).trigger("change");

    $("#status_alt").select2({
        dropdownParent: $("#AlterarModCobModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");

    $("#natureza_alt").select2({
        dropdownParent: $("#AlterarModCobModal"), width: '100%'
    }).val(naturezaAlt).trigger("change");

    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idModCob').val(modCobCodAlt)
    modal.find('#desc_alt').val(descricaoAlt)
    modal.find('#obs_alt').val(obsAlt)
})

$('#VisualizarModCobModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var modCobCodView = button.data('codigo')
    var descricaoView = button.data('descricao')
    var situacaoView = button.data('situacao')
    var naturezaView = button.data('natureza')
    var liberacaoView = button.data('liberacao')
    var pagNfeView = button.data('pagnfe')
    var statusView = button.data('status')
    var obsView = button.data('observacao')
    var usuCadView = button.data('usucad')
    var dataCadView = button.data('datacad')
    var usuAltView = button.data('usualt')
    var dataAltView = button.data('dataalt')

    $("#forma_view").select2({
        dropdownParent: $("#VisualizarModCobModal"), width: '100%',
    }).val(pagNfeView).trigger("change");

    $("#situacao_view").select2({
        dropdownParent: $("#VisualizarModCobModal"), width: '100%',
    }).val(situacaoView).trigger("change");

    $("#liberacao_view").select2({
        dropdownParent: $("#VisualizarModCobModal"), width: '100%',
    }).val(liberacaoView).trigger("change");

    $("#status_view").select2({
        dropdownParent: $("#VisualizarModCobModal"), width: '100%',
    }).val(statusView).trigger("change");

    $("#natureza_view").select2({
        dropdownParent: $("#VisualizarModCobModal"), width: '100%',
    }).val(naturezaView).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idModCob').val(modCobCodView)
    modal.find('#desc_view').val(descricaoView)
    modal.find('#obs_view').val(obsView)
})

$('#CadastroModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var empcod = button.data('codigo')

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('#empresa').val(empcod)
})
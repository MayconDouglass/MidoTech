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

    $(".editavel").dblclick(function () {
        var conteudoOriginal = $(this).text();

        $(this).addClass("celulaEmEdicao");
        $(this).html("<input type='text' value='" + conteudoOriginal + "' />");
        $(this).children().first().focus();

        $(this).children().first().keypress(function (e) {
            if (e.which == 13) {
                var novoConteudo = $(this).val();
                $(this).parent().text(novoConteudo);
                $(this).parent().removeClass("celulaEmEdicao");
            }
        });

        $(this).children().first().blur(function () {
            $(this).parent().text(conteudoOriginal);
            $(this).parent().removeClass("celulaEmEdicao");
        });
    });

    AddTableRow = function () {
        var newRow = $("<tr>"); var cols = "";
        cols += '<td>&nbsp;</td>'; cols += '<td >&nbsp;</td>'; cols += '<td>&nbsp;</td>'; cols += '<td>&nbsp;</td>'; cols += '<td>'; cols += '<button onclick="RemoveTableRow(this)" type="button">Remover</button>'; cols += '</td>';
        newRow.append(cols); $("#Parcelas").append(newRow);
        return false;
    };

    RemoveTableRow = function (handler) {
        var tr = $(handler).closest('tr');

        tr.fadeOut(400, function () {
            tr.remove();
        });

        return false;
    };

    AddRow = function () {

        var newRow = $("<tr>");
        var cols = "";
        cols += '<td class="editavel">Teste1</td>';
        cols += '<td class="editavel">Teste1fdg</td>';
        cols += '<td class="actions">';
        cols += '<button class="btn btn-danger btn-sm fa fa-trash-o" onclick="RemoveTableRow(this)" type="button">Remover</button>';
        cols += '</td>';


        newRow.append(cols);
        $("parcelas").append(newRow);

        return false;
    };

    $(document).on('click', '.teste', function () {
        var row = "<tr><td class='editavel'>1</td><td class='editavel'>1</td><td class='editavel'>2</td><td class='editavel'><button class='btn btn-danger btn-sm fa fa-trash-o' onclick='RemoveTableRow(this)' type='button'>Remover</button>'</td></tr>"
        $(this).closest('table').append(row);
    });

    
});

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})

$('#AlterarPrazoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var prazoCodAlt = button.data('codigo')
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
        dropdownParent: $("#AlterarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(pagNfeAlt).trigger("change");

    $("#situacao_alt").select2({
        dropdownParent: $("#AlterarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(situacaoAlt).trigger("change");

    $("#liberacao_alt").select2({
        dropdownParent: $("#AlterarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(liberacaoAlt).trigger("change");

    $("#status_alt").select2({
        dropdownParent: $("#AlterarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");

    $("#natureza_alt").select2({
        dropdownParent: $("#AlterarPrazoModal"), width: '100%'
    }).val(naturezaAlt).trigger("change");

    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idPrazo').val(prazoCodAlt)
    modal.find('#desc_alt').val(descricaoAlt)
    modal.find('#obs_alt').val(obsAlt)
})

$('#VisualizarPrazoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var prazoCodView = button.data('codigo')
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
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%',
    }).val(pagNfeView).trigger("change");

    $("#situacao_view").select2({
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%',
    }).val(situacaoView).trigger("change");

    $("#liberacao_view").select2({
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%',
    }).val(liberacaoView).trigger("change");

    $("#status_view").select2({
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%',
    }).val(statusView).trigger("change");

    $("#natureza_view").select2({
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%',
    }).val(naturezaView).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idPrazo').val(prazoCodView)
    modal.find('#desc_view').val(descricaoView)
    modal.find('#obs_view').val(obsView)
})
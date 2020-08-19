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

    $(".editave2l").dblclick(function () {
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
        var numParcelas = $("input[type=number][name=parcelascad]").val();
        var linhasTab = $('#listaparcelas').find('tr').length;
        if ((numParcelas - linhasTab) + 1 > 0) {
            var newRow = $("<tr>"); var cols = "";
            cols += '<td class="editavel" name="parcela" id="idParcela">';
            cols += linhasTab;
            cols += '</td>';
            cols += '<td class="editavel" name="porcentagemcad'.concat(linhasTab) + '" id="porcentPar">100</td>';
            cols += '<td class="editavel" name="intervalocad'.concat(linhasTab) + '" id="intervaloPar">1</td>';
            cols += '<td class="editavel">Dias</td>';
            cols += '<td>';
            cols += '<button class="btn btn-danger btn-sm btn-xs" onclick="RemoveTableRow(this)" type="button"> Remover</button> ';
            cols += '<td>';

            newRow.append(cols);

            $("#listaparcelas").append(newRow);

            return false;
        }
    };

    EditTableRow = function () {

        $(".editavel").dblclick(function () {
            var conteudoOriginal = $(this).text();


            $(this).html("<input type='text' value='" + conteudoOriginal + "' />");
            $(this).children().first().focus().select();

            $(this).children().first().keypress(function (e) {
                if (e.which == 13 || e.wich == 9) {
                    var novoConteudo = $(this).val();
                    $(this).parent().text(novoConteudo);

                }
            });

            $(this).children().first().blur(function () {
                $(this).parent().text(conteudoOriginal);

            });
        });

    }

    RemoveTableRow = function (handler) {
        var tr = $(handler).closest('tr');

        tr.fadeOut(400, function () {
            tr.remove();
        });

        return false;
    };
    //.concat(linhasTab)
    $(document).on("click", "#btnSalvarParcelas", function (evt) {
        //var linhasTab = $('#listaparcelas').find('tr').length;
        $.ajax({
            type: "post",
            url: $server + "/prazopagamento/cad",
            data: {
                parcela: index,
                porcentagem: $("#porcentagemcad").val(),
                prazo: $("#intervalocad").val(),
                tipo: 1
            },
            success: function (data) {
                intel.xdk.notification.alert('Parcela cadastrada');
            }
        });
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
    var taxaDiarioAlt = button.data('taxa_diario')
    var multaAtrasoAlt = button.data('multa_atraso')
    var acrescimoAlt = button.data('acrescimo')
    var descPrazoAlt = button.data('desc_prazo')
    var statusAlt = button.data('status')

    $("#status_alt").select2({
        dropdownParent: $("#AlterarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");

    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idPrazo_alt').val(prazoCodAlt)
    modal.find('#descricao_alt').val(descricaoAlt)
    modal.find('#taxajuros_alt').val(taxaDiarioAlt)
    modal.find('#multa_alt').val(multaAtrasoAlt)
    modal.find('#acrescimo_alt').val(acrescimoAlt)
    modal.find('#desconto_alt').val(descPrazoAlt)
})

$('#VisualizarPrazoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var prazoCodView = button.data('codigo')
    var descricaoView = button.data('descricao')
    var taxaDiarioView = button.data('taxa_diario')
    var multaAtrasoView = button.data('multa_atraso')
    var acrescimoView = button.data('acrescimo')
    var descPrazoView = button.data('desc_prazo')
    var tipoView = button.data('tipo')
    var parcelasView = button.data('parcelas')
    var intervaloView = button.data('intervalo')
    var statusView = button.data('status')

    $("#statusView").select2({
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(statusView).trigger("change");

    $("#tipoView").select2({
        dropdownParent: $("#VisualizarPrazoModal"), width: '100%', minimumResultsForSearch: Infinity
    }).val(tipoView).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idPrazoView').val(prazoCodView)
    modal.find('#descricaoView').val(descricaoView)
    modal.find('#taxajurosView').val(taxaDiarioView)
    modal.find('#multaView').val(multaAtrasoView)
    modal.find('#acrescimoView').val(acrescimoView)
    modal.find('#descontoView').val(descPrazoView)
    modal.find('#parcelasView').val(parcelasView)
    modal.find('#diasView').val(intervaloView)
})
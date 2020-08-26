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
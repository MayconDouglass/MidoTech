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

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})


$('#VisualizarSetorModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var setorCod = button.data('codigo')
    var setorView = button.data('setor')
    var ufView = button.data('estado')
    var empCodView = button.data('empresa')
    var statusView = button.data('status')

    $("#empresaalt").select2({
        dropdownParent: $("#VisualizarSetorModal"), width: '100%',
    }).val(empCodView).trigger("change");
    $("#statusalt").select2({
        dropdownParent: $("#VisualizarSetorModal"), width: '100%',
    }).val(statusView).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idSetor').val(setorCod)
    modal.find('#setoralt').val(setorView)
    modal.find('#ufalt').val(ufView)
})


$('#AlterarSetorModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var setorCod = button.data('codigo')
    var setorAlt = button.data('setor')
    var ufAlt = button.data('estado')
    var empCodAlt = button.data('empresa')
    var statusAlt = button.data('status')

    $("#empresaalt").select2({
        dropdownParent: $("#AlterarSetorModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(empCodAlt).trigger("change");
    $("#statusalt").select2({
        dropdownParent: $("#AlterarSetorModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idSetor').val(setorCod)
    modal.find('#setoralt').val(setorAlt)
    modal.find('#ufalt').val(ufAlt)
})
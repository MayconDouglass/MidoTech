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

$('#AlterarModCobModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var userCodAlt = button.data('codigo')

    $("#ativa_alt").select2({
        dropdownParent: $("#AlterarUserModal"), width: '100%',
    }).val(statusAlt).trigger("change");
    
    
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#user_cod').val(userCodAlt)
})

$('#VisualizarPerfilModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var perfilCodView = button.data('codigo')
   
   
    $("#status_view").select2({
        dropdownParent: $("#VisualisarPerfilModal"), 
        width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusView).trigger("change");


    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#idPerfil_view').val(perfilCodView)
})
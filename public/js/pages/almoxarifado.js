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

$('#AlteracaoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idAlmoxarifado = button.data('codigo')
    var tipo = button.data('tipo')
    var status = button.data('status')
    var qtd = button.data('qtd')

    $("#tipoalt").select2({
        dropdownParent: $("#AlteracaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipo).trigger("change");

    $("#statusalt").select2({
        dropdownParent: $("#AlteracaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(status).trigger("change");

    $("#qtdalt").select2({
        dropdownParent: $("#AlteracaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(qtd).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idAlmo').val(idAlmoxarifado)
})

$('#VisualizarModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idAlmoxarifado = button.data('codigo')
    var tipo = button.data('tipo')
    var status = button.data('status')
    var qtd = button.data('qtd')

    $("#tipoview").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipo).trigger("change");

    $("#statusview").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(status).trigger("change");

    $("#qtdview").select2({
        dropdownParent: $("#VisualizarModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(qtd).trigger("change");

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')

})

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})

$('#LocalizacaoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idAlmo = button.data('codigo')

    $.getJSON('/api/almoxarifado/' + idAlmo, function (data) {
        var employee_data = '';
        var token = $('meta[name="csrf-token"]').attr('content');
        var status = '';
        var tipo = '';

        switch (data.status) {
            case 0:
                status = 'Inativo'
                break;

            case 1:
                status = 'Ativo'
                break;

            default:
                status = 'Error'
                break;
        }

        $.each(data.al_localizacao, function (key, value) {

            switch (value.tipo) {
                case 0:
                    tipo = 'Pulmão'
                    break;

                case 1:
                    tipo = 'Picking'
                    break;

                default:
                    tipo = 'Nenhum'
                    break;
            }

            employee_data += '<tr>';
            employee_data += '<td name="check"><input class="link-check" type="checkbox" id="input' + value.id_localizacao + '" name="input' + value.id_localizacao + '"></td>';
            employee_data += '<td>' + value.id_localizacao + '</td>';
            employee_data += '<td>' + data.codigo + '</td>';
            employee_data += '<td name="local' + value.id_localizacao + '">' + value.localiza_fisica + '</td>';
            employee_data += '<td>' + tipo + '</td>';
            employee_data += '<td>' + status + '</td>';
            employee_data += '</tr>';
        });
        $('#localizatab').prepend(employee_data);
    });

    var modal = $(this)
    modal.find('.modal-title').text('Visualizar/Cadastro Localização')
    modal.find('#idAlmo').val(idAlmo)
})
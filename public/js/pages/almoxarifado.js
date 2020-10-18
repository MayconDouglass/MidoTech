$(function () {

    $(document).on('change', '.form-check-input', function (e) {
        $thatRow = $(this);
        let local = $thatRow.closest('tr').find('td').eq(1).text();

        if (local == '') {
            $("#canButton").prop('disabled', true);
            $("#attButton").prop('disabled', true);
        } else {
            $("#canButton").prop('disabled', false);
            $("#attButton").prop('disabled', false);
            $("#saveButton").prop('disabled', true);
            $("#localizatab").find("input").prop("disabled", "disabled");
            
            $.getJSON('/api/almoxarifado/local/' + local, function (data) {
                $("#idLocal").val(data.id_localizacao);
                $("#Alcod").val(data.al_cod);
                $("#locfisica").val(data.localiza_fisica);
                $("#ean").val(data.ean);
                $("#capacidade").val(data.capacidade);
                $("#tipo").select2({
                    dropdownParent: $("#LocalizacaoModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(data.tipo).trigger("change");
                $("#status").select2({
                    dropdownParent: $("#LocalizacaoModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(data.status).trigger("change");
            });

            $("#canButton").click(function () {
                $("#idLocal").val('');
                $("#Alcod").val('');
                $("#locfisica").val('');
                $("#ean").val('');
                $("#capacidade").val('');
                $("#tipo").select2({
                    dropdownParent: $("#LocalizacaoModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");
                $("#status").select2({
                    dropdownParent: $("#LocalizacaoModal"), width: '100%',
                    minimumResultsForSearch: Infinity
                }).val(0).trigger("change");
                $("#canButton").prop('disabled', true);
                $("#attButton").prop('disabled', true);
                $("#saveButton").prop('disabled', false);
                $("#localizatab").find("input").prop("disabled", false);
            });

            $("#attButton").click(function () {
                idLocal = $("#idLocal").val();
                idAlmo = $("#Alcod").val();
                $.ajax({
                    url: '/api/localizacao/'+idLocal,
                    data: {
                        localiza_fisica: $("#locfisica").val(),
                        ean: $("#ean").val(),
                        capacidade: $("#capacidade").val(),
                        tipo: $("#tipo").val(),
                        status: $("#status").val()                     
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    success: function (result) {
                        exibirAtualizadoSucesso();
                        setTimeout(function () {
                            exibirAtualizadoSucesso();
                            $('#div_status').hide();
                        }, 5000);
                        $("#idLocal").val('');
                        $("#Alcod").val('');
                        $("#locfisica").val('');
                        $("#ean").val('');
                        $("#capacidade").val('');
                        $("#tipo").select2({
                            dropdownParent: $("#LocalizacaoModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");
                        $("#status").select2({
                            dropdownParent: $("#LocalizacaoModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");
                        $("#canButton").prop('disabled', true);
                        $("#attButton").prop('disabled', true);
                        $("#saveButton").prop('disabled', false);
                        $("#localizatab").find("input").prop("disabled", false);           
                    },
                    error: function(result){
                        exibirAtualizadoErro();
                        setTimeout(function () {
                            exibirAtualizadoErro();
                            $('#div_status_erro').hide();
                        }, 5000);
                        $("#idLocal").val('');
                        $("#Alcod").val('');
                        $("#locfisica").val('');
                        $("#ean").val('');
                        $("#capacidade").val('');
                        $("#tipo").select2({
                            dropdownParent: $("#LocalizacaoModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");
                        $("#status").select2({
                            dropdownParent: $("#LocalizacaoModal"), width: '100%',
                            minimumResultsForSearch: Infinity
                        }).val(0).trigger("change");
                        $("#canButton").prop('disabled', true);
                        $("#attButton").prop('disabled', true);
                        $("#saveButton").prop('disabled', false);
                        $("#localizatab").find("input").prop("disabled", false);     
                    }
                });

                
                $.getJSON('/api/almoxarifado/'+idAlmo, function (data) {
                    var employee_data = '';
                    var status = '';
                    var tipo = '';
                    $('#localizatab').DataTable().clear().draw();
                    $('#localizatab').DataTable().destroy();

                    $.each(data.al_localizacao, function (key, value) {

                        switch (value.status) {
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

                        switch (value.tipo) {
                            case 0:
                                tipo = 'Normal'
                                break;

                            case 1:
                                tipo = 'Pulmão'
                                break;

                            case 2:
                                tipo = 'Picking'
                                break;

                            default:
                                tipo = 'Nenhum'
                                break;
                        }

                        employee_data += '<tr>';
                        employee_data += '<td><div class="form-check"><input class="form-check-input" type="radio" name="radio" id="radio' + value.id_localizacao + '"></td>';
                        employee_data += '<td>' + value.id_localizacao + '</td>';
                        employee_data += '<td>' + data.codigo + '</td>';
                        employee_data += '<td>' + value.localiza_fisica + '</td>';
                        employee_data += '<td>' + tipo + '</td>';
                        employee_data += '<td>' + status + '</div></td>';
                        employee_data += '</tr>';
                    });
                    $('#localizatab').prepend(employee_data);
                });

            });
        }


    });


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

    $('#locfisica').mask('A9-A9-A9-A9');
    $("#ean").mask('9999999999999');
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

$('#LocalizacaoModal').on('hidden.bs.modal', function (e) {
    $('#localizatab').DataTable().clear().draw();
    $('#localizatab').DataTable().destroy();
    $("#idLocal").val('');
    $("#Alcod").val('');
    $("#locfisica").val('');
    $("#ean").val('');
    $("#capacidade").val('');
    $("#tipo").select2({
        dropdownParent: $("#LocalizacaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(0).trigger("change");
    $("#status").select2({
        dropdownParent: $("#LocalizacaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(0).trigger("change");
});

$('#LocalizacaoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idAlmo = button.data('codigo')
    $("#tipo").select2({
        dropdownParent: $("#LocalizacaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(0).trigger("change");
    $("#status").select2({
        dropdownParent: $("#LocalizacaoModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(0).trigger("change");


    $.getJSON('/api/almoxarifado/' + idAlmo, function (data) {
        var employee_data = '';
        var status = '';
        var tipo = '';

        
        $.each(data.al_localizacao, function (key, value) {
            switch (value.status) {
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

            switch (value.tipo) {
                case 0:
                    tipo = 'Normal'
                    break;

                case 1:
                    tipo = 'Pulmão'
                    break;

                case 2:
                    tipo = 'Picking'
                    break;

                default:
                    tipo = 'Nenhum'
                    break;
            }

            employee_data += '<tr>';
            employee_data += '<td><div class="form-check"><input class="form-check-input" type="radio" name="radio" id="radio' + value.id_localizacao + '"></td>';
            employee_data += '<td>' + value.id_localizacao + '</td>';
            employee_data += '<td>' + data.codigo + '</td>';
            employee_data += '<td>' + value.localiza_fisica + '</td>';
            employee_data += '<td>' + tipo + '</td>';
            employee_data += '<td>' + status + '</div></td>';
            employee_data += '</tr>';
        });
        $('#localizatab').prepend(employee_data);
    });


    var modal = $(this)
    modal.find('.modal-title').text('Visualizar/Cadastro Localização')
    modal.find('#idAlmo').val(idAlmo)
})

function exibirAtualizadoSucesso() {
    $("#div_status").removeClass("d-none");
}
function exibirAtualizadoErro() {
    $("#div_status_erro").removeClass("d-none");
}
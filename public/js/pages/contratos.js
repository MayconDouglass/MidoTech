$(function () {
    var path = [];
    $(document).on('change', '.link-check', function (e) {
        $thatRow = $(this);
        let file = $thatRow.closest('tr').find('td').eq(2).text();
        let idFile = $thatRow.closest('tr').find('td').eq(1).text();

        console.log();
        if ($('#input' + idFile).prop('checked')) {
            path.push(file);
        } else {
            var index = path.indexOf(file);
            path.splice(index, 1);
        }

        $('#fileDel').val(path);
        let textoArray = $('#fileDel').val();
        if (textoArray == '') {
            $("#deleteButton").prop('disabled', true);
        } else {
            $("#deleteButton").prop('disabled', false);
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

$('#AlterarContratoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var contratoCod = button.data('codigo')

    $.getJSON('/contrato/' + contratoCod, function (data) {

        $("#razaoAlt").val(data.razao_social);
        $("#valorAlt").val(data.valor);
        $("#descontoAlt").val(data.desconto);

        $("#basico_alt").prop("checked", data.basico ? true : false);
        $("#nfs_alt").prop("checked", data.nfs ? true : false);
        $("#nfe_alt").prop("checked", data.nfe ? true : false);
        $("#nfce_alt").prop("checked", data.nfce ? true : false);
        $("#cfesat_alt").prop("checked", data.cfe_sat ? true : false);
        $("#mfe_alt").prop("checked", data.mfe ? true : false);
        $("#mde_alt").prop("checked", data.mde ? true : false);
        $("#mdfe_alt").prop("checked", data.mdfe ? true : false);
        $("#cte_alt").prop("checked", data.cte ? true : false);
        $("#contrato_alt").prop("checked", data.contratos ? true : false);
        $("#servico_alt").prop("checked", data.servicos ? true : false);

        $("#statusAlt").select2({
            dropdownParent: $("#AlterarContratoModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.status).trigger("change");


    });
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#idContrato').val(contratoCod)
})

$('#ArquivosModal').on('hidden.bs.modal', function (e) {
    $('#filestab').DataTable().clear().draw();
    $('#filestab').DataTable().destroy();
});


$('#ArquivosModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var contratoCod = button.data('codigo')


    $.getJSON('/contrato/' + contratoCod, function (data) {
        var employee_data = '';
        var token = $('meta[name="csrf-token"]').attr('content');

        $.each(data.contrato_arquivos, function (key, value) {
            var extensao = value.path.substring(value.path.lastIndexOf("/") + 1);
            employee_data += '<tr>';
            employee_data += '<td><input class="link-check" type="checkbox" id="input' + value.id_arquivo + '" name="input' + value.id_arquivo + '"></td>';
            employee_data += '<td>' + value.id_arquivo + '</td>';
            employee_data += '<td name="file' + value.id_arquivo + '">' + value.path + '</td>';
            employee_data += '<td>' + ' <div class="btn-group btn-group-sm">';
            employee_data += '<a href="storage/' + value.path + '" target="_blank" class="btn btn-info" ><i class="fas fa-eye"></i></a></div> </td>';
            employee_data += '</tr>';
        });
        $('#filestab').prepend(employee_data);
    });


    var modal = $(this)
    modal.find('.modal-title').text('Arquivos Anexados')
    modal.find('#idContrato').val(contratoCod)
});


$('#VisualizarModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idContrato = button.data('codigo')
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/api/contratos/' + idContrato,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (result) {
            let status = '';
            switch (result.status) {
                case 0:
                    status = 'Inativo'
                    $("#statusview").addClass('status-6')
                    $("#statusview").removeClass(['status-3','status-5'])
                    break;
                case 1:
                    status = 'Ativo'
                    $("#statusview").removeClass(['status-3','status-6'])
                    $("#statusview").addClass('status-5')
                    break;

                default:
                    $("#statusview").removeClass(['status-5','status-6'])
                    $("#statusview").addClass('status-3')
                    status = 'Error'
                    break;
            }

            modal.find("#propostaview").val(result.proposta)
            modal.find("#clienteview").val(result.razao_social)
            modal.find("#statusview").val(status)
            modal.find("#datacadview").val(dataFormatada(result.data_cad))
            modal.find("#dataaltview").val(result.data_alt ? dataFormatada(result.data_alt) : "Sem Alteração")
            modal.find("#datafechaview").val(result.data_fechamento ? dataFormatada(result.data_fechamento) : "Em Aberto")
            modal.find("#valorview").val(formatter.format(result.valor))
            modal.find("#descontoview").val(result.desconto)
            modal.find("#newvalorview").val(formatter.format(((100 -result.desconto)/100)*result.valor))
      
        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    });

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
})

$('#CadastroModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var empcod = button.data('codigo')

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('#empresa').val(empcod)
})

//preview upload
$('#customFileAlt').change(function () {
    const file = $(this)[0].files
    const fileReader = new FileReader()
    const countFiles = [];

    for (var i = 0; i < file.length; i++) {
        countFiles.push(file[i].name);
    }

    $('#arquivoAlt').text('Total de itens selecionados: ' + countFiles.length)
})

$('#customFileCad').change(function () {
    const file = $(this)[0].files
    const fileReader = new FileReader()
    const countFiles = [];

    for (var i = 0; i < file.length; i++) {
        countFiles.push(file[i].name);
    }

    $('#arquivoCad').text('Total de itens selecionados: ' + countFiles.length)
})

function dataFormatada(date) {
    var data = new Date(date);

    if (data.getDate() < 10) {
        dia = "0" + data.getDate();
    } else {
        dia = data.getDate();
    }

    if ((data.getMonth() + 1) < 10) {
        mes = "0" + (data.getMonth() + 1);
    } else {
        mes = data.getMonth() + 1;
    }

    ano = data.getFullYear();

    return [dia, mes, ano].join('/');
}
var formatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2,
});
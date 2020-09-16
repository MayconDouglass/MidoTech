$(function () {
    $("#tableBase2").DataTable({
        "autoWidth": false,
        "searching": false,
        "paging": false,
        "info": false,
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
        width: '100%'
    });
    $('.select-notsearch').select2({
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    var idCliente = $("#idCliente").val();

    $.getJSON('/api/climov/' + idCliente, function (data) {
        var employee_data = '';
        var status_nota = '';
        var tipo_nota = '';
        var nStatus = 2;
        $.each(data, function (key, value) {
            switch (value.tipo) {
                case 1:
                    tipo_nota = '<td>Devolução</td>';
                    nStatus = 6;
                    break;

                case 2:
                    tipo_nota = '<td>Devolução - S. Remessa</td>';
                    nStatus = 6;
                    break;

                case 3:
                    tipo_nota = '<td>Devolução - Transferência</td>';
                    nStatus = 6;
                    break;

                case 4:
                    tipo_nota = '<td> Comp. - Devolução </td>';
                    nStatus = 6;
                    break;

                case 5:
                    tipo_nota = '<td>Venda Normal</td>';
                    nStatus = 5;
                    break;

                case 6:
                    tipo_nota = '<td>Bonificação</td>';
                    nStatus = 1;
                    break;


                case 7:
                    tipo_nota = '<td>Complemento</td>';
                    nStatus = 5;
                    break;

                case 8:
                    tipo_nota = '<td>Saída p/ Consignação</td>';
                    nStatus = 5;
                    break;

                case 9:
                    tipo_nota = '<td>Simples Remessa</td>';
                    nStatus = 5;
                    break;

                case 10:
                    tipo_nota = '<td>Transferência</td>';
                    nStatus = 5;
                    break;

                case 11:
                    tipo_nota = '<td>Orçamento</td>';
                    nStatus = 1;
                    break;

                default:
                    tipo_nota = '<td> ERRO </td>';
                    nStatus = 3;
                    break;
            }

            switch (value.status) {
                case 1:
                    status_nota = '<td> Faturada </td>';
                    nStatus = 1;
                    break;

                case 2:
                    status_nota = '<td> Enviada </td>';
                    nStatus = 1;
                    break;

                case 3:
                    status_nota = '<td> Rejeitada </td>';
                    nStatus = 1;
                    break;

                case 4:
                    status_nota = '<td> Denegada </td>';
                    nStatus = 1;
                    break;

                case 5:
                    status_nota = '<td> Autorizada </td>';
                    break;

                case 6:
                    status_nota = '<td> Cancelada </td>';
                    nStatus = 1;
                    break;

                case 7:
                    status_nota = '<td> Inutilizada </td>';
                    nStatus = 1;
                    break;

                case 8:
                    status_nota = '<td> Autorizada ORC </td>';
                    nStatus = 5;
                    break;

                default:
                    status_nota = '<td> ERRO </td>';
                    nStatus = 3;
                    break;
            }

            employee_data += '<tr class="status-' + nStatus + '">';
            employee_data += '<td>' + value.num_doc + '</td>';
            employee_data += '<td>' + value.serie_doc + '</td>';
            employee_data += '<td>' + formatter.format(value.valor_brut) + '</td>';
            employee_data += '<td>' + formatter.format(value.valor_liq) + '</td>';
            employee_data += tipo_nota;
            employee_data += '<td>' + dataFormatada(value.data_mov) + '</td>';
            employee_data += status_nota;
            employee_data += '</tr>';
        });
        $('#historico').append(employee_data);
    });

    var today = new Date();

    $.getJSON('/api/clientes/' + idCliente, function (data) {
        var dateCred = dataFormatada(data.venc_limite_cred);
        $("#razao").text(data.razao_social);
        $("#limitecred").text(formatter.format(data.limite_cred));

        if (dateCred == dataFormatada(today)) {
            $("#venclimitecred").text(dateCred).addClass("badge badge-warning");
        } else if (dateCred >= dataFormatada(today)) {
            $("#venclimitecred").text(dateCred).addClass("badge badge-success");
        } else {
            $("#venclimitecred").text(dateCred).addClass("badge badge-danger");
        }

        switch (data.status) {
            case 0:
                $("#status").text("Normal").addClass("badge badge-success");
                break;
            case 1:
                $("#status").text("Venda Suspensa").addClass("badge badge-warning");
                break;
            case 2:
                $("#status").text("Bloqueado").addClass("badge badge-repfinanceiro");
                break;
            case 3:
                $("#status").text("Inativo").addClass("badge badge-danger");
                break;
            default:
                $("#status").text("ERRO").addClass("badge badge-info");
                break;
        }

    });

    var formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2,
    });

});

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

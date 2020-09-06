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
    $("#cep_alt").mask("99999-999");

    $("#pessoa").change(function () {
        var e = $(this).find('option:selected').attr('value')
        if (e == '1') {
            $("#cnpjcpf").unmask().mask("99.999.999/9999-99")
        } else {
            $("#cnpjcpf").unmask().mask("999.999.999-99")
        }
    });

    $("#tipovendedorcad").change(function () {
        var e = $(this).find('option:selected').attr('value')

        if (e == '1') {
            $("#supervisorcad").prop('disabled', true);
            $("#gerentecad").prop('disabled', false);
            $("#supervisorcad").select2({
                dropdownParent: $("#CadastroModal"), width: '100%',
                minimumResultsForSearch: Infinity
            }).val(0).trigger("change");
        } else if (e == '2') {
            $("#supervisorcad").prop('disabled', true);
            $("#gerentecad").prop('disabled', true);
            $("#supervisorcad").select2({
                dropdownParent: $("#CadastroModal"), width: '100%',
                minimumResultsForSearch: Infinity
            }).val(0).trigger("change");
            $("#gerentecad").select2({
                dropdownParent: $("#CadastroModal"), width: '100%',
                minimumResultsForSearch: Infinity
            }).val(0).trigger("change");
        } else if (e == '0') {
            $("#supervisorcad").prop('disabled', false);
            $("#gerentecad").prop('disabled', false);
        }

    });

    $("#tipovendedor_alt").change(function () {
        var e = $(this).find('option:selected').attr('value')

        if (e == '1') {
            $("#supervisor_alt").prop('disabled', true);
            $("#gerente_alt").prop('disabled', false);
            $("#supervisor_alt").select2({
                dropdownParent: $("#AlterarVenModal"), width: '100%',
                minimumResultsForSearch: Infinity
            }).val(0).trigger("change");
        } else if (e == '2') {
            $("#supervisor_alt").prop('disabled', true);
            $("#gerente_alt").prop('disabled', true);
            $("#supervisor_alt").select2({
                dropdownParent: $("#AlterarVenModal"), width: '100%',
                minimumResultsForSearch: Infinity
            }).val(0).trigger("change");
            $("#gerente_alt").select2({
                dropdownParent: $("#AlterarVenModal"), width: '100%',
                minimumResultsForSearch: Infinity
            }).val(0).trigger("change");
        } else if (e == '0') {
            $("#supervisor_alt").prop('disabled', false);
            $("#gerente_alt").prop('disabled', false);
        }

    });

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#logradouro").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }

    function limpa_formulário_cepAlt() {
        // Limpa valores do formulário de cep.
        $("#logradouro_alt").val("");
        $("#bairro_alt").val("");
        $("#cidade_alt").val("");
        $("#uf_alt").val("");
    }

    $("#cep").blur(function () {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#logradouro").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });

    $("#cep_alt").blur(function () {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#logradouro_alt").val("...");
                $("#bairro_alt").val("...");
                $("#cidade_alt").val("...");
                $("#uf_alt").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro_alt").val(dados.logradouro);
                        $("#bairro_alt").val(dados.bairro);
                        $("#cidade_alt").val(dados.localidade);
                        $("#uf_alt").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cepAlt();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cepAlt();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cepAlt();
        }
    });
});

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})


$('#VisualizarVenModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var venCodView = button.data('codigo')
    var empCodView = button.data('emp-cod')
    var nomeView = button.data('nome')
    var cnpjcpfView = button.data('cnpjcpf')
    var pessoaView = button.data('pessoa')
    var tipoView = button.data('tipo')
    var supervisorView = button.data('supervisor')
    var gerenteView = button.data('gerente')
    var emailView = button.data('email')
    var pedminView = button.data('pedido-min')
    var comissaoView = button.data('comissao')
    var pagoEmissaoView = button.data('pago-emissao')
    var pagoBaixaView = button.data('pago-baixa')
    var descontoMaxView = button.data('desconto')
    var telefoneView = button.data('telefone')
    var logradouroView = button.data('logradouro')
    var numeroView = button.data('numero')
    var bairroView = button.data('bairro')
    var compView = button.data('comp')
    var cidadeView = button.data('cidade')
    var cepView = button.data('cep')
    var ufView = button.data('estado')
    var setorView = button.data('setor')
    var statusView = button.data('status')

    $("#empresa_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
    }).val(empCodView).trigger("change");

    $("#status_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
    }).val(statusView).trigger("change");

    $("#setor_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
    }).val(setorView).trigger("change");

    
    $("#pessoa_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(pessoaView).trigger("change");

    $("#tipovendedor_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipoView).trigger("change");

    $("#supervisor_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
    }).val(supervisorView).trigger("change");

    $("#gerente_view").select2({
        dropdownParent: $("#VisualizarVenModal"), width: '100%',
    }).val(gerenteView).trigger("change");

    // modo de cobranca
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'vendedores/ModCob',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': venCodView
        },
        success: function (result) {
            
            $("#modCob_view").val(result[0]).trigger("change");

        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    // prazo de pagamento
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'vendedores/PrazoPag',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': venCodView
        },
        success: function (result) {
            
            $("#tabPrazo_view").val(result[0]).trigger("change");

        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    // tabela de preco
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'vendedores/TabPreco',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': venCodView
        },
        success: function (result) {
            
            $("#tabPreco_view").val(result[0]).trigger("change");

        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#vencod_view').val(venCodView)
    modal.find('#nome_view').val(nomeView)
    modal.find('#cnpjcpf_view').val(cnpjcpfView)
    modal.find('#email_view').val(emailView)
    modal.find('#pedmin_view').val(pedminView)
    modal.find('#comissao_view').val(comissaoView)
    modal.find('#pagoemissao_view').val(pagoEmissaoView)
    modal.find('#pagobaixa_view').val(pagoBaixaView)
    modal.find('#desconto_view').val(descontoMaxView)
    modal.find('#telefone_view').val(telefoneView)
    modal.find('#logradouro_view').val(logradouroView)
    modal.find('#numero_view').val(numeroView)
    modal.find('#complemento_view').val(compView)
    modal.find('#bairro_view').val(bairroView)
    modal.find('#cidade_view').val(cidadeView)
    modal.find('#uf_view').val(ufView)
    modal.find('#cep_view').val(cepView)

})


$('#AlterarVenModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var venCodAlt = button.data('codigo')
    var empCodAlt = button.data('emp-cod')
    var nomeAlt = button.data('nome')
    var cnpjcpfAlt = button.data('cnpjcpf')
    var pessoaAlt = button.data('pessoa')
    var tipoAlt = button.data('tipo')
    var supervisorAlt = button.data('supervisor')
    var gerenteAlt = button.data('gerente')
    var emailAlt = button.data('email')
    var pedminAlt = button.data('pedido-min')
    var comissaoAlt = button.data('comissao')
    var pagoEmissaoAlt = button.data('pago-emissao')
    var pagoBaixaAlt = button.data('pago-baixa')
    var descontoMaxAlt = button.data('desconto')
    var telefoneAlt = button.data('telefone')
    var logradouroAlt = button.data('logradouro')
    var numeroAlt = button.data('numero')
    var bairroAlt = button.data('bairro')
    var compAlt = button.data('comp')
    var cidadeAlt = button.data('cidade')
    var cepAlt = button.data('cep')
    var ufAlt = button.data('estado')
    var setorAlt = button.data('setor')
    var statusAlt = button.data('status')

    $("#empresa_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    }).val(empCodAlt).trigger("change");

    $("#status_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(statusAlt).trigger("change");

    $("#setor_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    }).val(setorAlt).trigger("change");

    $("#pessoa_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(pessoaAlt).trigger("change");

    $("#tipovendedor_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
        minimumResultsForSearch: Infinity
    }).val(tipoAlt).trigger("change");

    $("#supervisor_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    }).val(supervisorAlt).trigger("change");

    $("#gerente_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    }).val(gerenteAlt).trigger("change");

    $("#tabPreco_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    });

    $("#modCob_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    });

    $("#tabPrazo_alt").select2({
        dropdownParent: $("#AlterarVenModal"), width: '100%',
    });

    //modo de cobranca
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'vendedores/ModCob',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': venCodAlt
        },
        success: function (result) {
            
            $("#modCob_alt").val(result[0]).trigger("change");

        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    // prazo de pagamento
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'vendedores/PrazoPag',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': venCodAlt
        },
        success: function (result) {
            
            $("#tabPrazo_alt").val(result[0]).trigger("change");

        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    //tabela de preco
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'vendedores/TabPreco',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': venCodAlt
        },
        success: function (result) {
            
            $("#tabPreco_alt").val(result[0]).trigger("change");

        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#vencod_alt').val(venCodAlt)
    modal.find('#nome_alt').val(nomeAlt)
    modal.find('#cnpjcpf_alt').val(cnpjcpfAlt)
    modal.find('#email_alt').val(emailAlt)
    modal.find('#pedmin_alt').val(pedminAlt)
    modal.find('#comissao_alt').val(comissaoAlt)
    modal.find('#pagoemissao_alt').val(pagoEmissaoAlt)
    modal.find('#pagobaixa_alt').val(pagoBaixaAlt)
    modal.find('#desconto_alt').val(descontoMaxAlt)
    modal.find('#telefone_alt').val(telefoneAlt)
    modal.find('#logradouro_alt').val(logradouroAlt)
    modal.find('#numero_alt').val(numeroAlt)
    modal.find('#complemento_alt').val(compAlt)
    modal.find('#bairro_alt').val(bairroAlt)
    modal.find('#cidade_alt').val(cidadeAlt)
    modal.find('#uf_alt').val(ufAlt)
    modal.find('#cep_alt').val(cepAlt)

})

$('#modal-password').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idVendedor = button.data('codigo')
    $("#idVendedor").val(idVendedor);
    var modal = $(this)
    modal.find('.b_text_modal_title_password').text('Resetar Password')
})

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
        width: '100%'
    });
    $('.select-notsearch').select2({
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    $("#cep").mask("99999-999");
    $("#cnpjcpf").mask("99.999.999/9999-99");
    $("#cnpjsefaz").mask("99.999.999/9999-99");

    $("#pessoa").change(function () {
        var e = $(this).find('option:selected').attr('value')
        if (e == '2') {
            $("#cnpjcpf").unmask().mask("999.999.999-99")
        } else {
            $("#cnpjcpf").unmask().mask("99.999.999/9999-99")
        }
    });

    function limpa_formulário_cep() {
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
                $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                        $("#ibge").val(dados.ibge);
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

    $("#cnpjcpf").blur(function () {
        var cnpj = $("#cnpjcpf").val().replace(/\D/g, '');

        var e = $("#pessoa").find('option:selected').attr('value')
        if ((e < '2')) {
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
                        $('#fantasia').val(response.fantasia);
                        $('#logradouro').val(response.logradouro);
                        $('#cep').val(response.cep);
                        $('#cep').focus();
                        $('#cidade').val(response.municipio);
                        $('#bairro').val(response.bairro);
                        $('#numero').val(response.numero);
                        $('#uf').val(response.uf);
                        $('#complemento').val(response.complemento);
                        $('#email').val(response.email);
                        $('#razao').focus();
                        if (response.telefone != null) {
                            $('#obs').val("Telefone: " + response.telefone + ";");
                        }


                        // Aqui exibimos uma mensagem caso tenha ocorrido algum erro
                    } else {
                        alert(response.message); // Neste caso estamos imprimindo a mensagem que a própria API retorna
                    }
                }
            });
        } else {
            $("#iestadual").val('ISENTO')
        }


    });


    var idCliente = $("#idCliente").val();
    var mascara = '';
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/api/clientes/' + idCliente,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (result) {
            if(result.tipo_pessoa < 1){
                mascara = "99.999.999/9999-99"
            }else{
                mascara = "999.999.999-999"
            }
            $("#razao").val(result.razao_social).trigger("change");
            $("#fantasia").val(result.nome_fantasia).trigger("change");
            $("#pessoa").val(result.tipo_pessoa).trigger("change");
            $("#grupo").val(result.grupo).trigger("change");
            $("#cnpjcpf").val(result.cpf_cnpj).unmask().mask(mascara).trigger("change");
            $("#status").val(result.status).trigger("change");
            $("#iestadual").val(result.insc_estadual).trigger("change");
            $("#email").val(result.email).trigger("change");
            $("#cnpjsefaz").val(result.cnpj_sefaz).trigger("change");
            $("#limitecred").val(result.limite_cred).trigger("change");
            $("#venccred").val((result.venc_limite_cred).split(' ')[0]).trigger("change");
            $("#modcob").val(result.modo_cobranca).trigger("change");
            $("#prazocob").val(result.prazo_pagamento).trigger("change");
            $("#tabpreco").val(result.tab_cod).trigger("change");
            $("#grupo").val(result.grupo).trigger("change");
            $("#transp").val(result.transp_cod).trigger("change");
            $("#orc").val(result.flag_orc).trigger("change");
            $("#tes").val(result.tes_cod).trigger("change");
            $("#vendedor").val(result.ven_cod).trigger("change");
            $("#tipolog").val(result.tipo).trigger("change");
            $("#ibge").val(result.IBGE).trigger("change");
            $("#logradouro").val(result.endereco).trigger("change");
            $("#numero").val(result.numero).trigger("change");
            $("#complemento").val(result.complemento).trigger("change");
            $("#bairro").val(result.bairro).trigger("change");
            $("#cidade").val(result.cidade).trigger("change");
            $("#uf").val(result.UF).trigger("change");
            $("#cep").val(result.cep).trigger("change");
            $("#referencia").val(result.referencia).trigger("change");
            $("#obs").val(result.observacoes).trigger("change");



        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    });


    $('#formId').submit(function (e) {
        e.preventDefault();
        var cModCob = 0, cPrazoPag = 0, cTabPreco = 0;
        var ctEspecial = ['.','/','-'];
        if ($('#cModCob').prop('checked')) {
            cModCob = 1;
        } else {
            cModCob = 0;
        }
        if ($('#cPrazoPag').prop('checked')) {
            cPrazoPag = 1;
        } else {
            cPrazoPag = 0;
        }
        if ($('#cTabPreco').prop('checked')) {
            cTabPreco = 1;
        } else {
            cTabPreco = 0;
        }
        
        $.ajax({
            url: '/api/clientes/' + idCliente,
            data: {
                razao_social: $('#razao').val(),
                nome_fantasia: $('#fantasia').val(),
                tipo_pessoa: $('#pessoa').val(),
                grupo: $('#grupo').val(),
                cpf_cnpj: $('#cnpjcpf').val().replace(/\D/g, ''),
                status: $('#status').val(),
                insc_estadual: $('#iestadual').val(),
                email: $('#email').val(),
                cnpj_sefaz: $('#cnpjsefaz').val(),
                limite_cred: $('#limitecred').val(),
                venc_limite_cred: $('#venccred').val(),
                cModCob: cModCob,
                modo_cobranca: $('#modcob').val(),
                cPrazoPag: cPrazoPag,
                prazo_pagamento: $('#prazocob').val(),
                cTabPreco: cTabPreco,
                tab_cod: $('#tabpreco').val(),
                tipo_contribuinte: $('#pessoa').val(),
                transp_cod: $('#transp').val(),
                flag_orc: $('#orc').val(),
                observacoes: $('#obs').val(),
                tes_cod: $('#tes').val(),
                ven_cod: $('#vendedor').val(),
                endereco: $('#logradouro').val(),
                complemento: $('#complemento').val(),
                numero: $('#numero').val(),
                bairro: $('#bairro').val(),
                cidade: $('#cidade').val(),
                IBGE: $('#ibge').val(),
                UF: $('#uf').val(),
                referencia: $('#referencia').val(),
                tipo: $('#tipolog').val(),
                cep: $('#cep').val()
            },
            type: 'put',
            success: function (data) {
                sessionStorage.setItem("status", "Cliente atualizado!");
                //window.location.href='/clientes/?atualizado=1';
                window.location.href='/clientes';
               
            }
        })

    });


});

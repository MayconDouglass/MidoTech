$(function () {

    /*let cadastradoSucesso = new URLSearchParams(window.location.search);
    if(cadastradoSucesso.has("atualizado")){
        let atualizado = cadastradoSucesso.get("atualizado");
        if(atualizado==1){
            setInterval(exibirAtualizadoSucesso(),10);
            
        }
    }*/

    if (sessionStorage.getItem("status") != null) {
        exibirAtualizadoSucesso();
        alert(sessionStorage.getItem("status"));
        setTimeout(function () {
            exibirAtualizadoSucesso();
            $('#div_status').hide();
        }, 8000);
        sessionStorage.removeItem("status");
    }
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

    function exibirAtualizadoSucesso() {

        $("#div_status").removeClass("d-none");
    }

});

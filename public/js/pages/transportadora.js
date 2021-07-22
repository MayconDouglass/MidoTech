$(function () {
    $("#menuCompras").addClass("menu-open");
    $("#subCompras").addClass("active");
    $("#menuTransp").addClass("active");

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

    $("#cep").mask("99.999-999");
    $("#telefone").mask("(99) 99999999");
    $("#cnpj").mask("99.999.999/9999-99");
    $("#uf").mask('SS');
    $("#ufplaca").mask('SS');
    $("#placa").mask('AAA9A99');

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

    $("#cnpj").blur(function () {
        var cnpj = $("#cnpj").val().replace(/\D/g, '');
        exibirLoading();
        setTimeout(function () {
            exibirLoading();
            $('#loadModal').hide();
            ocultarLoading();
        }, 500);
        
        var e = $("#pessoa").find('option:selected').attr('value')
        $.ajax({
            url: 'https://www.receitaws.com.br/v1/cnpj/' + cnpj,
            method: 'GET',
            dataType: 'jsonp',
            complete: function (xhr) {


                response = xhr.responseJSON;

                // Na documentação desta API tem esse campo status que retorna "OK" caso a consulta tenha sido efetuada com sucesso
                if (response.status == 'OK') {
                    sessionStorage.removeItem("status");
                    let getObs = $('#observacao').val().includes('Telefone Alternativo:');
                    let setObs = $('#observacao').val() + ' Telefone Alternativo: ' + response.telefone.split('/')[0] + '.';
                    // Agora preenchemos os campos com os valores retornados
                    $('#razao').val(response.nome);
                    $('#fantasia').val(response.fantasia);
                    $('#logradouro').val(response.logradouro);
                    $('#cep').val(response.cep);
                    $('#cidade').val(response.municipio);
                    $('#bairro').val(response.bairro);
                    $('#numero').val(response.numero);
                    $('#uf').val(response.uf);
                    $('#email').val(response.email);
                    $('#telefone').val(response.telefone.split('/')[0]);
                    if (!getObs) {
                        $('#observacao').val(setObs);
                    }
                    $('#cep').focus();
                    $('#razao').focus();


                    // Aqui exibimos uma mensagem caso tenha ocorrido algum erro
                } else {
                    alert(response.message); // Neste caso estamos imprimindo a mensagem que a própria API retorna
                }
            }
        });

    });

});

function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    $("#logradouro").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#uf").val("");
    $("#ibge").val("");
}

function exibirLoading() {
    $("#loadModal").removeClass("d-none");
}
function ocultarLoading() {
    $("#loadModal").addClass("d-none");
}
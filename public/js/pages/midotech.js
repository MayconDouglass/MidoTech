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

    $('.select2-emp').select2({
        dropdownParent: $("#AlterarEmpModal"),
        width: '100%'
    });
    $('.select-notsearch-emp').select2({
        dropdownParent: $("#AlterarEmpModal"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    $('.select2-users').select2({
        dropdownParent: $("#AlterarUserModal"),
        width: '100%'
    });
    $('.select-notsearch-users').select2({
        dropdownParent: $("#AlterarUserModal"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    $('.select2-perfis').select2({
        dropdownParent: $("#AlterarPerfilModal"),
        width: '100%'
    });
    $('.select-notsearch-perfis').select2({
        dropdownParent: $("#AlterarPerfilModal"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    $('.select2-role').select2({
        dropdownParent: $("#modal-permissao"),
        width: '100%'
    });
    $('.select-notsearch-role').select2({
        dropdownParent: $("#modal-permissao"),
        width: '100%',
        minimumResultsForSearch: Infinity
    });

    bsCustomFileInput.init();

    $('.toastrDefaultError').click(function () {
        toastr.error('Já existe uma empresa com este CNPJ!')
    });

    
});

$('#CadastroModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) //Botão que acionou o modal  
    $(this).find('form').trigger('reset');
})

//Apaga tudo que estiver nos forms do modal
$('#CadastroModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})

//preview upload img
$('#customFile').change(function () {
    const file = $(this)[0].files[0]
    const fileReader = new FileReader()
    fileReader.onloadend = function () {
        $('#previewImg').attr('src', fileReader.result)
    }
    fileReader.readAsDataURL(file)
})
//preview upload img
$('#customFileAlt').change(function () {
    const file = $(this)[0].files[0]
    const fileReader = new FileReader()
    fileReader.onloadend = function () {
        $('#previewImgAlt').attr('src', fileReader.result)
    }
    fileReader.readAsDataURL(file)
})


//Read and Change Modal

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})

$('#modal-permissao').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idPerfil = button.data('codigo')
    var nomePerfil = button.data('nome')
    $("#idPerfil").val(idPerfil);
    
   
    
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'perfil/obterperm',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id': idPerfil
        },
        success: function (result) {
            
            for (let index = 1; index <= result[0].length; index++) {

            $("#role".concat(index)).val(result[0][index-1]).trigger("change");

            }
           
        },
        error: function (resultError) {

            console.log('Erro na consulta');

        }

    })

    var modal = $(this)
    modal.find('.b_text_modal_title_permissao').text('Permissões do Perfil: '+ nomePerfil)
})

$('#modal-password').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idUser = button.data('codigo')
    $("#idUser").val(idUser);
    var modal = $(this)
    modal.find('.b_text_modal_title_password').text('Resetar Password')
})

$('#AlterarUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var userCodAlt = button.data('codigo')
    var nomeAlt = button.data('nome')
    var emailAlt = button.data('email')
    var empresaAlt = button.data('empresa')
    var perfilAlt = button.data('perfil')
    var statusAlt = button.data('status')
    var dataCadAlt = button.data('datacad')
    var dataAltAlt = button.data('dataalt')
    var fotoAlt = button.data('imgalt')

    $('#previewImgAlt').attr('src', fotoAlt);

    $("#empresa_alt").select2({
        dropdownParent: $("#AlterarUserModal"), width: '100%',
    }).val(empresaAlt).trigger("change");

    $("#perfil_alt").select2({
        dropdownParent: $("#AlterarUserModal"), width: '100%',
    }).val(perfilAlt).trigger("change");

    $("#ativa_alt").select2({
        dropdownParent: $("#AlterarUserModal"), width: '100%',
    }).val(statusAlt).trigger("change");
    
    
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#user_cod').val(userCodAlt)
    modal.find('#nome_alt').val(nomeAlt)
    modal.find('#email_alt').val(emailAlt)
    modal.find('#data_cadastro_alt').val(dataCadAlt)
    modal.find('#data_alteracao_alt').val(dataAltAlt)
})

$('#VisualizarPerfilModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var userCodView = button.data('codigo')
   
    
    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#user_cod').val(userCodView)
})

$('#AlterarPerfilModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var userCodAlt = button.data('codigo')
        
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#user_cod').val(userCodAlt)
})



$('#VisualizarUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var userCodView = button.data('codigo')
    var emailView = button.data('email')
    var nomeView = button.data('nome')
    var empresaView = button.data('empresa')
    var perfilView = button.data('perfil')
    var statusView = button.data('status')
    var dataCadView = button.data('datacad')
    var dataAltView = button.data('dataalt')

    var fotoView = button.data('imgview')

    $("#empresa_view").select2({
        dropdownParent: $("#VisualizarUserModal"), width: '100%',
    }).val(empresaView).trigger("change");

    $("#perfil_view").select2({
        dropdownParent: $("#VisualizarUserModal"), width: '100%',
    }).val(perfilView).trigger("change");

    $("#ativa_view").select2({
        dropdownParent: $("#VisualizarUserModal"), width: '100%',
    }).val(statusView).trigger("change");

    $('#viewImg').attr('src', fotoView);
    
    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#user_cod').val(userCodView)
    modal.find('#email_view').val(emailView)
    modal.find('#nome_view').val(nomeView)
    modal.find('#data_cadastro_view').val(dataCadView)
    modal.find('#data_alteracao_view').val(dataAltView)
})

$('#AlterarEmpModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var empCodAlt = button.data('codigo')
    var razaoSocialAlt = button.data('razao')
    var nomeFantasiaAlt = button.data('fantasia')
    var logradouroAlt = button.data('logradouro')
    var numeroAlt = button.data('numero')
    var complementoAlt = button.data('complemento')
    var bairroAlt = button.data('bairro')
    var cidadeAlt = button.data('cidade')
    var estadoAlt = button.data('estado')
    var cepAlt = button.data('cep')
    var cnpjAlt = button.data('cnpj')
    var ieAlt = button.data('ie')
    var imAlt = button.data('im')
    var telefoneAlt = button.data('telefone')
    var statusAlt = button.data('ativo')
    var siteAlt = button.data('site')
    var emailAlt = button.data('email')
    var siglaAlt = button.data('sigla')
    var dataCadAlt = button.data('cadastro')
    var regimetribAlt = button.data('regimetrib')
    var atividadeAlt = button.data('atividade')
    var saldoClienteAlt = button.data('saldocliente')
    var processamentoAlt = button.data('processamento')
    var licencaAlt = button.data('licenca')
    var logoAlt = button.data('imgalt')

    $("#regime_tributario_alt").select2({
        dropdownParent: $("#AlterarEmpModal"), width: '100%',
    }).val(regimetribAlt).trigger("change");

    $("#saldo_cliente_alt").select2({
        dropdownParent: $("#AlterarEmpModal"), width: '100%',
    }).val(saldoClienteAlt).trigger("change");

    $("#atividade_alt").select2({
        dropdownParent: $("#AlterarEmpModal"), width: '100%',
    }).val(atividadeAlt).trigger("change");

    $("#ativa_alt").select2({
        dropdownParent: $("#AlterarEmpModal"), width: '100%',
    }).val(statusAlt).trigger("change");

    $('#previewImgAlt').attr('src', logoAlt);
    
    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
    modal.find('#emp_cod').val(empCodAlt)
    modal.find('#razao_social_alt').val(razaoSocialAlt)
    modal.find('#nome_fantasia_alt').val(nomeFantasiaAlt)
    modal.find('#sigla_alt').val(siglaAlt)
    modal.find('#logradouro_alt').val(logradouroAlt)
    modal.find('#numero_alt').val(numeroAlt)
    modal.find('#complemento_alt').val(complementoAlt)
    modal.find('#cidade_alt').val(cidadeAlt)
    modal.find('#bairro_alt').val(bairroAlt)
    modal.find('#uf_alt').val(estadoAlt)
    modal.find('#cep_alt').val(cepAlt)
    modal.find('#cnpj_alt').val(cnpjAlt)
    modal.find('#ie_alt').val(ieAlt)
    modal.find('#im_alt').val(imAlt)
    modal.find('#telefone_alt').val(telefoneAlt)
    modal.find('#data_cadastro_alt').val(dataCadAlt)
    modal.find('#email_alt').val(emailAlt)
    modal.find('#site_alt').val(siteAlt)
    modal.find('#licenca_alt').val(licencaAlt)
})

$('#VisualizarEmpModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var empCodView = button.data('codigo')
    var razaoSocialView = button.data('razao')
    var nomeFantasiaView = button.data('fantasia')
    var logradouroView = button.data('logradouro')
    var numeroView = button.data('numero')
    var complementoView = button.data('complemento')
    var bairroView = button.data('bairro')
    var cidadeView = button.data('cidade')
    var estadoView = button.data('estado')
    var cepView = button.data('cep')
    var cnpjView = button.data('cnpj')
    var ieView = button.data('ie')
    var imView = button.data('im')
    var telefoneView = button.data('telefone')
    var statusView = button.data('ativo')
    var siteView = button.data('site')
    var emailView = button.data('email')
    var siglaView = button.data('sigla')
    var dataCadView = button.data('cadastro')
    var dataAltView = button.data('alteracao')
    var regimetribView = button.data('regimetrib')
    var atividadeView = button.data('atividade')
    var saldoClienteView = button.data('saldocliente')
    var processamentoView = button.data('processamento')
    var licencaView = button.data('licenca')
    var logoView = button.data('imgview')

    $("#regime_tributario_view").select2({
        dropdownParent: $("#VisualizarEmpModal"), width: '100%',
    }).val(regimetribView).trigger("change");

    $("#saldo_cliente_view").select2({
        dropdownParent: $("#VisualizarEmpModal"), width: '100%',
    }).val(saldoClienteView).trigger("change");

    $("#atividade_view").select2({
        dropdownParent: $("#VisualizarEmpModal"), width: '100%',
    }).val(atividadeView).trigger("change");

    $("#ativa_view").select2({
        dropdownParent: $("#VisualizarEmpModal"), width: '100%',
    }).val(statusView).trigger("change");

    $('#viewImg').attr('src', logoView);
    
    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
    modal.find('#emp_cod').val(empCodView)
    modal.find('#razao_social_view').val(razaoSocialView)
    modal.find('#nome_fantasia_view').val(nomeFantasiaView)
    modal.find('#sigla_view').val(siglaView)
    modal.find('#logradouro_view').val(logradouroView)
    modal.find('#numero_view').val(numeroView)
    modal.find('#complemento_view').val(complementoView)
    modal.find('#cidade_view').val(cidadeView)
    modal.find('#bairro_view').val(bairroView)
    modal.find('#uf_view').val(estadoView)
    modal.find('#cep_view').val(cepView)
    modal.find('#cnpj_view').val(cnpjView)
    modal.find('#ie_view').val(ieView)
    modal.find('#im_view').val(imView)
    modal.find('#telefone_view').val(telefoneView)
    modal.find('#data_cadastro_view').val(dataCadView)
    modal.find('#data_alteracao_view').val(dataAltView)
    modal.find('#email_view').val(emailView)
    modal.find('#site_view').val(siteView)
    modal.find('#licenca_view').val(licencaView)
})

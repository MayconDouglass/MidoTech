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
})

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

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})


$('#VisualizarTESModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var TESCod = button.data('codigo')
   
    $.getJSON('/tes/id/' + TESCod, function (data) {
        
        $("#codigoview").val(data.cod_tes);

        $("#descricaoview").val(data.descricao);
       
        $("#tipoview").select2({
            dropdownParent: $("#VisualizarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo).trigger("change");

        $("#cfopview").select2({
            dropdownParent: $("#VisualizarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.CFOP).trigger("change");

        $("#statusview").select2({
            dropdownParent: $("#VisualizarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.status).trigger("change");
        
        $("#serieview").val(data.serie);

        $("#alcodview").select2({
            dropdownParent: $("#VisualizarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.al_padrao).trigger("change");

        $("#boleto_view").select2({
            dropdownParent: $("#VisualizarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.boleto).trigger("change");

        $("#aliq_inss_view").val(formatter.format(data.aliq_inss));

        $("#inss_view").val(money.format(data.inss_nfsuperior));

        $("#aliq_iss_view").val(formatter.format(data.aliq_iss));

        $("#iss_view").val(money.format(data.iss_nfsuperior));

        $("#aliq_irrf_view").val(formatter.format(data.aliq_irrf));

        $("#irrf_view").val(money.format(data.irrf_nfsuperior));
        
        $("#ret_pis_view").val(formatter.format(data.ret_pis));

        $("#pis_nf_view").val(money.format(data.pis_nfsuperior));

        $("#ret_cofins_view").val(formatter.format(data.ret_cofins));

        $("#cofins_nf_view").val(money.format(data.cofins_nfsuperior));

        $("#ret_csll_view").val(formatter.format(data.ret_csll));
        
        $("#abat_suframa_pis_view").val(formatter.format(data.abat_suframa_pis));
        
        $("#abat_suframa_cofins_view").val(formatter.format(data.abat_suframa_cofins));
  
        $("#simples_view").select2({
            dropdownParent: $("#VisualizarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.simples).trigger("change");  
        
        $("#aliq_simples_view").val(formatter.format(data.ali_simples));

        $("#calc_icms_view").prop( "checked",data.calc_icms ? true : false);

        $("#calc_ipi_view").prop( "checked",data.calc_ipi ? true : false);

        $("#cred_icm_view").prop( "checked",data.cred_icm ? true : false);

        $("#cred_ipi_view").prop( "checked",data.cred_ipi ? true : false);

        $("#cred_piscofins_view").prop( "checked",data.cred_piscofins ? true : false);

        $("#financeiro_view").prop( "checked",data.financeiro ? true : false);
       
        $("#emissao_view").prop( "checked",data.nfe ? true : false);

        $("#mov_est_view").prop( "checked",data.mov_estoque ? true : false);

        $("#dest_ipi_view").prop( "checked",data.dest_ipi ? true : false);

        $("#incide_ipi_view").prop( "checked",data.incide_ipi ? true : false);

        $("#incide_despesas_view").prop( "checked",data.incide_despesas ? true : false);

        $("#incide_base_ipi_view").prop( "checked",data.incide_base_ipi ? true : false);

        $("#calc_iss_view").prop( "checked",data.calc_iss ? true : false);

        $("#at_custo_view").prop( "checked",data.at_custo ? true : false);

        $("#at_custo_medio_view").prop( "checked",data.at_custo_medio ? true : false);

        $("#at_custo_aq_view").prop( "checked",data.at_custo_aq ? true : false);

        $("#at_preco_view").prop( "checked",data.at_preco ? true : false);

        $("#soma_view").prop( "checked",data.soma ? true : false);

        $("#espelho_view").prop( "checked",data.espelho ? true : false);

        $("#comissao_view").prop( "checked",data.comissao ? true : false);

        $("#calc_import_view").prop( "checked",data.calc_import ? true : false);

        $("#soma_import_view").prop( "checked",data.soma_import ? true : false);

        $("#lanc_ipi_view").prop( "checked",data.lancamento_ipi ? true : false);

        $("#incide_icms_pci_view").prop( "checked",data.incide_icms_pci ? true : false);

        $("#incide_despesas_pc_view").prop( "checked",data.incide_despesas_pc ? true : false);
        
        $("#ded_icms_pc_view").prop( "checked",data.ded_icms_pc ? true : false);

        $("#calc_fecp_view").prop( "checked",data.calc_fecp ? true : false);

        $("#calc_difal_view").prop( "checked",data.calc_difal ? true : false);

        $("#dup_st_view").prop( "checked",data.duplicata_st ? true : false);

        $("#desc_icms_view").prop( "checked",data.desc_icms ? true : false);

        $("#desc_icms_des_view").prop( "checked",data.desc_icms_des ? true : false);

        $("#desc_icms_ipi_view").prop( "checked",data.desc_ipi ? true : false);

        $("#serieview").val(data.serie);
    });

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Registro')
})


$('#AlterarTESModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var TESCod = button.data('codigo')
    $.getJSON('/tes/id/' + TESCod, function (data) {
        
        $("#idTES").val(TESCod);

        $("#codigoalt").val(data.cod_tes);

        $("#descricaoalt").val(data.descricao);
       
        $("#tipoalt").select2({
            dropdownParent: $("#AlterarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo).trigger("change");

        $("#cfopalt").select2({
            dropdownParent: $("#AlterarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.CFOP).trigger("change");

        $("#statusalt").select2({
            dropdownParent: $("#AlterarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.status).trigger("change");
        
        $("#seriealt").val(data.serie);

        $("#alcodalt").select2({
            dropdownParent: $("#AlterarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.al_padrao).trigger("change");

        $("#boleto_alt").select2({
            dropdownParent: $("#AlterarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.boleto).trigger("change");

        $("#aliq_inss_alt").val(data.aliq_inss);

        $("#inss_alt").val(data.inss_nfsuperior);

        $("#aliq_iss_alt").val(data.aliq_iss);

        $("#iss_alt").val(data.iss_nfsuperior);

        $("#aliq_irrf_alt").val(data.aliq_irrf);

        $("#irrf_alt").val(data.irrf_nfsuperior);
        
        $("#ret_pis_alt").val(data.ret_pis);

        $("#pis_nf_alt").val(data.pis_nfsuperior);

        $("#ret_cofins_alt").val(data.ret_cofins);

        $("#cofins_nf_alt").val(data.cofins_nfsuperior);

        $("#ret_csll_alt").val(data.ret_csll);
        
        $("#abat_suframa_pis_alt").val(data.abat_suframa_pis);
        
        $("#abat_suframa_cofins_alt").val(data.abat_suframa_cofins);
  
        $("#simples_alt").select2({
            dropdownParent: $("#AlterarTESModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.simples).trigger("change");  
        
        $("#aliq_simples_alt").val(data.ali_simples);

        $("#calc_icms_alt").prop( "checked",data.calc_icms ? true : false);

        $("#calc_ipi_alt").prop( "checked",data.calc_ipi ? true : false);

        $("#cred_icm_alt").prop( "checked",data.cred_icm ? true : false);

        $("#cred_ipi_alt").prop( "checked",data.cred_ipi ? true : false);

        $("#cred_piscofins_alt").prop( "checked",data.cred_piscofins ? true : false);

        $("#financeiro_alt").prop( "checked",data.financeiro ? true : false);
       
        $("#emissao_alt").prop( "checked",data.nfe ? true : false);

        $("#mov_est_alt").prop( "checked",data.mov_estoque ? true : false);

        $("#dest_ipi_alt").prop( "checked",data.dest_ipi ? true : false);

        $("#incide_ipi_alt").prop( "checked",data.incide_ipi ? true : false);

        $("#incide_despesas_alt").prop( "checked",data.incide_despesas ? true : false);

        $("#incide_base_ipi_alt").prop( "checked",data.incide_base_ipi ? true : false);

        $("#calc_iss_alt").prop( "checked",data.calc_iss ? true : false);

        $("#at_custo_alt").prop( "checked",data.at_custo ? true : false);

        $("#at_custo_medio_alt").prop( "checked",data.at_custo_medio ? true : false);

        $("#at_custo_aq_alt").prop( "checked",data.at_custo_aq ? true : false);

        $("#at_preco_alt").prop( "checked",data.at_preco ? true : false);

        $("#soma_alt").prop( "checked",data.soma ? true : false);

        $("#espelho_alt").prop( "checked",data.espelho ? true : false);

        $("#comissao_alt").prop( "checked",data.comissao ? true : false);

        $("#calc_import_alt").prop( "checked",data.calc_import ? true : false);

        $("#soma_import_alt").prop( "checked",data.soma_import ? true : false);

        $("#lanc_ipi_alt").prop( "checked",data.lancamento_ipi ? true : false);

        $("#incide_icms_pci_alt").prop( "checked",data.incide_icms_pci ? true : false);

        $("#incide_despesas_pc_alt").prop( "checked",data.incide_despesas_pc ? true : false);
        
        $("#ded_icms_pc_alt").prop( "checked",data.ded_icms_pc ? true : false);

        $("#calc_fecp_alt").prop( "checked",data.calc_fecp ? true : false);

        $("#calc_difal_alt").prop( "checked",data.calc_difal ? true : false);

        $("#dup_st_alt").prop( "checked",data.duplicata_st ? true : false);

        $("#desc_icms_alt").prop( "checked",data.desc_icms ? true : false);

        $("#desc_icms_des_alt").prop( "checked",data.desc_icms_des ? true : false);

        $("#desc_icms_ipi_alt").prop( "checked",data.desc_ipi ? true : false);

    });

    $(this).find('form').trigger('reset');
    var modal = $(this)
    modal.find('.modal-title').text('Alterar Registro')
})

var formatter = new Intl.NumberFormat('pt-BR', {
    style: 'decimal',
    currency: 'BRL',
    minimumFractionDigits: 2,
});

var money = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2,
});
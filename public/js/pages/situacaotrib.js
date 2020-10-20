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


$('#AlterarModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idST = button.data('codigo')

    $.getJSON('/api/st/' + idST, function (data) {
        $('#codigo').val(data.codigo)
        $('#descricao').val(data.descricao)

        $("#tipo").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo).trigger("change");

        $("#origem").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.trib_origem).trigger("change");

        $("#cst").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.trib_cst).trigger("change");

        $("#mod_icms").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.mod_icms).trigger("change");

        $("#mod_icms_st").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.mod_icms_st).trigger("change");

        $("#mot_desoneracao").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.mot_desoneracao).trigger("change");

        $("#riolog").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo_riolog).trigger("change");

        $("#riolog").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo_riolog).trigger("change");

        $("#csosn").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.trib_csosn).trigger("change");

        $("#status").select2({
            dropdownParent: $("#AlterarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.ativo).trigger("change");

        $('#mva').val(data.aliq_mva)
        $('#mva_simples').val(data.aliq_mva_simples)
        $('#aliq_icms').val(data.aliq_icms)
        $('#aliq_icms_st').val(data.aliq_icms_st)
        $('#aliq_icms_uf').val(data.aliq_icms_st)
        $('#aliq_red_icms').val(data.aliq_red_icms)
        $('#aliq_red_icms_st').val(data.aliq_red_icms_st)
        $('#aliq_simples').val(data.aliq_simples)
        $('#aliq_fecp').val(data.aliq_fecp)
        $('#aliq_red_unitario').val(data.aliq_red_unitario)
        $('#aliq_diferimento').val(data.aliq_diferimento)
        $('#beneficio').val(data.benef_fiscal)

    });


    var modal = $(this)
    modal.find('.modal-title').text('Alterar Situação Tributária')
    modal.find('#idST').val(idST)
})

$('#VisualizarModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var idST = button.data('codigo')

    $.getJSON('/api/st/' + idST, function (data) {
        $('#viewcodigo').val(data.codigo)
        $('#viewdescricao').val(data.descricao)

        $("#viewtipo").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo).trigger("change");

        $("#vieworigem").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.trib_origem).trigger("change");

        $("#viewcst").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.trib_cst).trigger("change");

        $("#viewmod_icms").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.mod_icms).trigger("change");

        $("#viewmod_icms_st").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.mod_icms_st).trigger("change");

        $("#viewmot_desoneracao").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.mot_desoneracao).trigger("change");

        $("#viewriolog").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo_riolog).trigger("change");

        $("#viewriolog").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.tipo_riolog).trigger("change");

        $("#viewcsosn").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.trib_csosn).trigger("change");

        $("#viewstatus").select2({
            dropdownParent: $("#VisualizarModal"), width: '100%',
            minimumResultsForSearch: Infinity
        }).val(data.ativo).trigger("change");

        $('#viewmva').val(data.aliq_mva)
        $('#viewmva_simples').val(data.aliq_mva_simples)
        $('#viewaliq_icms').val(data.aliq_icms)
        $('#viewaliq_icms_st').val(data.aliq_icms_st)
        $('#viewaliq_icms_uf').val(data.aliq_icms_st)
        $('#viewaliq_red_icms').val(data.aliq_red_icms)
        $('#viewaliq_red_icms_st').val(data.aliq_red_icms_st)
        $('#viewaliq_simples').val(data.aliq_simples)
        $('#viewaliq_fecp').val(data.aliq_fecp)
        $('#viewaliq_red_unitario').val(data.aliq_red_unitario)
        $('#viewaliq_diferimento').val(data.aliq_diferimento)
        $('#viewbeneficio').val(data.benef_fiscal ? data.benef_fiscal : "Não Informado")

    });


    var modal = $(this)
    modal.find('.modal-title').text('Visualizar Situação Tributária')
    modal.find('#idST').val(idST)
})

$('#modal-danger').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botão que acionou o modal
    var iddelete = button.data('codigo')
    $("#iddelete").val(iddelete);
    var modal = $(this)
    modal.find('.b_text_modal_title_danger').text('Excluir Registro')
})
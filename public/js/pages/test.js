var DATA_PESQUISA_TIME_LINE;
var today = new Date();
var h = today.getHours();
var m = today.getMinutes();
var s = today.getSeconds();
document.addEventListener("DOMContentLoaded", function (c) {
    efeito = animacaoAleatorio();
    flashPiscando();
    DATA_PESQUISA_TIME_LINE = formataDataBrParaUs(dataAtual(), "/", "-", "us") + " " + h + ":" + m + ":" + s;
    ajaxTimeLine();
    var d = false;
    textoProcessOnline(baixarOnline);
    ajaxConsultaStatusDoServico();
    hourglassAnimate();
    slideDownAnimate();
    if (PERMISSAO_EDITAR !== "EDITAR") {
        desabilitaCamposOnline();
        desabilitaCamposProgramada();
    } else {
        if (baixarOnline != "0") {
            desabilitaCamposOnline();
        }
    }
    $("#select_restricao_vendedor_cliente")
        .on("change", function () {
            if ($(this).val() == 0) {
                $("#restricao_supervisor_cliente").val("0").prop("disabled", true).selectpicker("refresh");
            } else {
                $("#restricao_supervisor_cliente").removeAttr("disabled").selectpicker("refresh");
            }
        })
        .change();
    $("#btn_salvar").on("click", function (f) {
        toastr.clear();
        telaDeConfirmacao();
    });
    $("#btnResetIntegracao").on("click", function () {
        $.post(base_url + "afv_manager/v2/integracao/2/conf_integracao/resetIntegracao", function () {
            ajaxStatusExecucaoIntegracao();
        });
    });
    $("#qtd_dia_nota_app").on("focusout", function () {
        if ($(this).val() < 1) {
            toastr.warning("O mÃ­nimo Ã© de 1 Qtd. Dias Nota Fiscal");
            $(this).val("1");
        }
    });
    $("#add_hora").on("click", function () {
        var e;
        var f = parseInt(retiraTudoQueNaoForNumero($("#hora").val()));
        if (f < 0 || f > 23) {
            toastr.warning("Hora invÃ¡lida");
            $("#hora").val("00");
            return;
        }
        if ($("#lista_horas li").length >= 4) {
            toastr.error("A lista jÃ¡ esta completa.");
            return;
        }
        f = checkTime(f).toString() + ":00";
        $.each($("#lista_horas li"), function (i, g, j) {
            e = $(g).text().trim();
            if (e == f) {
                d = true;
            }
        });
        if (d == true) {
            toastr.warning("O horÃ¡rio " + f + "h jÃ¡ foi adicionado na lista");
            d = false;
        } else {
            if ($("#hora").val() !== "" && $("#hora").val() !== null && $("#hora").val() !== "undefined" && $("#hora").val() !== undefined) {
                $("#lista_horas").prepend(' <li style="padding: 0 0 0 10px;" id=\'' + f + "' ondblclick='excluirItenHora($(this).remove())' class=\"list-group-item item_hora\">" + f + "</li>");
            }
        }
    });
    $(".todos_online").iCheck({
        checkboxClass: "icheckbox_square-green",
    });
    $(".todos_programada").iCheck({
        checkboxClass: "icheckbox_square-purple",
    });
    $(".check_afv_online, .check_afv_programada").iCheck({
        checkboxClass: "icheckbox_square-orange",
    });
    var b = true;
    var a = true;
    $("#marcar_desmarcar_online").on("click", function (e) {
        if (b) {
            b = false;
            $(".todos_online, .check_afv_online").iCheck("uncheck");
        } else {
            b = true;
            $(".todos_online, .check_afv_online").iCheck("check");
        }
    });
    $("#marcar_desmarcar_programada").on("click", function (e) {
        if (a) {
            a = false;
            $(".todos_programada, .check_afv_programada").iCheck("uncheck");
        } else {
            a = true;
            $(".todos_programada, .check_afv_programada").iCheck("check");
        }
    });
});

function excluirItenHora() {
    toastr.success("Hora removida da lista");
}

function textoProcessOnline(b) {
    var a = "";
    if (b == 0) {
        a = "<span class='text-success'>DisponÃ­vel para baixar <i class='fa fa-check fa-lg'></i></span>";
    } else {
        if (b == 1) {
            a = "<span class='text-info'>Aguardando sincronizaÃ§Ã£o <i class='hourglass'></i></span>";
        } else {
            if (b == 2) {
                a = "<span class='text-info'>Recebendo pacotes <i class='fa fa-arrow-down downAnimate fa-lg'></i></span>";
            } else {
                a = "<span class='text-yellow'>Executando <i class='fa fa-flash flashPiscando fa-lg'></i></span>";
            }
        }
    }
    $("#andamentoProcesso").html(a);
    animateHtml5(efeito, "#andamentoProcesso span");
}

function desabilitaCamposProgramada() {
    $(".bloqueiaProgramada,.p").attr("disabled", "disabled");
    $("#lista_programada").find("input").parent().addClass("disabled");
}

function desabilitaCamposOnline() {
    $(".bloqueiaOnline,.o").attr("disabled", "disabled");
    $("#lista_online").find("input").parent().addClass("disabled");
    $("#informacaoEmergencial").html(htmlInformacaoEmergencial);
    animateHtml5(efeito, "#informacaoEmergencial");
}

function habilitaCamposOnline() {
    $(".bloqueiaOnline,.o").removeAttr("disabled");
    $("#lista_online").find("input").parent().removeClass("disabled");
    animateHtml5("zoomOut", "#informacaoEmergencial");
    $("#informacaoEmergencial").html("");
}

function efetuarSalvamento(a) {
    toastr.clear();
    $.ajax({
        url: base_url + "afv_manager/v2/integracao/2/conf_integracao/salvar_integracao",
        type: "POST",
        dataType: "json",
        data: {
            json: a,
        },
        complete: function (b) {
            aguarde(false);
        },
    })
        .done(function (b) {
            baixarOnline = b.baixar_online;
            toastr.success("Dados atualizados");
            DATA_PESQUISA_TIME_LINE = formataDataBrParaUs(dataAtual(), "/", "-", "us") + " 23:59:59";
            $("#timeLineSincronismo").html("");
            ajaxTimeLine();
        })
        .fail(function () {
            toastr.error("Verifique sua conexÃ£o com a internet e tente novamente mais tarde!", "Falha");
        });
}

function hourglassAnimate() {
    var a = ["fa-hourglass-start", "fa-hourglass-half", "fa-hourglass-end"];
    var b = 0;
    window.setInterval(function () {
        while (b >= 0) {
            $(".hourglass").html("<i class='fa " + a[b] + " fa-lg'></i>");
            b++;
            if (b >= a.length) {
                b = 0;
            }
            break;
        }
    }, 500);
}

function slideDownAnimate() {
    window.setInterval(function () {
        animateHtml5("slideInUp", ".downAnimate");
    }, 400);
}

function getListaChecked(b) {
    var a = [];
    $.each(b, function (e, d, g) {
        var f = 0;
        if ($(d)[0].checked) {
            f = 1;
        }
        a.push($(d)[0].name + "_" + f);
    });
    return a;
}

function ajaxConsultaStatusDoServico() {
    window.setInterval(function () {
        ajaxStatusExecucaoIntegracao();
    }, 25000);
}

function ajaxStatusExecucaoIntegracao() {
    $.ajax({
        url: base_url + "afv_manager/v2/integracao/2/conf_integracao/ajaxConsultaStatusDoServico",
        dataType: "json",
    }).done(function (a) {
        if (baixarOnline !== a.baixar_online) {
            baixarOnline = a.baixar_online;
            $("#dt_cadastro_online").html(a.dt_cadastro_online);
            $("#dt_execucao_online").html(a.dt_execucao_online);
            $("#dt_execucao_online_fim").html(a.dt_execucao_online_fim);
            textoProcessOnline(a.baixar_online);
            if (parseInt(a.baixar_online) === 0) {
                $(".todos_online, .check_afv_online").iCheck("uncheck");
                habilitaCamposOnline();
            }
        }
    });
}

function ajaxTimeLine() {
    $.ajax({
        url: base_url + "afv_manager/v2/integracao/2/conf_integracao/ajaxTimeLine",
        dataType: "json",
        type: "post",
        data: {
            dtCadastro: DATA_PESQUISA_TIME_LINE,
            limit: 10,
        },
        beforeSend: function () {
            $("#aguardeCarregarMais").html("<i class='fas fa-sync fa-lg fa-spin text-primary'></i>");
        },
        complete: function () {
            $("#aguardeCarregarMais").html("");
        },
    }).done(function (a) {
        a = orderJson(a, "order", "DESC");
        if (a.length > 0) {
            var b = "";
            $.each(a, function (c, d) {
                $("#timeLineSincronismo").append(_montarTimeLineSincronismo(d, b));
                if (d.dataCadastroBr !== b) {
                    b = d.dataCadastroBr;
                }
                DATA_PESQUISA_TIME_LINE = d.dt_cadastro;
            });
        }
    });
}

function _montarTimeLineSincronismo(j, i) {
    var b = j.dataCadastroBr !== i ? "<span class='bg-red'>" + j.dataCadastroBr + " </span>" : "";
    var e = "";
    var g = "";
    var c = "IntegraÃ§Ã£o executada pelo servidor";
    var a = "SincronizaÃ§Ã£o ";
    var f = "fa-cogs bg-green";
    if (j.online.length > 0) {
        e = "<h5><span class='text-success text-bold'>Emergencial:</span> ";
        $.each(j.online, function (k, l) {
            e += " <i class='fa fa-circle text-success'></i>" + l;
        });
        e += "</h5>";
        a += " emergencial";
    }
    if (j.online.length > 0 && j.programada.length > 0) {
        a += " e";
    }
    if (j.programada.length > 0) {
        g = "<h5><span class='text-purple text-bold'>Programada: </span>";
        $.each(j.programada, function (k, l) {
            g += " <i class='fa fa-circle text-purple'></i>" + l;
        });
        g += "</h5>";
        a += " programada";
    }
    if (j.nomeUsuario !== null) {
        c = "Solicitado por: " + j.nomeUsuario;
        f = "fa-user bg-yellow";
    }
    var d =
        "<li class='time-label'>" +
        b +
        "    </li>    <li>    <i class='fa " +
        f +
        "' style='color: white !important;'></i>        <div class='timeline-item'>        <span class='time'><i class='fa fa-clock'></i> " +
        j.horaCadastroBr +
        "h</span>    <h3 class='timeline-header'><a href='#'>" +
        a +
        "</a> " +
        c +
        "    </h3>    <div class='timeline-body'>" +
        e +
        g +
        "    </div>    <div class='timeline-footer'>        </div>        </div>        </li>";
    return d;
}

function telaDeConfirmacao() {
    BootstrapDialog.show({
        onshown: function (a) {},
        title: "<h4>ConfirmaÃ§Ã£o de salvamento</h4>",
        message: "<h4>Deseja realmente prosseguir?</h4>",
        type: BootstrapDialog.TYPE_SUCCESS,
        closable: false,
        draggable: true,
        buttons: [
            {
                label: "Cancelar",
                cssClass: "btn-default",
                action: function (a) {
                    a.close();
                },
            },
            {
                label: "<i class='fa fa-thumbs-up'></i> Prosseguir",
                cssClass: "btn-success",
                action: function (a) {
                    montarInformacaoParaSalvar();
                    a.close();
                },
            },
        ],
    });
}

function montarInformacaoParaSalvar() {
    var d = "programada";
    aguarde(true);
    var c = {};
    $.each($("#lista_horas li"), function (i, g) {
        c[i] = $(g).text().trim();
    });
    $(".o").filter(function (g, i) {
        if (
            $(i).attr("name") === "23" &&
            $(i)
                .parent()
                .attr("class")
                .match(/checked/)
        ) {
            $("#lista_online input[name=2]").parent().addClass("checked");
        }
    });
    var e = getListaChecked($("#lista_online .o"));
    var b = getListaChecked($("#lista_programada .p"));
    var a = false;
    $.each(e, function (j, g) {
        if (parseInt(g.split("_")[1]) === 1) {
            a = true;
            return false;
        }
    });
    if (a && baixarOnline == "0") {
        d = "ambos";
        textoProcessOnline(1);
        desabilitaCamposOnline();
    }
    var f = {
        configuracao: {
            registro_lote: $("#registro_lote").val(),
            qtd_dias_nota_fiscal: $("#qtd_dia_nota").val(),
            hora: c,
            dia: toObject($("#select_dia").val()),
            restricao_produto: $("#select_restricao_produto").val(),
            restricao_protabela_preco: $("#select_restricao_protabelapreco").val(),
            restricao_vendedor_cliente: $("#select_restricao_vendedor_cliente").val(),
            restricao_supervisor_cliente: $("#restricao_supervisor_cliente").val(),
        },
        extra: {
            tipoIntegracao: d,
        },
        integracao_online: e,
        integracao_programada: b,
    };
    efetuarSalvamento(JSON.stringify(f));
    $("html, body").stop().animate(
        {
            scrollTop: 0,
        },
        "500",
        "swing"
    );
}

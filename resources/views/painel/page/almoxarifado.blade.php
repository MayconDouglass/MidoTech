@extends('painel.template.template')

@section('title', 'Almoxarifado')

@section('css')
    <link rel="stylesheet" href="{{ url('/') }}/js/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="{{ url('/') }}/js/plugins/select2/css/select2m.css">
@endsection

@section('head')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Almoxarifados
                        @foreach ($acessoPerfil as $acesso)
                            @if ($acesso->role == 2 && $acesso->ativo == 1)
                                <button type="button" class="btn btn-primary fa fa-user-plus" data-toggle="modal"
                                    data-target="#CadastroModal">
                                    Cadastrar
                                </button>
                            @endif
                        @endforeach
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active">Tabelas Genéricas</li>
                        <li class="breadcrumb-item active">Almoxarifados</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if (session('status_error'))
        <div class="alert alert-danger status ">
            {{ session('status_error') }}
        </div>
    @endif
    @if (session('status_success'))
        <div class="alert alert-success status">
            {{ session('status_success') }}
        </div>
    @endif
    @if (session('status_warning'))
        <div class="alert alert-warning status">
            {{ session('status_warning') }}
        </div>
    @endif
@endsection

@section('content')
    <div class="card">

        <div class="card-body">

            <table id="tableBase" class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th class="idDataTab">ID</th>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th class="statusDataTab">Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($almoxarifados as $almoxarifado)
                        <tr>
                            <td class="idDataTabText">{{ $almoxarifado->id_almoxarifado }}</td>
                            <td>{{ $almoxarifado->codigo }}</td>
                            <td>{{ $almoxarifado->descricao }}</td>
                            <td>
                                @switch($almoxarifado['tipo'])
                                    @case(0)
                                    Produto Final
                                    @break
                                    @case(1)
                                    Matéria Prima
                                    @break
                                    @case(2)
                                    Perda e Avaria
                                    @break
                                @endswitch

                            </td>
                            <td>
                                <span @if ($almoxarifado->status > 0) class="badge
                                badge-success" @else class="badge badge-danger"
                    @endif>{{ $almoxarifado->status ? 'Ativo' : 'Inativo' }}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm fa fa-eye" data-toggle="modal"
                            data-target="#VisualizarModal" data-codigo={{ $almoxarifado->id_almoxarifado }}
                            data-tipo={{ $almoxarifado->tipo }} data-status={{ $almoxarifado->status }}
                            data-qtd={{ $almoxarifado->qtd_estatistica }}></button>

                        @foreach ($acessoPerfil as $acesso)
                            @if ($acesso->role == 2 && $acesso->ativo == 1)
                                <button type="button" class="btn btn-alterar btn-sm fa fa-pencil-square-o"
                                    data-toggle="modal" data-target="#AlteracaoModal"
                                    data-codigo={{ $almoxarifado->id_almoxarifado }} data-tipo={{ $almoxarifado->tipo }}
                                    data-status={{ $almoxarifado->status }}
                                    data-qtd={{ $almoxarifado->qtd_estatistica }}></button>


                                <button type="button" class="btn btn-info btn-sm fa fa-map-marker" data-toggle="modal"
                                    data-target="#LocalizacaoModal"
                                    data-codigo={{ $almoxarifado->id_almoxarifado }}></button>
                            @endif


                            @if ($acesso->role == 3 && $acesso->ativo == 1)
                                <button type="button" class="btn btn-danger btn-sm fa fa-trash-o" data-toggle="modal"
                                    data-target="#modal-danger" data-codigo={{ $almoxarifado->id_almoxarifado }}></button>
                            @endif
                        @endforeach
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal Cadastro-->
    <div class="modal fade" id="CadastroModal" tabindex="-1" role="dialog" aria-labelledby="CadastroModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="add_modalHeader">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CadastroModalLabel">Novo Almoxarifado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Form de cadastro -->
                    <form class="form-horizontal" method="POST" action="{{ action('AlmoxarifadoController@store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">

                            <div class="col-sm-3">
                                <label class="control-label">Código</label>
                                <p><input class="form-control" type="text" name="codigocad" maxlength="3" required /></p>
                            </div>

                            <div class="col-sm-9">
                                <label class="control-label">Descrição</label>
                                <p><input class="form-control" type="text" name="descricaocad" maxlength="30" required />
                                </p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Tipo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="tipocad">
                                        <option value="0">Produto Final</option>
                                        <option value="1">Matéria Prima</option>
                                        <option value="2">Perda e Avaria</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Qtd Estatistica</label>
                                <p><select class="select-notsearch" tabindex="-1" name="qtdcad">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Ativo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="statuscad">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i
                                    class="fa fa-times"> Cancelar</i></button>
                            <button type="submit" class="btn btn-primary" id="btnSalvar" name="btnSalvar"><i
                                    class="fa fa-floppy-o"> Salvar</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alteracao-->
    <div class="modal fade" id="AlteracaoModal" tabindex="-1" role="dialog" aria-labelledby="AlteracaoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="alt_modalHeader">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Form de cadastro -->
                    <form class="form-horizontal" method="POST" action="{{ action('AlmoxarifadoController@update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">

                            <div class="col-sm-4">
                                <input class="form-control" type="hidden" name="idAlmo" id="idAlmo" required />
                                <label class="control-label">Tipo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="tipoalt" id="tipoalt">
                                        <option value="0">Produto Final</option>
                                        <option value="1">Matéria Prima</option>
                                        <option value="2">Perda e Avaria</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Qtd Estatistica</label>
                                <p><select class="select-notsearch" tabindex="-1" name="qtdalt" id="qtdalt">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Ativo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="statusalt" id="statusalt">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i
                                    class="fa fa-times"> Cancelar</i></button>
                            <button type="submit" class="btn btn-primary" id="btnSalvar" name="btnSalvar"><i
                                    class="fa fa-floppy-o"> Salvar</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Visualizacao-->
    <div class="modal fade" id="VisualizarModal" tabindex="-1" role="dialog" aria-labelledby="VisualizarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="view_modalHeader">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Form de cadastro -->
                    <form class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">

                            <div class="col-sm-4">
                                <label class="control-label">Tipo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="tipoview" id="tipoview" disabled>
                                        <option value="0">Produto Final</option>
                                        <option value="1">Matéria Prima</option>
                                        <option value="2">Perda e Avaria</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Qtd Estatistica</label>
                                <p><select class="select-notsearch" tabindex="-1" name="qtdview" id="qtdview" disabled>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label">Ativo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="statusview" id="statusview"
                                        disabled>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i
                                    class="fa fa-times"> Cancelar</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Exclusao-->
    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="delete_modalHeader">
                    <div class="modal-header">
                        <h4 class="b_text_modal_title_danger"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ action('AlmoxarifadoController@destroy') }}">
                        @csrf
                        <input type="hidden" class="form-control col-form-label-sm" id="iddelete" name="iddelete">
                        <label class="b_text_modal_danger">Deseja realmente excluir este registro?</label>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary btn-sm fa fa-times" data-dismiss="modal">
                                Cancelar</button>
                            <button type="submit" class="btn btn-danger btn-sm fa fa-trash-o"> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Localizacao-->
    <div class="modal fade" id="LocalizacaoModal" tabindex="-1" role="dialog" aria-labelledby="LocalizacaoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="view_modalHeader">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Form de cadastro -->
                    <form class="form-horizontal" method="POST" action="{{ action('AlmoxarifadoController@storeLocal')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div id="div_status" class="col-sm-12 alert alert-success d-none">
                                Atualizado com sucesso!
                              </div>

                            <div id="div_status_erro" class="col-sm-12 alert alert-danger d-none">
                                Erro na atualização! Tente novamente.
                              </div>

                            <div class="col-sm-12">
                                <input class="form-control" type="hidden" id="idAlmo" name="idAlmo" required />
                                <p>
                                <div class="card-body table-responsive p-0" style="height: 200px;">
                                    <table class="table table-head-fixed text-nowrap" id="localizatab">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Código</th>
                                                <th style="width: 70%">Localização</th>
                                                <th>Tipo</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="val">
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="col-sm-3">
                                <input class="form-control" type="hidden" name="idLocal" id="idLocal"/>
                                <input class="form-control" type="hidden" name="Alcod" id="Alcod"/>
                                <label class="control-label">Loc. Física</label>
                                <p><input class="form-control" type="text" name="locfisica" id="locfisica" maxlength="11"
                                        required /></p>
                            </div>

                            <div class="col-sm-3">
                                <label class="control-label">Cód. Barras</label>
                                <p><input class="form-control" type="text" name="ean" id="ean" minlength="13"
                                        maxlength="13" /></p>
                            </div>

                            <div class="col-sm-2">
                                <label class="control-label">Capacidade</label>
                                <p><input class="form-control" type="number" name="capacidade" id="capacidade" step="0.001"
                                        value="0.000" min="0.000" /></p>
                            </div>

                            <div class="col-sm-2">
                                <label class="control-label">Tipo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="tipo" id="tipo">
                                        <option value="0">Normal</option>
                                        <option value="1">Pulmão</option>
                                        <option value="2">Picking</option>
                                    </select></p>
                            </div>

                            <div class="col-sm-2">
                                <label class="control-label">Ativo</label>
                                <p><select class="select-notsearch" tabindex="-1" name="status" id="status">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select></p>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="reset" data-dismiss="modal"><i
                                    class="fa fa-times"> Sair</i></button>
                            <button type="button" class="btn btn-danger" id="canButton" disabled><i
                                    class="fa fa-trash-o">
                                    Cancelar</i></button>
                            <button type="button" class="btn btn-success" id="attButton" disabled><i
                                    class="fa fa-trash-o">
                                    Atualizar</i></button>
                            <button type="submit" class="btn btn-success" id="saveButton"><i
                                    class="fa fa-trash-o">
                                    Cadastrar</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
<script src="{{ url('/') }}/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{ url('/') }}/js/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="{{ url('/') }}/js/plugins/select2/js/select2.full.js"></script>
    <script src="{{ url('/') }}/js/plugins/mask/jquery.mask.min.js"></script>
    <script src="{{ url('/') }}/js/pages/almoxarifado.js"></script>
@endsection

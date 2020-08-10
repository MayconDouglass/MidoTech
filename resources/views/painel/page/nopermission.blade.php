@extends('painel.template.template')

@section('title','OPS! Sem permissão!')

@section('head')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">SEM PERMISSÃO DE ACESSO</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index">Home</a></li>
          <li class="breadcrumb-item active">SEM PERMISSÃO DE ACESSO</li>
          <li class="breadcrumb-item active">SEM PERMISSÃO DE ACESSO</li>
        </ol>
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="card">

  <div class="card-body">
    SEM PERMISSÃO DE ACESSO
  </div>
</div>


@endsection


@section('js')
<script src="{{url('/')}}/js/pages/midotech.js"></script>
@endsection
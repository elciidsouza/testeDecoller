@extends('layouts.app', ['activePage' => 'turmas', 'titlePage' => __('Criar/Editar Turmas')])

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">          
            <div class="col-md-12">
                @if(count($errors) > 0 )
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="p-0 m-0" style="list-style: none;">
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

              <div class="card">
                  <div class="card-header card-header-warning">
                      <h4 class="card-title">Criar/Editar Turmas</h4>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="{{ route('turmas.salvar') }}">
                        @csrf

                        @if(isset($model->id))
                            <input type="hidden" name="id" value="{{$model->id}}">
                        @endif

                        <div class="form-group">
                            <label for="nome_turma">Nome da Turma</label>
                            <input type="text" class="form-control" id="nome_turma" name="nome_turma" placeholder="Digite o nome da turma" required @isset($model->nome_turma) value="{{$model->nome_turma}}" @endif>
                        </div>

                        <div class="form-group">
                            <label for="qtd_vagas">Qtd. Vagas</label>
                            <input type="number" class="form-control" id="qtd_vagas" name="qtd_vagas" placeholder="Digite a quantidade de vagas..." required @isset($model->qtd_vagas) value="{{$model->qtd_vagas}}" @endif>
                        </div>

                        <div class="form-group">
                            <label for="dt_inicio">Data Início</label>
                            <input type="date" class="form-control" id="dt_inicio" name="dt_inicio" placeholder="01/01/2020" required @isset($model->dt_inicio) value="{{$model->dt_inicio}}" @endif>
                        </div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-primary"><i class="material-icons">save</i> Salvar</button>
                            <a href="/turmas" class="btn btn-default"><i class="material-icons">keyboard_backspace</i> Voltar</a>
                        </div>
                    </form>
                  </div>
              </div>
            </div>
          </div>
          </div>
    </div>
  </div>
@endsection
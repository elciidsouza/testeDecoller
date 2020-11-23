@extends('layouts.app', ['activePage' => 'turmas', 'titlePage' => __('Turmas')])

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">          
            <div class="col-md-12">
              <div class="card">
                  <div class="card-header card-header-warning">
                      <h4 class="card-title">Lista de Turmas</h4>
                  </div>
                  <div class="card-body">
                      <div class="float-right">
                        <a class="btn btn-primary text-white" href="{{ route('turmas.form') }}">
                            <i class="material-icons">add</i> Nova turma
                        </a>
                      </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Vagas</th>
                                <th>Data de Início</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($turmas as $dados)
                            <tr>
                                <td>{{$dados->nome_turma}}</td>
                                <td>{{$dados->qtd_vagas}}</td>
                                <td>{{ date('d/m/Y', strtotime($dados->dt_inicio)) }}</td>
                                <td class="td-actions text-right">
                                    <a rel="tooltip" class="btn btn-info" href="{{route('turmas.vincular.aluno', ['id' => $dados->id])}}">
                                        <i class="material-icons">people</i> Alunos
                                    </a>
                                    <a rel="tooltip" class="btn btn-success" href="{{route('turmas.editar', ['id' => $dados->id])}}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button class="delete btn btn-danger" value="{{$dados->id}}"><i class="material-icons">close</i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-danger">Nada por aqui. Que tal adicionar a primeira turma?</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
          </div>
    </div>
  </div>
@endsection

@section('js')
<script>
    $('.delete').click(function(){
        var delete_button = $(this).val();
        $.confirm({
            title: 'Excluir registro',
            content: 'Tem certeza que deseja excluir o registro?',
            buttons: {
                excluir: function(){
                    $.get("/turmas/delete/" + delete_button, function(data) {
                        if(data['status'] == 'success'){
                            $.confirm({
                                title: 'Aviso',
                                content: 'Registro excluído com sucesso.',
                                buttons: {
                                    Ok: {
                                        action: function(){
                                            location.reload();
                                        }
                                    }
                                }
                            });
                            //location.reload();
                        } else {
                            $.alert({
                                title: 'Erro!',
                                content: data['msg'],
                            });
                        }
                    });
                },
                cancelar: function(){
                },
            }
        });
    });
</script>
@endsection
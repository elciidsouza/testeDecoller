@extends('layouts.app', ['activePage' => 'turmas', 'titlePage' => __('Vincular Alunos')])

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
                      <h4 class="card-title">Vincular Alunos a Turmas</h4>
                  </div>
                  <div class="card-body">
                    <div class="col-md-12">
                        Adicionar aluno a <strong>{{$turma->nome_turma}}</strong> - Vagas ocupadas: @isset($alunosTurma) {{count($alunosTurma)}} @else 0 @endif / {{$turma->qtd_vagas}}
                        <input type="hidden" id="turma_id" value="{{$turma_id}}">
                        <div class="form-group">
                            <label for="alunos">Aluno</label>
                            <select class="form-control col-md-6" name="alunos" id="alunos">
                                <option value="">Selecione</option>
                                @forelse($alunosLista as $alunos)
                                    <option value="{{$alunos->id}}">{{$alunos->nome}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <button class="btn btn-success" name="add_aluno" id="add_aluno">
                            <i class="material-icons">add</i> Adicionar Aluno
                        </button>
                    </div>
                    <div class="mt-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Telefone</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alunosTurma as $dados)
                                <tr>
                                    <td>{{$dados->nome}}</td>
                                    <td>{{$dados->email}}</td>
                                    <td>{{$dados->telefone}}</td>
                                    <td class="td-actions text-right">
                                        <button class="delete btn btn-danger" value="{{$dados->id}}"><i class="material-icons">close</i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">Nada por aqui. Que tal adicionar o primeiro aluno na turma?</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <a href="{{route('turmas')}}" class="btn btn-primary"><i class="material-icons">keyboard_backspace</i> Voltar</a>
                    </div>
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
    $('#add_aluno').click(function(){
        var turma_id = $('#turma_id').val();
        var aluno_id = $('#alunos').val();
        if(aluno_id == ''){
            $.alert({
                title: 'Erro!',
                content: 'Você precisa selecionar um aluno!',
            });
            return;
        }
        $.confirm({
            title: 'Adicionar aluno',
            content: 'Tem certeza que deseja adicionar o aluno a turma?',
            buttons: {
                adicionar: function(){
                    $.get("/turmas/vincular/alunos/" + turma_id + "/" + aluno_id, function(data) {
                        if(data['status'] == 'success'){
                            $.confirm({
                                title: 'Aluno adicionado',
                                content: 'Aluno adicionado na turma com sucesso.',
                                buttons: {
                                    Ok: {
                                        action: function(){
                                            location.reload();
                                        }
                                    }
                                }
                            });
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
    $('.delete').click(function(){
        var delete_button = $(this).val();
        $.confirm({
            title: 'Excluir registro',
            content: 'Tem certeza que deseja excluir o registro?',
            buttons: {
                excluir: function(){
                    $.get("/turmas/desvincular/alunos/" + delete_button, function(data) {
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
                                content: 'Houve um erro ao excluir o registro. Tente novamente.',
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
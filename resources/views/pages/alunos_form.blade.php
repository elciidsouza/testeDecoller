@extends('layouts.app', ['activePage' => 'alunos', 'titlePage' => __('Criar/Editar Alunos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row">          
            <div class="col-md-12">
              <div class="card">
                  <div class="card-header card-header-warning">
                      <h4 class="card-title">Criar/Editar Alunos</h4>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="{{ route('aluno.salvar') }}">
                        @csrf

                        @if(isset($model->id))
                            <input type="hidden" name="id" value="{{$model->id}}">
                        @endif

                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo.." required @isset($model->nome) value="{{$model->nome}}" @endif>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail.." required @isset($model->email) value="{{$model->email}}" @endif>
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control telefone" id="telefone" name="telefone" placeholder="(00) 00000-0000" required @isset($model->telefone) value="{{$model->telefone}}" @endif>
                        </div>

                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control cep" id="cep" name="cep" placeholder="00000-000" required @isset($model->cep) value="{{$model->cep}}" @endif>
                        </div>

                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Digite seu endereço completo" required @isset($model->endereco) value="{{$model->endereco}}" @endif>
                        </div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-primary"><i class="material-icons">save</i> Salvar</button>
                            <a href="/alunos" class="btn btn-default"><i class="material-icons">keyboard_backspace</i> Voltar</a>
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

@section('js')
<script>
    $( document ).ready(function() {
        $(".telefone").mask("(00) 0000-0000");
        $(".cep").mask("00000-000");

        $("#cep").blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {                        
                    $("#endereco").val("...");

                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            $("#endereco").val(dados.logradouro);
                        } else {
                            alert("CEP não encontrado. Por favor, digite seu endereço manualmente.");
                            $("#endereco").val('');
                            $("#endereco").focus();
                        }
                    });
                } else {
                    alert("Formato de CEP inválido.");
                }
            }
        });    
    });
</script>
@endsection
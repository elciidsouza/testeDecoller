<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alunos;
use App\AlunosTurma;

class AlunosController extends Controller
{
    public function __construct()
    {
        $this->extraParams = [
            'alunos' => Alunos::all(),
        ];
    }
    
    public function index()
    {
        return view('pages.alunos', $this->extraParams);
    }

    public function create(Request $request){
        return view('pages.alunos_form', $this->extraParams);
    }

    public function edit(Request $request){
        return view('pages.alunos_form', array_merge([
            'model' => Alunos::findOrFail($request->id),
        ], $this->extraParams));
    }
    
    public function store(Request $request){

        $this->validate($request, $this->rulesValidate());

        if(isset($request->id)){
            $alunos = Alunos::findOrFail($request->id);
            if( !$alunos->update($request->all()) ){
                throw new Exception("Falha ao Atualizar");
            }
            
            toastr()->success('Aluno editado com sucesso!');
            return redirect()->route('alunos');
        } else {
            $alunos = Alunos::create($request->all());
            if(!$alunos){
                throw new Exception("Falha ao inserir");
            }

            toastr()->success('Aluno criado com sucesso!');
            return redirect()->route('alunos');
        }
    }

    private function rulesValidate(): array
    {
        return [
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'cep' => 'required',
            'endereco' => 'required',
        ];
    }

    public function delete($id){
        $checkAlunoTurma = AlunosTurma::where('aluno_id', $id)->get();
        if(count($checkAlunoTurma) > 0){
            return [
                'status' => 'error',
                'msg' => 'O aluno está cadastrado a uma turma e não pode ser excluído.',
            ];
        }

        $aluno = Alunos::find($id);
        if($aluno->delete()){
            return [
                'status' => 'success',
            ];
        } else {
            return [
                'status' => 'error',
                'msg' => 'Ocorreu um erro ao tentar excluir o aluno. Tente novamente.',
            ];
        }
    }
}

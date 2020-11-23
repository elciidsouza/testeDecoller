<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turmas;
use App\AlunosTurma;
use App\Alunos;

class TurmasController extends Controller
{
    public function __construct()
    {
        $this->extraParams = [
            'turmas' => Turmas::all(),
        ];
    }
    
    public function index()
    {
        return view('pages.turmas', $this->extraParams);
    }

    public function create(Request $request){
        return view('pages.turmas_form', $this->extraParams);
    }

    public function edit(Request $request){
        return view('pages.turmas_form', array_merge([
            'model' => Turmas::findOrFail($request->id),
        ], $this->extraParams));
    }
    
    public function store(Request $request){
        //dd('teste');

        $this->validate($request, $this->rulesValidate());

        if(isset($request->id)){
            $turmas = Turmas::findOrFail($request->id);
            if( !$turmas->update($request->all()) ){
                throw new Exception("Falha ao Atualizar");
            }
            
            toastr()->success('Aluno editado com sucesso!');
            return redirect()->route('turmas');
        } else {
            $turmas = Turmas::create($request->all());
            if(!$turmas){
                throw new Exception("Falha ao inserir");
            }

            toastr()->success('Aluno criado com sucesso!');
            return redirect()->route('turmas');
        }
    }

    private function rulesValidate(): array
    {
        return [
            'nome_turma' => 'required',
            'qtd_vagas' => 'required',
            'dt_inicio' => 'required',
        ];
    }

    public function delete($id){
        $checkAlunoTurma = AlunosTurma::where('turma_id', $id)->get();
        if(count($checkAlunoTurma) > 0){
            return [
                'status' => 'error',
                'msg' => 'A turma contém alunos e não pode ser excluída.',
            ];
        }

        $aluno = Turmas::find($id);
        if($aluno->delete()){
            return [
                'status' => 'success',
            ];
        } else {
            return [
                'status' => 'error',
                'msg' => 'Ocorreu um erro ao tentar excluir a turma. Tente novamente.',
            ];
        }
    }

    public function vincularAlunos($id){
        return view('pages.vincular_alunos', array_merge([
            'turma' => Turmas::find($id),
            'turma_id' => $id,
            'alunosTurma' => AlunosTurma::join('alunos', 'alunos.id', '=', 'aluno_id')->where('turma_id', $id)->select('alunos_turma.*', 'alunos.nome', 'alunos.email', 'alunos.telefone')->get(),
            'alunosLista' => Alunos::all(),
        ], $this->extraParams));
    }

    public function vincularAlunosTurma($turma_id, $aluno_id){
        $verificarAlunosTurma = AlunosTurma::where('turma_id', $turma_id)->where('aluno_id', $aluno_id)->get();
        if(count($verificarAlunosTurma) > 0){
            return [
                'status' => 'error',
                'msg' => 'Aluno já cadastrado na turma.'
            ];
        } else {
            $qtdVagasTurma = Turmas::find($turma_id);
            $verificarVagasTurma = AlunosTurma::where('turma_id', $turma_id)->get();
            if(count($verificarVagasTurma) < $qtdVagasTurma->qtd_vagas){
                $adicionarAlunosTurma = new AlunosTurma;
                $adicionarAlunosTurma->turma_id = $turma_id;
                $adicionarAlunosTurma->aluno_id = $aluno_id;
                if($adicionarAlunosTurma->save()){
                    return [
                        'status' => 'success'
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'msg' => 'O limite de vagas desta turma já foi atingido.'
                ];
            }
        }
    }

    public function desvincularAlunosTurma($id){
        $alunosTurma = AlunosTurma::find($id);
        if($alunosTurma->delete()){
            return [
                'status' => 'success',
            ];
        } else {
            return [
                'status' => 'error',
            ];
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Alunos;
use App\Turmas;
use App\AlunosTurma;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->extraParams = [
            'alunos' => Alunos::all(),
            'turmas' => Turmas::all(),
            'alunosTurma' => AlunosTurma::all(),
        ];
    }

    public function index()
    {
        return view('dashboard', $this->extraParams);
    }
}

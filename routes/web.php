<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// ROTAS DOS ALUNOS
Route::get('/alunos', 'AlunosController@index')->name('alunos');
Route::get('/alunos/form', 'AlunosController@create')->name('aluno.form');
Route::get('/alunos/form/{id}/editar', 'AlunosController@edit')->name('aluno.editar');
Route::post('/alunos/form', 'AlunosController@store')->name('aluno.salvar');
Route::get('/alunos/delete/{id}', 'AlunosController@delete')->name('aluno.deletar');

// ROTAS DAS TURMAS
Route::get('/turmas', 'TurmasController@index')->name('turmas');
Route::get('/turmas/form', 'TurmasController@create')->name('turmas.form');
Route::get('/turmas/form/{id}/editar', 'TurmasController@edit')->name('turmas.editar');
Route::post('/turmas/salvar', 'TurmasController@store')->name('turmas.salvar');
Route::get('/turmas/delete/{id}', 'TurmasController@delete')->name('turmas.deletar');
Route::get('/turmas/vincular/alunos/{id}', 'TurmasController@vincularAlunos')->name('turmas.vincular.aluno');
Route::get('/turmas/vincular/alunos/{turma_id}/{aluno_id}', 'TurmasController@vincularAlunosTurma')->name('turmas.vincular.aluno.turma');
Route::get('/turmas/desvincular/alunos/{id}', 'TurmasController@desvincularAlunosTurma')->name('turmas.desvincular.aluno.turma');

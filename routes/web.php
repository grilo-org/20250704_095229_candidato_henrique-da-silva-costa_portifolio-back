<?php

use App\Http\Controllers\BarbeariaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


// LOGIN
Route::get('/usuario', [UsuarioController::class, "pegarUsuario"])->name("UsuarioController.pegarUsuario");
Route::post('/cadastrar/usuario', [UsuarioController::class, "cadastrar"])->name("UsuarioController.cadastrar");
Route::post('/login', [UsuarioController::class, "login"])->name("UsuarioController.login");
Route::post('/loginmaster', [UsuarioController::class, "loginMaster"])->name("UsuarioController.loginMaster");
Route::post('/recuperarsenha', [UsuarioController::class, "recuperarsenha"])->name("UsuarioController.recuperarsenha");
Route::post('/recuperarsenha/email', [UsuarioController::class, "recuperarsenhaemail"])->name("UsuarioController.recuperarsenhaemail");

// RESERVAS
Route::get('/reservas/horarios', [ReservasController::class, "todosHorarios"])->name("ReservasController.todosHorarios");
Route::get('/reservas/servicos', [ReservasController::class, "todosServicos"])->name("ReservasController.todosServicos");
Route::get('/reservas', [ReservasController::class, "todasReservas"])->name("ReservasController.todasReservas");
Route::get('/reserva', [ReservasController::class, "reserva"])->name("ReservasController.reserva");
Route::post('/reserva', [ReservasController::class, "cadastrar"])->name("ReservasController.cadastrar");
Route::put('/reserva', [ReservasController::class, "editar"])->name("ReservasController.editar");
Route::delete('/reserva', [ReservasController::class, "excluir"])->name("ReservasController.excluir");
Route::post('/reserva/verificar', [ReservasController::class, "existeReserva"])->name("ReservasController.existeReserva");

// PAGAMMENTO
Route::get('/chave', [PagamentoController::class, "chavePublica"])->name("PagamentoController.chevePuvblica");
Route::post('/pagamentocartao', [PagamentoController::class, "pagamentoCartao"])->name("PagamentoController.pagamentoCartao");
Route::get('/pagamentopix', [PagamentoController::class, "pagamentoPix"])->name("PagamentoController.pagamentoPix");

//BARBEARIA
Route::get("/barbearia/reservas", [BarbeariaController::class, "reservas"])->name("BarbeariaController.reservas");
Route::get("/barbearia", [BarbeariaController::class, "pegarBarbeariasPorId"])->name("BarbeariaController.pegarBarbeariasPorId");
Route::get("/barbearias", [BarbeariaController::class, "todos"])->name("BarbeariaController.todos");
Route::get("/barbearias/filtros", [BarbeariaController::class, "pegarBarbeariasPorFiltro"])->name("BarbeariaController.pegarBarbeariasPorFiltro");
Route::get("/barbeariasunicas", [BarbeariaController::class, "pegarPorId"])->name("BarbeariaController.pegarPorId");
Route::post("/barbearia/cadastrar", [BarbeariaController::class, "cadastrar"])->name("BarbeariaController.cadastrar");
Route::delete("/barbearia/excluir", [BarbeariaController::class, "excluir"])->name("BarbeariaController.excluir");
Route::put("/barbearia/editar", [BarbeariaController::class, "editar"])->name("BarbeariaController.editar");

//Horario
Route::get("/horario", [HorarioController::class, "horario"])->name("HorarioController.horario");
Route::get("/barbearia/horarios/normal", [HorarioController::class, "horariosNormal"])->name("HorarioController.horariosNormal");
Route::get("/barbearia/horarios", [HorarioController::class, "horarios"])->name("HorarioController.horarios");
Route::post("/barbearia/cadastrar/horario", [HorarioController::class, "cadastrar"])->name("HorarioController.cadastrar");
Route::put("/barbearia/horarios/editar", [HorarioController::class, "editar"])->name("HorarioController.editar");
Route::delete("/barbearia/horarios/excluir", [HorarioController::class, "excluir"])->name("HorarioController.excluir");

//SERVIÇO
Route::get("/servico", [ServicoController::class, "servico"])->name("ServicoController.servico");
Route::get("/barbearia/servicos/normal", [ServicoController::class, "servicosNormal"])->name("ServicoController.servicosNormal");
Route::get("/barbearia/servicos", [ServicoController::class, "servicos"])->name("ServicoController.servicos");
Route::post("/barbearia/cadastrar/servico", [ServicoController::class, "cadastrar"])->name("ServicoController.cadastrar");
Route::put("/barbearia/servicos/editar", [ServicoController::class, "editar"])->name("ServicoController.editar");
Route::delete("/barbearia/servicos/excluir", [ServicoController::class, "excluir"])->name("ServicoController.excluir");

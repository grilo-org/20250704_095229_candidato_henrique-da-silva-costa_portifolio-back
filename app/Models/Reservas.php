<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class Reservas extends Model
{
    use HasFactory;

    protected $table = Tabela::RESERVA;
    protected $tabela = Tabela::RESERVA;
    protected $tabelaHorario = Tabela::HORARIOS;
    protected $tabelaServico = Tabela::SERVICOS;

    public function todos()
    {
        try {
            $dados = DB::table($this->tabela)->get();

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarPorId($id)
    {
        try {
            if (!is_numeric($id)) {
                return NULL;
            }

            $dados = DB::table($this->tabela)
                ->where("id", "=", $id)
                ->first(["id", "data", "hora", "servico_id", "barbearia_id"]);

            return $dados;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function todosHorarios()
    {
        try {
            $dados = DB::table($this->tabelaHorario)->get();
            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function todosServicos()
    {
        try {
            $dados = DB::table($this->tabelaServico)->get();
            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function existeDataEHora($dados)
    {
        try {
            $data = isset($dados["data"]) ? $dados["data"] : NULL;
            $hora = isset($dados["hora"]) ? $dados["hora"] : NULL;
            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;

            $existe = DB::table($this->tabela)
                ->where("data", "=", $data)
                ->where("hora", "=", $hora)
                ->where("barbearia_id", "=", $barbearia_id)
                ->where("id", "<>", $id)
                ->first();

            if ($existe) {
                return TRUE;
            }

            return FALSE;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function cadastrar($dados)
    {
        try {
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $nome = isset($dados["nome_reserva"]) ? $dados["nome_reserva"] : NULL;
            $data = isset($dados["data"]) ? $dados["data"] : NULL;
            $hora = isset($dados["hora"]) ? $dados["hora"] : NULL;
            $servico_id = isset($dados["servico"]) ? $dados["servico"] : NULL;
            $usuario_id = isset($dados["usuarios_id"]) ? $dados["usuarios_id"] : NULL;
            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;

            DB::table($this->tabela)->insert([
                "nome" => $nome,
                "data" => $data,
                "hora" => $hora,
                "servico_id" => $servico_id,
                "usuarios_id" => $usuario_id,
                "barbearia_id" => $barbearia_id,
            ]);

            return $resposta;
        } catch (\Throwable $th) {
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }

    public function editar($dados)
    {
        try {
            $resposta = new stdClass;
            $resposta->erro = FALSE;
            $resposta->msg = NULL;

            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $data = isset($dados["data"]) ? $dados["data"] : NULL;
            $hora = isset($dados["hora"]) ? $dados["hora"] : NULL;
            $servico_id = isset($dados["servico"]) ? $dados["servico"] : NULL;

            DB::table($this->tabela)->where("id", "=", $id)->update([
                "data" => $data,
                "hora" => $hora,
                "servico_id" => $servico_id,
            ]);

            return $resposta;
        } catch (\Throwable $th) {

            print_r($th->getMessage());
            $resposta = new stdClass;
            $resposta->erro = TRUE;
            $resposta->msg = $th->getMessage();

            return $resposta;
        }
    }

    public function excluir($id)
    {
        if (!is_numeric($id)) {
            return NULL;
        }

        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            DB::table($this->tabela)
                ->where("id", "=", $id)
                ->delete();

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }
}

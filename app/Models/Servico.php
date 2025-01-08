<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class Servico extends Model
{
    use HasFactory;

    protected $table = Tabela::SERVICOS;
    protected $tabela = Tabela::SERVICOS;
    protected $tabelaReserva = Tabela::RESERVA;

    public function todosNormal($barbearia_id)
    {
        try {
            if (!is_numeric($barbearia_id)) {
                return [];
            }

            $dados = DB::table($this->tabela)
                ->where("barbearia_id", "=", $barbearia_id)
                ->orderBy("id", "desc")
                ->get();


            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function todos($barbearia_id)
    {
        try {
            if (!is_numeric($barbearia_id)) {
                return [];
            }

            $dados = DB::table($this->tabela)
                ->where("barbearia_id", "=", $barbearia_id)
                ->orderBy("id", "desc")
                ->paginate(2);

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
                ->first();

            return $dados;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function cadastrar($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;
            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $valor = isset($dados["valor"]) ? $dados["valor"] : NULL;

            DB::table($this->tabela)->insert([
                "barbearia_id" => $barbearia_id,
                "nome" => $nome,
                "valor" => $valor,
            ]);

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }

    public function existe($dados)
    {
        try {
            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;
            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;

            $sql = DB::table($this->tabela);
            $sql->where("{$this->tabela}.barbearia_id", "=", $barbearia_id);
            $sql->where("{$this->tabela}.nome", "LIKE", "{$nome}");
            if ($sql) {
                $sql->where("{$this->tabela}.id", "<>", $id);
            }

            $existe = $sql->first();

            return $existe;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function exsiteServicoVinculado($id)
    {
        try {
            if (!is_numeric($id)) {
                return NULL;
            }

            $existe = DB::table($this->tabelaReserva)
                ->where("servico_id", "=", $id)
                ->first();

            return $existe;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function editar($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;
            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $valor = isset($dados["valor"]) ? $dados["valor"] : NULL;
            $id = isset($dados["id"]) ? $dados["id"] : NULL;

            DB::table($this->tabela)->where("id", "=", $id)->update([
                "barbearia_id" => $barbearia_id,
                "nome" => $nome,
                "valor" => $valor,
            ]);

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
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

            DB::table($this->tabela)->where("id", "=", $id)->delete();

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class Horario extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = Tabela::HORARIOS;
    protected $tabela = Tabela::HORARIOS;

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
                ->first(["horario", "id", "barbearia_id"]);

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
            $horario = isset($dados["horario"]) ? $dados["horario"] : NULL;

            DB::table($this->tabela)->insert([
                "barbearia_id" => $barbearia_id,
                "horario" => $horario
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
            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;
            $horario = isset($dados["horario"]) ? $dados["horario"] : NULL;

            $sql = DB::table($this->tabela);
            $sql->where("barbearia_id", "=", $barbearia_id);
            $sql->where("horario", "=", $horario);
            if ($sql) {
                $sql->where("id", "<>", $id);
            }

            $existe = $sql->first();

            return $existe;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function editar($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;
            $horario = isset($dados["horario"]) ? $dados["horario"] : NULL;
            $id = isset($dados["id"]) ? $dados["id"] : NULL;

            DB::table($this->tabela)
                ->where("id", "=", $id)
                ->update([
                    "barbearia_id" => $barbearia_id,
                    "horario" => $horario
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

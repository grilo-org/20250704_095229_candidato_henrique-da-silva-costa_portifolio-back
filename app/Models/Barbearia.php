<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class Barbearia extends Model
{
    use HasFactory;

    protected $table = Tabela::BARBEARIA;
    protected $tabela = Tabela::BARBEARIA;
    protected $tabelaServico = Tabela::SERVICOS;
    protected $tabelaHorario = Tabela::HORARIOS;
    protected $tabelaReserva = Tabela::RESERVA;
    protected $tabelaUsuario = Tabela::USUARIOS;

    public function todos()
    {
        try {
            $dados = DB::table($this->tabela)->get(["nome", "id"]);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function todasDisponiveis()
    {
        try {
            $dados = DB::table($this->tabela)
                ->join($this->tabelaHorario, "{$this->tabela}.id", "=", "{$this->tabelaHorario}.barbearia_id")
                ->join($this->tabelaServico, "{$this->tabela}.id", "=", "{$this->tabelaServico}.barbearia_id")
                ->select(["{$this->tabela}.*"])->distinct("{$this->tabela}.id")
                ->paginate(2);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarReservasFeitas($dados)
    {
        try {
            $barbearia_id = isset($dados["barbearia_id"]) ? $dados["barbearia_id"] : NULL;

            $sql = DB::table($this->tabelaReserva);
            $sql->join($this->tabelaUsuario, "{$this->tabelaReserva}.usuarios_id", "=", "{$this->tabelaUsuario}.id");
            $sql->join($this->tabelaServico, "{$this->tabelaReserva}.servico_id", "=", "{$this->tabelaServico}.id");
            $sql->join($this->tabela, "{$this->tabelaReserva}.barbearia_id", "=", "{$this->tabela}.id");
            $sql->where("{$this->tabelaReserva}.barbearia_id", "=", $barbearia_id);
            $sql->select([
                "{$this->tabelaReserva}.id",
                "{$this->tabelaReserva}.data",
                "{$this->tabelaReserva}.hora",
                "{$this->tabelaServico}.nome AS servico_nome",
                "{$this->tabelaUsuario}.nome AS usuario_nome",
                "{$this->tabela}.nome AS barberaria_nome"
            ])->distinct("{$this->tabelaReserva}.id");

            $dados = $sql->paginate(5);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarBarbeariasPorId($id)
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

    public function pegarBarbeariasPorFiltro($dados)
    {
        try {
            $filtroCidade = isset($dados["filtroCidade"]) ? $dados["filtroCidade"] : NULL;
            $filtroEstado = isset($dados["filtroEstado"]) ? $dados["filtroEstado"] : NULL;
            $filtroCep = isset($dados["filtroCep"]) ? $dados["filtroCep"] : NULL;
            $filtroNome = isset($dados["filtroNome"]) ? $dados["filtroNome"] : NULL;

            $sql = DB::table($this->tabela);
            $sql->join($this->tabelaHorario, "{$this->tabela}.id", "=", "{$this->tabelaHorario}.barbearia_id");
            $sql->join($this->tabelaServico, "{$this->tabela}.id", "=", "{$this->tabelaServico}.barbearia_id");
            $sql->select(["{$this->tabela}.*"])->distinct("{$this->tabela}.id");
            if ($filtroNome) {
                $sql->where("{$this->tabela}.nome", "LIKE", "{$filtroNome}%");
            }

            if ($filtroCep) {
                $sql->where("{$this->tabela}.cep", "LIKE", "{$filtroCep}%");
            }

            if ($filtroEstado) {
                $sql->where("{$this->tabela}.estado", "LIKE", "{$filtroEstado}%");
            }

            if ($filtroCidade) {
                $sql->where("{$this->tabela}.localidade", "LIKE", "{$filtroCidade}%");
            }

            $dados = $sql->paginate(2);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function pegarPorId($id)
    {
        try {
            if (!is_numeric($id)) {
                return [];
            }

            $dados = DB::table($this->tabela)
                ->where("usuarios_id", "=", $id)
                ->orderBy("id", "desc")
                ->paginate(3);

            return $dados;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function cadastrar($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $usuarios_id = isset($dados["usuarios_id"]) ? $dados["usuarios_id"] : NULL;
            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $telefone = isset($dados["telefone"]) ? $dados["telefone"] : NULL;
            $numero = isset($dados["numero"]) ? $dados["numero"] : NULL;
            $cep = isset($dados["cep"]) ? $dados["cep"] : NULL;
            $logradouro = isset($dados["logradouro"]) ? $dados["logradouro"] : NULL;
            $bairro = isset($dados["bairro"]) ? $dados["bairro"] : NULL;
            $localidade = isset($dados["localidade"]) ? $dados["localidade"] : NULL;
            $estado = isset($dados["estado"]) ? $dados["estado"] : NULL;

            DB::table($this->tabela)->insert([
                "usuarios_id" => $usuarios_id,
                "nome" => $nome,
                "telefone" => $telefone,
                "numero" => $numero,
                "cep" => $cep,
                "logradouro" => $logradouro,
                "bairro" => $bairro,
                "localidade" => $localidade,
                "estado" => $estado,
            ]);

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }

    public function exsiteBarbeariaComEssasCondicoes($dados)
    {
        try {
            // $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $numero = isset($dados["numero"]) ? $dados["numero"] : NULL;
            $cep = isset($dados["cep"]) ? $dados["cep"] : NULL;
            // $logradouro = isset($dados["logradouro"]) ? $dados["logradouro"] : NULL;
            // $bairro = isset($dados["bairro"]) ? $dados["bairro"] : NULL;
            // $localidade = isset($dados["localidade"]) ? $dados["localidade"] : NULL;
            // $estado = isset($dados["estado"]) ? $dados["estado"] : NULL;

            $existe = DB::table($this->tabela)
                ->where("numero", "=", $numero)
                ->where("cep", "=", $cep)
                ->where("id", "<>", $id)
                ->first();

            return $existe;
        } catch (\Throwable $th) {
            return NULL;
        }
    }


    public function exsiteBarbeariaVinculada($id)
    {
        try {

            if (!is_numeric($id)) {
                return NULL;
            }

            $msg = NULL;

            $existeReserva = DB::table($this->tabelaReserva)
                ->where("barbearia_id", "=", $id)
                ->first();

            $existeHorario = DB::table($this->tabelaHorario)
                ->where("barbearia_id", "=", $id)
                ->first();

            $existeServiço = DB::table($this->tabelaServico)
                ->where("barbearia_id", "=", $id)
                ->first();


            if ($existeServiço) {
                $msg = "Essa barbearia já está vinculada a um serviço";
            }

            if ($existeHorario) {
                $msg = "Essa barbearia já está vinculada a um horário";
            }

            if ($existeReserva) {
                $msg = "Essa barbearia já está vinculada a uma reserva";
            }

            return $msg;
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

            $id = isset($dados["id"]) ? $dados["id"] : NULL;
            $usuarios_id = isset($dados["usuarios_id"]) ? $dados["usuarios_id"] : NULL;
            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $telefone = isset($dados["telefone"]) ? $dados["telefone"] : NULL;
            $numero = isset($dados["numero"]) ? $dados["numero"] : NULL;
            $cep = isset($dados["cep"]) ? $dados["cep"] : NULL;
            $logradouro = isset($dados["logradouro"]) ? $dados["logradouro"] : NULL;
            $bairro = isset($dados["bairro"]) ? $dados["bairro"] : NULL;
            $localidade = isset($dados["localidade"]) ? $dados["localidade"] : NULL;
            $estado = isset($dados["estado"]) ? $dados["estado"] : NULL;

            DB::table($this->tabela)
                ->where("id", "=", $id)
                ->update([
                    "usuarios_id" => $usuarios_id,
                    "nome" => $nome,
                    "telefone" => $telefone,
                    "numero" => $numero,
                    "cep" => $cep,
                    "logradouro" => $logradouro,
                    "bairro" => $bairro,
                    "localidade" => $localidade,
                    "estado" => $estado,
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

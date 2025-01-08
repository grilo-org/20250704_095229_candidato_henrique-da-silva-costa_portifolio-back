<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;

class Usuario extends Model
{
    use HasFactory;

    protected $table = Tabela::USUARIOS;
    protected $tabela = Tabela::USUARIOS;

    public function pegarPorId($id)
    {
        try {
            if (!is_numeric($id)) {
                return NULL;
            }

            $dados = DB::table($this->tabela)
                ->where("id", "=", $id)
                ->first("id");

            return $dados;
        } catch (\Throwable $th) {
            return NULL;
        }
    }


    public function cadastro($dados, $img_caminho)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $nome = isset($dados["nome"]) ? $dados["nome"] : NULL;
            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? $dados["senha"] : NULL;
            $master = isset($dados["master"]) ? $dados["master"] : NULL;
            $img = isset($img_caminho) ? $img_caminho : NULL;

            DB::table($this->tabela)->insert([
                "nome" => $nome,
                "email" => $email,
                "img" => $img,
                "master" => $master,
                "senha" => Hash::make($senha),
            ]);

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }

    public function existeUsuario($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? $dados["senha"] : NULL;

            $exsite = DB::table($this->tabela)
                ->where("email", "=", $email)
                ->where("master", "=", 0)
                ->first();

            if ($exsite && hash::check($senha, $exsite->senha)) {
                return $exsite;
            }

            return FALSE;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }

    public function existeUsuarioMaster($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $email = isset($dados["email"]) ? $dados["email"] : NULL;
            $senha = isset($dados["senha"]) ? $dados["senha"] : NULL;

            $exsite = DB::table($this->tabela)
                ->where("email", "=", $email)
                ->where("master", "=", 1)
                ->first();

            if ($exsite && hash::check($senha, $exsite->senha)) {
                return $exsite;
            }

            return FALSE;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }

    public function existeEmail($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $email = isset($dados["email"]) ? $dados["email"] : NULL;

            $exsite = DB::table($this->tabela)
                ->where("email", "=", $email)
                ->first();

            if ($exsite) {
                return $exsite;
            }

            return FALSE;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }

    public function existeSenha($senha)
    {
        try {
            if (!$senha) {
                return NULL;
            }

            $exsite = DB::table($this->tabela)
                ->where("senha", "=", $senha)
                ->first();

            if ($exsite) {
                return TRUE;
            }

            return NULL;
        } catch (\Throwable $th) {
            return NULL;
        }
    }

    public function recuperarSenha($dados)
    {
        try {
            $retorno = new stdClass;
            $retorno->erro = FALSE;
            $retorno->msg = NULL;

            $novasenha = isset($dados["novasenha"]) ? $dados["novasenha"] : NULL;
            $emailcomfirmar = isset($dados["emailcomfirmar"]) ? $dados["emailcomfirmar"] : NULL;

            $exsite = DB::table($this->tabela)
                ->where("email", "=", $emailcomfirmar)
                ->first();

            if ($exsite) {
                DB::table($this->tabela)
                    ->where("email", "=", $emailcomfirmar)
                    ->update(["senha" => hash::make($novasenha)]);
            }

            return $retorno;
        } catch (\Throwable $th) {
            $retorno = new stdClass;
            $retorno->erro = TRUE;
            $retorno->msg = $th->getMessage();

            return $retorno;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    protected $servico;

    public function __construct()
    {
        $this->servico = new Servico();
    }

    public function servicosNormal(Request $request)
    {
        $barbearia_id = isset($request["barbearia_id"]) ? $request["barbearia_id"] : NULL;

        $servicos = $this->servico->todosNormal($barbearia_id);

        return response()->json($servicos);
    }

    public function servicos(Request $request)
    {
        $barbearia_id = isset($request["barbearia_id"]) ? $request["barbearia_id"] : NULL;

        $servicos = $this->servico->todos($barbearia_id);

        return response()->json($servicos);
    }

    public function servico(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        $servicos = $this->servico->pegarPorId($id);

        return response()->json($servicos);
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            "barbearia_id" => "required",
            "nome" => "required|max:255",
            "valor" => "required|numeric",
        ]);

        $inputs = $request->all();

        $valor = isset($inputs["valor"]) ? $inputs["valor"] : NULL;

        if (strlen($valor) > 8) {
            return response()->json(["error" => TRUE, "msg" => "O valor não pode ter mais que 8 caracteres"]);
        }

        if ($valor <= 0) {
            return response()->json(["error" => TRUE, "msg" => "O valor tem que ser maior que zero"]);
        }

        $existe = $this->servico->existe($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Serviço já cadastrado"]);
        }

        $cadastrar = $this->servico->cadastrar($inputs);

        if ($cadastrar->erro) {
            return response()->json(["error" => TRUE, "msg" => $cadastrar->msg]);
        }

        return response()->json(["error" => FALSE]);
    }

    public function editar(Request $request)
    {
        $request->validate([
            "nome" => "required|max:255",
            "valor" => "required|numeric",
        ]);

        $inputs = $request->all();

        $valor = isset($inputs["valor"]) ? $inputs["valor"] : NULL;

        if (strlen($valor) > 8) {
            return response()->json(["error" => TRUE, "msg" => "O valor não pode ter mais que 8 caracteres"]);
        }

        if ($valor < 1) {
            return response()->json(["error" => TRUE, "msg" => "O valor tem que ser maior que zero"]);
        }

        $existe = $this->servico->existe($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Serviço já cadastrado"]);
        }

        $editar = $this->servico->editar($inputs);

        if ($editar->erro) {
            return response()->json(["error" => TRUE, "msg" => $editar->erro]);
        }

        return response()->json(["error" => FALSE, "msg" => NULL]);
    }

    public function excluir(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;


        if (!$id) {
            return response()->json(["error" => TRUE, "msg" => "Serviço não existe", "id" => NULL]);
        }

        $existe = $this->servico->exsiteServicoVinculado($id);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Esse serviço está vinculado", "id" => NULL]);
        }

        $excluir = $this->servico->excluir($id);

        if ($excluir->erro) {
            return response()->json(["error" => TRUE, "msg" => $excluir->msg, "id" => $id]);
        }

        return response()->json(["error" => FALSE, "msg" => null]);
    }
}

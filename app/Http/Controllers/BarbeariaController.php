<?php

namespace App\Http\Controllers;

use App\Models\Barbearia;
use App\Models\Horario;
use App\Models\Servico;
use Illuminate\Http\Request;

class BarbeariaController extends Controller
{
    protected $barbearia;
    protected $servico;
    protected $horario;

    public function __construct()
    {
        $this->barbearia = new Barbearia();
        $this->servico = new Servico();
        $this->horario = new Horario();
    }

    public function reservas(Request $request)
    {
        $inputs = $request->all();

        $barbearias = $this->barbearia->pegarReservasFeitas($inputs);

        return response()->json($barbearias);
    }

    public function paginacao()
    {
        $barbearias = $this->barbearia->paginacao();

        return response()->json($barbearias);
    }

    public function todos()
    {
        $barbearias = $this->barbearia->todasDisponiveis();

        return response()->json($barbearias);
    }

    public function pegarBarbeariasPorId(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        $barbearias = $this->barbearia->pegarBarbeariasPorId($id);

        return response()->json($barbearias);
    }

    public function pegarBarbeariasPorFiltro(Request $request)
    {
        $inputs = $request->all();

        $barbearias = $this->barbearia->pegarBarbeariasPorFiltro($inputs);

        return response()->json($barbearias);
    }

    public function pegarPorId(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        $barbearias = $this->barbearia->pegarPorId($id);

        return response()->json($barbearias);
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            "usuarios_id" => "required",
            "nome" => "required|max:255",
            "cep" => "required|max:255",
            "logradouro" => "required|max:255",
            "bairro" => "required|max:255",
            "localidade" => "required|max:255",
            "estado" => "required|max:255",
            "numero" => "required|max:10",
            "telefone" => "required|max:15"
        ]);

        $inputs = $request->all();

        $telefone = isset($inputs["telefone"]) ? $inputs["telefone"] : NULL;

        if (strlen($telefone) > 15) {
            return response()->json(["error" => TRUE, "msg" => "O valor não pode ter mais que 8 caracteres"]);
        }

        $existe = $this->barbearia->exsiteBarbeariaComEssasCondicoes($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Já existe uma barbearia nesse endereço"]);
        }

        $cadastrar = $this->barbearia->cadastrar($inputs);

        if ($cadastrar->erro) {
            return response()->json(["error" => TRUE, "msg" => $cadastrar->msg]);
        }

        return response()->json(["error" => FALSE]);
    }

    public function editar(Request $request)
    {
        $request->validate([
            "id" => "required",
            "nome" => "required|max:255",
            "cep" => "required|max:255",
            "logradouro" => "required|max:255",
            "bairro" => "required|max:255",
            "localidade" => "required|max:255",
            "estado" => "required|max:255",
            "numero" => "required|max:10",
            "telefone" => "required|max:15",
        ]);

        $inputs = $request->all();

        $telefone = isset($inputs["telefone"]) ? $inputs["telefone"] : NULL;

        if (strlen($telefone) > 15) {
            return response()->json(["error" => TRUE, "msg" => "O valor não pode ter mais que 8 caracteres"]);
        }

        $existe = $this->barbearia->exsiteBarbeariaComEssasCondicoes($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Já existe uma barbearia nesse endereço"]);
        }

        $editar = $this->barbearia->editar($inputs);

        if ($editar->erro) {
            return response()->json(["error" => TRUE, "msg" => $editar->erro]);
        }

        return response()->json(["error" => FALSE, "msg" => NULL]);
    }

    public function excluir(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        if (!$id) {
            return response()->json(["erro" => TRUE, "msg" => "Barbearia não existe", "id" => NULL]);
        }

        $existe = $this->barbearia->exsiteBarbeariaVinculada($id);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => $existe, "id" => NULL]);
        }

        $excluir = $this->barbearia->excluir($id);

        if ($excluir->erro) {
            return response()->json(["error" => TRUE, "id" => $id]);
        }

        return response()->json(["erro" => FALSE, "msg" => null]);
    }
}

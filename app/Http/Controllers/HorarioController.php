<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    protected $horario;

    public function __construct()
    {
        $this->horario = new Horario();
    }

    public function horariosNormal(Request $request)
    {
        $barbearia_id = isset($request["barbearia_id"]) ? $request["barbearia_id"] : NULL;

        $horarios = $this->horario->todosNormal($barbearia_id);

        return response()->json($horarios);
    }

    public function horarios(Request $request)
    {
        $barbearia_id = isset($request["barbearia_id"]) ? $request["barbearia_id"] : NULL;

        $horarios = $this->horario->todos($barbearia_id);

        return response()->json($horarios);
    }

    public function horario(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        $horarios = $this->horario->pegarPorId($id);

        return response()->json($horarios);
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            "barbearia_id" => "required",
            "horario" => "required",
        ]);

        $inputs = $request->all();

        $existe = $this->horario->existe($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Horário já cadastrado"]);
        }

        $cadastrar = $this->horario->cadastrar($inputs);

        if ($cadastrar->erro) {
            return response()->json(["error" => TRUE, "msg" => $cadastrar->msg]);
        }

        return response()->json(["error" => FALSE]);
    }

    public function editar(Request $request)
    {
        $request->validate([
            "horario" => "required",
        ]);

        $inputs = $request->all();

        $existe = $this->horario->existe($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "Horário já cadastrado"]);
        }

        $editar = $this->horario->editar($inputs);

        if ($editar->erro) {
            return response()->json(["error" => TRUE, "msg" => $editar->msg]);
        }

        return response()->json(["error" => FALSE, "msg" => NULL]);
    }


    public function excluir(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        if (!$id) {
            return response()->json(["erro" => TRUE, "msg" => "Horário não existe", "id" => NULL]);
        }

        $excluir = $this->horario->excluir($id);

        if ($excluir->erro) {
            return response()->json(["erro" => TRUE, "msg" => $excluir->msg, "id" => $id]);
        }

        return response()->json(["erro" => FALSE, "msg" => null]);
    }
}

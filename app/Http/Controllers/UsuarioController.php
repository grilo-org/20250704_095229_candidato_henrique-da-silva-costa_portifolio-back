<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    protected $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function pegarUsuario(Request $request)
    {
        $id = isset($request["id"]) ? $request["id"] : NULL;

        $usuario = $this->usuario->pegarPorId($id);

        return response()->json($usuario);
    }

    public function cadastrar(Request $request)
    {
        $inputs = $request->all();
        $tiposImg = ["jpg", "png", "gif", "svg", "jpeg"];

        $img = isset($inputs["img"]) ? $inputs["img"] : NULL;

        if (!in_array($img->extension(), $tiposImg)) {
            return response()->json(["error" => TRUE, "msg" => "Tipo de imagem invalido"]);
        }

        $imgNome = time() . '.' . $img->extension();
        $img->storeAs('public/images', $imgNome);

        $img_caminho = asset('storage/images/' . $imgNome);

        $request->validate(
            [
                "nome" => "required|max:255",
                "email" => "required|email|max:255",
                "senha" => "required|max:255|min:3",
            ]
        );

        $existe = $this->usuario->existeEmail($inputs);

        if ($existe) {
            return response()->json(["error" => TRUE, "msg" => "E-mail já exístente"]);
        }

        $cadastrar = $this->usuario->cadastro($inputs, $img_caminho);

        if ($cadastrar->erro) {
            return response()->json(["error" => TRUE, "msg" => $cadastrar->msg]);
        }
        return response()->json(["error" => FALSE]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:255",
            "senha" => "required|max:255"
        ],);

        $inputs = $request->all();

        $usuario = $this->usuario->existeUsuario($inputs);

        if (!$usuario || $usuario->master == 1) {
            return response()->json(["error" => TRUE, "msg" => "E-mail ou senha incorreto"]);
        }

        $dados = [
            "nome" => $usuario->nome,
            "id" =>  $usuario->id,
            "img" =>  $usuario->img,
        ];

        return response()->json(["error" => FALSE, "usuario" => $dados]);
    }

    public function loginMaster(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:255",
            "senha" => "required|max:255|min:3"
        ]);

        $inputs = $request->all();

        $usuario = $this->usuario->existeUsuarioMaster($inputs);

        if (!$usuario || !$usuario->master) {
            return response()->json(["error" => TRUE, "msg" => "E-mail ou senha incorreto"]);
        }

        $dados = [
            "nome" => $usuario->nome,
            "id" =>  $usuario->id,
            "master" =>  $usuario->master,
            "img" =>  $usuario->img,
        ];

        return response()->json(["error" => FALSE, "usuario" => $dados]);
    }

    public function recuperarsenhaemail(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:255",
        ]);

        $inputs = $request->all();

        $existe = $this->usuario->existeEmail($inputs);

        if (!$existe) {
            return response()->json(["error" => TRUE, "msg" => "Esse e-mail não exíste"]);
        }

        return response()->json(["error" => FALSE]);
    }

    public function recuperarsenha(Request $request)
    {
        $request->validate([
            "novasenha" => "required|max:255|min:3",
            "confirmasenha" => "required|max:255|min:3"
        ]);

        $inputs = $request->all();

        $novasenha = isset($inputs["novasenha"]) ? $inputs["novasenha"] : NULL;
        $confirmasenha = isset($inputs["confirmasenha"]) ? $inputs["confirmasenha"] : NULL;

        if ($novasenha != $confirmasenha) {
            return response()->json(["error" => TRUE, "msg" => "As senhas não são iguais"]);
        }

        $recuperarsenha = $this->usuario->recuperarSenha($inputs);

        if ($recuperarsenha->erro) {
            return response()->json(["error" => TRUE, "msg" => $recuperarsenha->msg]);
        }

        return response()->json(["error" => FALSE]);
    }
}

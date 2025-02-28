<?php
require_once __DIR__ . '/../services/auth.php';
require_once __DIR__ . '/../models/user.php';

class Auth_controller extends Base_controller {
    static protected array $map = ['api', 'v1', 'usuario'];
    /**
     * @request
     * map /:id_usuario
     * method get
     */
    static public function show(Http_response $response) {
        $usuario = User::findBy('id', RouteParams::get('id_usuario'));

        if (!isset($usuario)) $response->status(404);

        $usuario->loadCargo();

        $response->send([
            'username'=>$usuario->username,
            'nome'=>$usuario->nome,
            'idade'=>$usuario->getIdade(),
            'cargo'=>isset($usuario->cargo) ? $usuario->cargo->nome : null
        ]);
    }

    /**
     * @request
     * map /
     * methodo post
     */
    static public function update(Usuario_update_request $request, Http_response $response) {
        $usuario = Auth::getUser();

        if (isset($request->nome)) $usuario->nome = $request->nome;
        if (isset($request->password)) $usuario->setPassword($request->password);
        if (isset($request->data_nascimento)) $usuario->data_nascimento = $request->data_nascimento;
        if (isset($request->id_cargo)) $usuario->id_cargo = $request->id_cargo;
    }
}
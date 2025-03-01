<?php
require_once __DIR__ . '/../services/auth.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/agenda.php';

class Usuario_controller extends Base_controller {
    static protected array $map = ['api', 'v1', 'usuario', ':id_usuario'];
    /**
     * @request
     * map /
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
    static public function update_or_create(Usuario_update_request $request, Http_response $response) {
        $usuario = null;
        $id_usuario = (int) RouteParams::get('id_usuario');

        if ($id_usuario === 0) {
            $usuario = new User();
            if (!isset($request->username)) return $response->status(400)->sendAlert('É necessário informar o username');
            if (!isset($request->password)) return $response->status(400)->sendAlert('É necessário informar a senha para criar um usuário');
            $usuario->username = $request->username;
        } else {
            $usuario = User::findBy('id', $id_usuario);
            if (!isset($usuario)) return $response->status(404);
        }

        if (isset($request->nome)) $usuario->nome = $request->nome;
        if (isset($request->password)) $usuario->setPassword($request->password);
        if (isset($request->data_nascimento)) $usuario->data_nascimento = $request->data_nascimento;
        if (isset($request->id_cargo)) $usuario->id_cargo = $request->id_cargo;

        $usuario->save();
    }

    /**
     * @request
     * map /agenda/:id_agenda
     * method post
     */
    static public function agenda_update_or_create(Agenda_update_request $request, Http_response $response) {
        $id_usuario = (int) RouteParams::get('id_usuario');
        $id_agenda = (int) RouteParams::get('id_agenda');

        $agenda = null;
        
        if ($id_agenda === 0) {
            $agenda = new Agenda();
            $agenda->id_usuario = $id_usuario;
        } else {
            $agenda = Agenda::findBy('id', $id_agenda);
            if (!isset($agenda)) return $response->status(404);
            if ($agenda->id_usuario !== $id_usuario) return $response->status(400)->sendAlert('Esse agendamento é de outro usuário');
        }
        
        $agenda->data = $request->data;
        $agenda->duracao_minutos = $request->duracao_minutos;
        $agenda->descricao = $request->descricao;
        $agenda->cancelado = $request->cancelado;

        $agenda->save();
    }
}
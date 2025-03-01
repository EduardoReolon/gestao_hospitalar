<?php
require_once __DIR__ . '/../services/auth.php';
require_once __DIR__ . '/../models/paciente.php';

class Paciente_controller extends Base_controller {
    static protected array $map = ['api', 'v1', 'paciente', ':id_paciente'];

    /**
     * @request
     * map /
     * methodo post
     */
    static public function update_or_create(Paciente_update_request $request, Http_response $response) {
        $paciente = null;
        $id_paciente = (int) RouteParams::get('id_paciente');

        if ($id_paciente === 0) {
            $paciente = new Paciente();
        } else {
            $paciente = Paciente::findBy('id', $id_paciente);
            if (!isset($paciente)) return $response->status(404);
        }

        $paciente->nome = $request->nome;
        $paciente->data_nascimento = $request->data_nascimento;
        $paciente->rua = $request->rua;
        
        if (isset($request->numero)) $paciente->numero = $request->numero;
        if (isset($request->complemento)) $paciente->complemento = $request->complemento;
        
        $paciente->cep = $request->cep;
        $paciente->cidade = $request->cidade;
        $paciente->estado = $request->estado;

        $paciente->save();
    }

    /**
     * @request
     * map /consulta/:id_consulta
     * method post
     */
    static public function consulta(Consulta_update_request $request, Http_response $response) {
        $id_paciente = (int) RouteParams::get('id_paciente');
        $paciente = Paciente::findBy('id', $id_paciente);
        if (!isset($paciente)) return $response->status(404)->sendAlert('Paciente não encontrado');
        
        $id_consulta = (int) RouteParams::get('id_consulta');

        $especialidade = Especialidade::findLocal($request->id_especialidade);
        if (!isset($especialidade)) return $response->status(404);

        $consulta = null;

        if ($id_consulta === 0) {
            $consulta = new Consulta();
            $consulta->id_usuario_cadastro = Auth::getUserId();
            $consulta->id_paciente = $id_paciente;
        } else {
            $consulta = Consulta::findBy('id', $id_consulta);
            if (!isset($consulta)) return $response->status(404)->sendAlert('Consulta não encontrada');
        }

        $consulta->id_usuario_atendimento = $request->id_usuario_atendimento;
        $consulta->id_especialidade = $request->id_especialidade;
        $consulta->teleconsulta = $request->teleconsulta;
        $consulta->data = $request->data;
        $consulta->duracao_minutos = $request->duracao_minutos;
        $consulta->notas_cadastro = $request->notas_cadastro;
        $consulta->notas_atendimento = $request->notas_atendimento;

        $consulta->save();
    }

    /**
     * @request
     * map /exame/:id_paciente_exame
     * method post
     */
    static public function exame(Paciente_exame_update_request $request, Http_response $response) {
        $id_paciente = (int) RouteParams::get('id_paciente');
        $paciente = Paciente::findBy('id', $id_paciente);
        if (!isset($paciente)) return $response->status(404)->sendAlert('Paciente não encontrado');
        
        $id_paciente_exame = (int) RouteParams::get('id_paciente_exame');

        $exame = Exame::findLocal($request->id_exame);
        if (!isset($exame)) return $response->status(404);

        $paciente_exame = null;

        if ($id_paciente_exame === 0) {
            $paciente_exame = new Paciente_exame();
            $paciente_exame->id_paciente = $id_paciente;
        } else {
            $paciente_exame = Paciente_exame::findBy('id', $id_paciente_exame);
            if (!isset($paciente_exame)) return $response->status(404);
        }

        $paciente_exame->id_usuario = $request->id_usuario;
        $paciente_exame->id_exame = $request->id_exame;
        $paciente_exame->data = $request->data;
        $paciente_exame->notas = $request->notas;

        $paciente_exame->save();
    }

    /**
     * @request
     * map /prescricao/:id_prescricao
     * method post
     */
    static public function prescricao(Prescricao_update_request $request, Http_response $response) {
        $id_paciente = (int) RouteParams::get('id_paciente');
        $paciente = Paciente::findBy('id', $id_paciente);
        if (!isset($paciente)) return $response->status(404)->sendAlert('Paciente não encontrado');
        
        $id_prescricao = (int) RouteParams::get('id_prescricao');

        $prescricao = null;

        if ($id_prescricao === 0) {
            $prescricao = new Prescricao();
            $prescricao->id_paciente = $id_paciente;
            $prescricao->id_usuario = Auth::getUserId();
        } else {
            $prescricao = Prescricao::findBy('id', $id_prescricao);
            if (!isset($prescricao)) return $response->status(404);
        }

        $prescricao->data = $request->data;
        $prescricao->notas = $request->notas;

        $prescricao->save();
    }

    /**
     * @request
     * map /prontuario/:id_prontuario
     * method post
     */
    static public function prontuario(Prescricao_update_request $request, Http_response $response) {
        $id_paciente = (int) RouteParams::get('id_paciente');
        $paciente = Paciente::findBy('id', $id_paciente);
        if (!isset($paciente)) return $response->status(404)->sendAlert('Paciente não encontrado');
        
        $id_prontuario = (int) RouteParams::get('id_prontuario');

        $prontuario = null;

        if ($id_prontuario === 0) {
            $prontuario = new Prontuario();
            $prontuario->id_paciente = $id_paciente;
            $prontuario->id_usuario = Auth::getUserId();
        } else {
            $prontuario = Prontuario::findBy('id', $id_prontuario);
            if (!isset($prontuario)) return $response->status(404);
        }

        $prontuario->data = $request->data;
        $prontuario->notas = $request->notas;

        $prontuario->save();
    }
}
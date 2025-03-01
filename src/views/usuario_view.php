<?php

require_once 'config/view_main.php';
require_once __DIR__ . '/../services/helper.php';
require_once __DIR__ . '/../models/agenda.php';
require_once __DIR__ . '/../models/cargo.php';
require_once __DIR__ . '/../models/consulta.php';
require_once __DIR__ . '/../models/especialidade.php';
require_once __DIR__ . '/../models/exame.php';
require_once __DIR__ . '/../models/paciente_exame.php';
require_once __DIR__ . '/../models/paciente.php';
require_once __DIR__ . '/../models/prescricao.php';
require_once __DIR__ . '/../models/prontuario.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/usuario_especialidade.php';

class Usuario_view extends View_main {
    private User $usuario;
    /** @var Cargo[] */
    private array $cargos;

    public function __construct() {
        $uri = Helper::getCurrentUri();
        preg_match('/^(\/usuario\/)(\d+)$/', $uri, $matches);
        $id_usuario = (int) $matches[2];
        $this->usuario = User::findBy('id', $id_usuario);
        $this->usuario->loadAgenda();

        $this->cargos = Cargo::fetchSimpler();

        parent::__construct();
    }

    private function formAgenda(Agenda $agenda, bool $duracao_nula = false) {
        $id_agenda = $agenda->id ?? 0;
        $duracao_minutos = $duracao_nula ? '' : (isset($agenda->id) ? null : 30);
        ?>
            <form <?php echo isset($agenda->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("usuario/{$this->usuario->id}/agenda/{$id_agenda}") ?>">
                <tr>
                    <td>
                        <input name="data" class="form-control" type='datetime-local' value="<?php echo isset($agenda->data) ? $agenda->data->format('Y-m-d H:i') : ''; ?>"/>
                    </td>
                    <td>
                        <input name="duracao_minutos" class="form-control" type='number' value="<?php echo $duracao_minutos ?? $agenda->duracao_minutos ?>"/>
                    </td>
                    <td>
                        <input name="descricao" placeholder="<?php echo isset($agenda->id) ? '' : 'Novo agendamento' ?>" class="form-control" type='text' value="<?php echo $agenda->descricao ?? ''; ?>"/>
                    </td>
                    <td>
                        <div class="form-check form-switch d-inline-block">
                            <input class="form-check-input" type="checkbox" role="switch" name="cancelado" <?php echo ($agenda->cancelado ?? false) ? 'checked' : '' ?>>
                        </div>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    protected function body_content() {
        ?><h1>Usuario: <?php echo $this->usuario->nome . ' (' . $this->usuario->username . ')' ?></h1><?php

        echo '<h2>Agenda</h2>';
        echo '<table><thead><tr><th>data</th><th>duração (minutos)</th><th>descrição</th><th>cancelado</th><th>ações</th></tr></thead><tbody>';
        foreach ($this->usuario->agendas as $agenda) {
            $this->formAgenda($agenda);
        }
        $this->formAgenda(new Agenda());
        echo '</tbody></table>';

        ?><h1>Testes</h1><?php

        echo '<h2>Agenda</h2>';
        echo '<table><thead><tr><th>data</th><th>duração (minutos)</th><th>descrição</th><th>cancelado</th><th>ações</th></tr></thead><tbody>';
        // $this->formAgenda(new Agenda());
        $this->formAgenda(new Agenda(), duracao_nula: true);
        echo '</tbody></table>';
    }
}
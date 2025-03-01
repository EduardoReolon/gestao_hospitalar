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

class Paciente_view extends View_main {
    private Paciente $paciente;
    private User $usuario;
    /** @var User[] */
    private array $usuarios;
    /** @var Especialidade[] */
    private array $especialidades;
    /** @var Exame[] */
    private array $exames;

    public function __construct() {
        $uri = Helper::getCurrentUri();
        preg_match('/^(\/paciente\/)(\d+)$/', $uri, $matches);
        $id_paciente = (int) $matches[2];
        $this->paciente = Paciente::findBy('id', $id_paciente);
        $this->paciente->loadConsultas();
        $this->paciente->loadPacienteExames();
        $this->paciente->loadPrecricoes();
        $this->paciente->loadProntuarios();

        $this->usuario = Auth::getUser();
        $this->usuarios = User::fetchSimpler();
        $this->exames = Exame::fetchSimpler();
        $this->especialidades = Especialidade::fetchSimpler();

        $usuario_nao_cadastrado = new User();
        $usuario_nao_cadastrado->id = 1001;
        $usuario_nao_cadastrado->nome = 'Não cadastrado (teste)';
        $this->usuarios[] = $usuario_nao_cadastrado;

        $exame_nao_cadastrado = new Exame();
        $exame_nao_cadastrado->id = 1001;
        $exame_nao_cadastrado->nome = 'Não cadastrado (teste)';
        $this->exames[] = $exame_nao_cadastrado;

        $especialidade_nao_cadastrada = new Especialidade();
        $especialidade_nao_cadastrada->id = 1001;
        $especialidade_nao_cadastrada->nome = 'Não cadastrada (teste)';
        $this->especialidades[] = $especialidade_nao_cadastrada;

        parent::__construct();
    }

    private function formConsulta(Consulta $consulta, bool $duracao_nula = false) {
        $id_consulta = $consulta->id ?? 0;
        $duracao_minutos = $duracao_nula ? '' : (isset($consulta->id) ? null : 30);
        $usuario_cadastro = null;
        if (isset($consulta->id)) {
            foreach ($this->usuarios as $usuario) {
                if ($usuario->id !== $consulta->id_usuario_cadastro) continue;
                $usuario_cadastro = $usuario;
                break;
            }
        } else $usuario_cadastro = $this->usuario;
        ?>
            <form <?php echo isset($consulta->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("paciente/{$this->paciente->id}/consulta/{$id_consulta}") ?>">
                <tr>
                    <td><?php echo $usuario_cadastro->nome ?></td>
                    <td>
                        <select name="id_usuario_atendimento" class="form-select" aria-label="Default select example">
                            <option value="null" <?php echo isset($consulta->id_usuario_atendimento) ? '' : 'selected' ?>></option>
                            <?php
                                foreach ($this->usuarios as $usuario) {
                                    ?>
                                        <option value="<?php echo $usuario->id ?>" <?php echo ($consulta->id_usuario_atendimento ?? 0) === $usuario->id ? 'selected' : ''; ?>><?php echo $usuario->nome ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="id_especialidade" class="form-select" aria-label="Default select example">
                            <option value="null" <?php echo isset($consulta->id_especialidade) ? '' : 'selected' ?>></option>
                            <?php
                                foreach ($this->especialidades as $especialidade) {
                                    ?>
                                        <option value="<?php echo $especialidade->id ?>" <?php echo ($consulta->id_especialidade ?? 0) === $especialidade->id ? 'selected' : ''; ?>><?php echo $especialidade->nome ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <div class="form-check form-switch d-inline-block">
                            <input class="form-check-input" type="checkbox" role="switch" name="teleconsulta" <?php echo ($consulta->teleconsulta ?? false) ? 'checked' : '' ?>>
                        </div>
                    </td>
                    <td>
                        <input name="data" class="form-control" type='datetime-local' value="<?php echo isset($consulta->data) ? $consulta->data->format('Y-m-d H:i') : ''; ?>"/>
                    </td>
                    <td>
                        <input name="duracao_minutos" class="form-control" type='number' value="<?php echo $duracao_minutos ?? $consulta->duracao_minutos ?>"/>
                    </td>
                    <td>
                        <input placeholder="<?php echo isset($consulta->id) ? '' : 'Nova consulta' ?>" name="notas_cadastro" class="form-control" type='text' value="<?php echo $consulta->notas_cadastro ?? '' ?>"/>
                    </td>
                    <td>
                        <input name="notas_atendimento" class="form-control" type='text' value="<?php echo $consulta->notas_atendimento ?? '' ?>"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    private function formExame(Paciente_exame $paciente_exame) {
        // $paciente_exame->loadExame();
        $id_paciente_exame = $paciente_exame->id ?? 0;
        ?>
            <form <?php echo isset($paciente_exame->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("paciente/{$this->paciente->id}/exame/{$id_paciente_exame}") ?>">
                <tr>
                    <td>
                        <select name="id_usuario" class="form-select" aria-label="Default select example">
                            <option value="null" <?php echo isset($paciente_exame->id_usuario) ? '' : 'selected' ?>></option>
                            <?php
                                foreach ($this->usuarios as $usuario) {
                                    ?>
                                        <option value="<?php echo $usuario->id ?>" <?php echo ($paciente_exame->id_usuario ?? 0) === $usuario->id ? 'selected' : ''; ?>><?php echo $usuario->nome ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="id_exame" class="form-select" aria-label="Default select example">
                            <option value="null" <?php echo isset($paciente_exame->id_exame) ? '' : 'selected' ?>></option>
                            <?php
                                foreach ($this->exames as $exame) {
                                    ?>
                                        <option value="<?php echo $exame->id ?>" <?php echo ($paciente_exame->id_exame ?? 0) === $exame->id ? 'selected' : ''; ?>><?php echo $exame->nome ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input name="data" class="form-control" type='datetime-local' value="<?php echo isset($paciente_exame->data) ? $paciente_exame->data->format('Y-m-d H:i') : ''; ?>"/>
                    </td>
                    <td>
                        <input placeholder="<?php echo isset($paciente_exame->id) ? '' : 'Novo exame' ?>" name="notas" class="form-control" type='text' value="<?php echo $paciente_exame->notas ?? '' ?>"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    private function formPrescricao(Prescricao $prescricao) {
        $id_prescricao = $prescricao->id ?? 0;
        $usuario = null;
        if (isset($prescricao->id)) {
            foreach ($this->usuarios as $u) {
                if ($u->id !== $prescricao->id_usuario) continue;
                $usuario = $u;
                break;
            }
        } else $usuario = $this->usuario;
        ?>
            <form <?php echo isset($prescricao->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("paciente/{$this->paciente->id}/prescricao/{$id_prescricao}") ?>">
                <tr>
                    <td><?php echo $usuario->nome ?></td>
                    <td>
                        <input name="data" class="form-control" type='datetime-local' value="<?php echo isset($prescricao->data) ? $prescricao->data->format('Y-m-d H:i') : ''; ?>"/>
                    </td>
                    <td>
                        <input placeholder="<?php echo isset($prescricao->id) ? '' : 'Nova prescricao' ?>" name="notas" class="form-control" type='text' value="<?php echo $prescricao->notas ?? '' ?>"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    private function formProntuario(Prontuario $prontuario) {
        $id_prontuario = $prontuario->id ?? 0;
        $usuario = null;
        if (isset($prontuario->id)) {
            foreach ($this->usuarios as $u) {
                if ($u->id !== $prontuario->id_usuario) continue;
                $usuario = $u;
                break;
            }
        } else $usuario = $this->usuario;
        ?>
            <form <?php echo isset($prontuario->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("paciente/{$this->paciente->id}/prontuario/{$id_prontuario}") ?>">
                <tr>
                    <td><?php echo $usuario->nome ?></td>
                    <td>
                        <input name="data" class="form-control" type='datetime-local' value="<?php echo isset($prontuario->data) ? $prontuario->data->format('Y-m-d H:i') : ''; ?>"/>
                    </td>
                    <td>
                        <input placeholder="<?php echo isset($prontuario->id) ? '' : 'Nova prontuário' ?>" name="notas" class="form-control" type='text' value="<?php echo $prontuario->notas ?? '' ?>"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    protected function body_content() {
        ?><h1>Paciente: <?php echo $this->paciente->nome ?></h1><?php

        echo '<h2>Consultas</h2>';
        echo '<table><thead></th><th>cadastro</th><th>atendimento</th><th>especialidade</th><th>teleconsulta</th><th>data</th><th>duração (minutos)</th><th>notas cadastro</th><th>notas atendimento</th><th>ações</th></tr></thead><tbody>';
        foreach ($this->paciente->consultas as $consulta) {
            $this->formConsulta($consulta);
        }
        $this->formConsulta(new Consulta());
        echo '</tbody></table>';

        echo '<h2>Exames</h2>';
        echo '<table><thead></th><th>atendimento</th><th>exame</th><th>data</th><th>notas</th><th>ações</th></tr></thead><tbody>';
        foreach ($this->paciente->paciente_exames as $paciente_exame) {
            $this->formExame($paciente_exame);
        }
        $this->formExame(new Paciente_exame());
        echo '</tbody></table>';

        echo '<h2>Prescrições</h2>';
        echo '<table><thead></th><th>atendimento</th><th>data</th><th>notas</th><th>ações</th></tr></thead><tbody>';
        foreach ($this->paciente->prescricoes as $prescricao) {
            $this->formPrescricao($prescricao);
        }
        $this->formPrescricao(new Prescricao());
        echo '</tbody></table>';

        echo '<h2>Prontuários</h2>';
        echo '<table><thead></th><th>atendimento</th><th>data</th><th>notas</th><th>ações</th></tr></thead><tbody>';
        foreach ($this->paciente->prontuarios as $prontuario) {
            $this->formProntuario($prontuario);
        }
        $this->formProntuario(new Prontuario());
        echo '</tbody></table>';

        ?><h1>Testes</h1><?php
        echo '<h2>Consultas</h2>';
        echo '<table><thead></th><th>cadastro</th><th>atendimento</th><th>especialidade</th><th>teleconsulta</th><th>data</th><th>duração (minutos)</th><th>notas cadastro</th><th>notas atendimento</th><th>ações</th></tr></thead><tbody>';
        $consulta = new Consulta();
        $consulta->id_usuario_atendimento = 1001;
        $this->formConsulta($consulta);
        $consulta = new Consulta();
        $consulta->id_especialidade = 1001;
        $this->formConsulta($consulta);
        $consulta = new Consulta();
        $consulta->id_usuario_atendimento = $this->usuarios[0]->id;
        $consulta->id_especialidade = $this->especialidades[0]->id;
        $this->formConsulta($consulta);
        $consulta = new Consulta();
        $consulta->id_usuario_atendimento = $this->usuarios[0]->id;
        $consulta->id_especialidade = $this->especialidades[0]->id;
        $consulta->data = new DateTime();
        $this->formConsulta($consulta, duracao_nula: true);
        echo '</tbody></table>';

        echo '<h2>Exames</h2>';
        echo '<table><thead></th><th>atendimento</th><th>exame</th><th>data</th><th>notas</th><th>ações</th></tr></thead><tbody>';
        $paciente_exame = new Paciente_exame();
        $paciente_exame->id_usuario = 1001;
        $this->formExame($paciente_exame);
        $paciente_exame = new Paciente_exame();
        $paciente_exame->id_exame = 1001;
        $this->formExame($paciente_exame);
        $paciente_exame = new Paciente_exame();
        $paciente_exame->id_usuario = $this->usuarios[0]->id;
        $paciente_exame->id_exame = $this->exames[0]->id;
        $this->formExame($paciente_exame);
        echo '</tbody></table>';

        echo '<h2>Prescrições</h2>';
        echo '<table><thead></th><th>atendimento</th><th>data</th><th>notas</th><th>ações</th></tr></thead><tbody>';
        $this->formPrescricao(new Prescricao());
        echo '</tbody></table>';

        echo '<h2>Prontuários</h2>';
        echo '<table><thead></th><th>atendimento</th><th>data</th><th>notas</th><th>ações</th></tr></thead><tbody>';
        $this->formProntuario(new Prontuario());
        echo '</tbody></table>';
    }
}
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

class Home_view extends View_main {
    /** @var Paciente[] */
    private array $pacientes;
    /** @var User[] */
    private array $usuarios;
    /** @var Cargo[] */
    private array $cargos;

    public function __construct() {
        $this->pacientes = Paciente::fetchSimpler();
        $this->usuarios = User::fetchSimpler();
        $this->cargos = Cargo::fetchSimpler();

        parent::__construct();
    }

    private function formUser(User $usuario) {
        $usuario->loadCargo();
        $cargo = '';
        $id_usuario = $usuario->id ?? 0;
        if (isset($usuario->cargo)) $cargo = ', cargo: ' . $usuario->cargo->nome;
        ?>
            <form <?php echo isset($usuario->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("usuario/{$id_usuario}") ?>">
                <tr>
                    <td>
                        <a <?php echo isset($usuario->id) ? '' : 'hidden' ?> href="<?php echo 'usuario/' . $id_usuario ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <input name="username" placeholder="<?php echo isset($usuario->id) ? '' : 'Novo usuário' ?>" class="form-control" type='text' value="<?php echo $usuario->username ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="password" class="form-control" type='password'/>
                    </td>
                    <td>
                        <input name="nome" class="form-control" type='text' value="<?php echo $usuario->nome ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="cpf" class="form-control" type='text' value="<?php echo $usuario->cpf ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="data_nascimento" class="form-control" type='date' value="<?php echo isset($usuario->data_nascimento) ? $usuario->data_nascimento->format('Y-m-d') : ''; ?>"/>
                    </td>
                    <td>
                        <select name="id_cargo" class="form-select" aria-label="Default select example">
                            <option value="null" <?php echo isset($usuario->id_cargo) ? '' : 'selected' ?>></option>
                            <?php
                                foreach ($this->cargos as $cargo) {
                                    ?>
                                        <option value="<?php echo $cargo->id ?>" <?php echo ($usuario->id_cargo ?? 0) === $cargo->id ? 'selected' : ''; ?>><?php echo $cargo->nome ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    private function formPaciente(Paciente $paciente) {
        $id_paciente = $paciente->id ?? 0;
        ?>
            <form <?php echo isset($paciente->id) ? '' : 'refresh-page' ?> method="POST" action="<?php echo Helper::apiPath("paciente/{$id_paciente}") ?>">
                <tr>
                    <td>
                        <a <?php echo isset($paciente->id) ? '' : 'hidden' ?> href="<?php echo 'paciente/' . $id_paciente ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <input placeholder="<?php echo isset($paciente->id) ? '' : 'Novo paciente' ?>" name="nome" class="form-control" type='text' value="<?php echo $paciente->nome ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="cpf" class="form-control" type='text' value="<?php echo $paciente->cpf ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="data_nascimento" class="form-control" type='date' value="<?php echo isset($paciente->data_nascimento) ? $paciente->data_nascimento->format('Y-m-d') : ''; ?>"/>
                    </td>
                    <td>
                        <input name="rua" class="form-control" type='text' value="<?php echo $paciente->rua ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="numero" class="form-control" type='text' value="<?php echo $paciente->numero ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="complemento" class="form-control" type='text' value="<?php echo $paciente->complemento ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="cep" class="form-control" type='text' value="<?php echo $paciente->cep ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="cidade" class="form-control" type='text' value="<?php echo $paciente->cidade ?? ''; ?>"/>
                    </td>
                    <td>
                        <input name="estado" class="form-control" type='text' value="<?php echo $paciente->estado ?? ''; ?>"/>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="salvar">
                    </td>
                </tr>
            </form>
        <?php
    }

    protected function body_content() {
        ?><h1>Sistema hospitalar</h1><?php

        echo '<h2>Usuários</h2>';
        echo '<table><thead><tr><th></th><th>username</th><th>senha</sh><th>nome</th><th>CPF</th><th>data de nascimento</th><th>cargo</th><th>ações</th></tr></thead><tbody>';
        foreach ($this->usuarios as $usuario) {
            $this->formUser($usuario);
        }
        $this->formUser(new User());
        echo '</tbody></table>';

        echo '<h2>Pacientes</h2>';
        echo '<table><thead><tr><th></th><th>Nome</th><th>CPF</th><th>Data de Nascimento</th><th>Rua</th><th>Número</th><th>Complemento</th><th>CEP</th><th>Cidade</th><th>Estado</th><th>Ações</th></tr></thead><tbody>';
        foreach ($this->pacientes as $paciente) {
            $this->formPaciente($paciente);
        }
        $this->formPaciente(new Paciente());
        echo '</tbody></table>';

        ?><h1>Testes</h1><?php

        echo '<h2>Usuários</h2>';
        echo '<table><thead><tr><th></th><th>username</th><th>senha</sh><th>nome</th><th>CPF</th><th>data de nascimento</th><th>cargo</th><th>ações</th></tr></thead><tbody>';
        $usuario = new User();
        $usuario->username = 'não e-mail';
        $this->formUser($usuario);
        $usuario = new User();
        $usuario->username = Helper::randomStr(3) . '@email.com';
        $this->formUser($usuario);
        $usuario = new User();
        $usuario->username = Helper::randomStr(3) . '@email.com';
        $usuario->cpf = '12';
        $this->formUser($usuario);
        $usuario = new User();
        $usuario->username = Helper::randomStr(3) . '@email.com';
        $usuario->cpf = '111.222.333-44';
        $this->formUser($usuario);
        echo '</tbody></table>';

        echo '<h2>Pacientes</h2>';
        echo '<table><thead><tr><th></th><th>Nome</th><th>CPF</th><th>Data de Nascimento</th><th>Rua</th><th>Número</th><th>Complemento</th><th>CEP</th><th>Cidade</th><th>Estado</th><th>Ações</th></tr></thead><tbody>';
        $paciente = new Paciente();
        $this->formPaciente($paciente);
        $paciente = new Paciente();
        $paciente->cpf = '1122';
        $this->formPaciente($paciente);
        $paciente = new Paciente();
        $paciente->cpf = '111.222.333-44';
        $this->formPaciente($paciente);
        echo '</tbody></table>';
    }
}
<?php
require_once('config/entity.php');
require_once __DIR__ . '/cargo.php';
require_once __DIR__ . '/agenda.php';
require_once __DIR__ . '/consulta.php';
require_once __DIR__ . '/usuario_especialidade.php';
require_once __DIR__ . '/especialidade.php';

class User extends Entity {
    protected static $table = 'user';
    public Cargo $cargo;
    /** @var Agenda[] */
    public array $agendas;
    /** @var Especialidade[] */
    public array $especialidades;
    public bool $hidden = false;

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public string $username;
    /**
     * @column
     * log_only_prop_name
     */
    protected string $password;
    /** @column */
    public ?string $nome;
    /** @column */
    public ?string $cpf;
    /** @column */
    public ?DateTime $data_nascimento;
    /** @column */
    public ?int $id_cargo;
    /** @column */
    public bool $active = true;
    /**
     * @var string[] | null
     * @column
     * json
     */
    public $roles;

    public function getIdade(): int|false {
        if (!isset($this->data_nascimento)) return false;

        $dataAtual = new DateTime();

        $diff = $this->data_nascimento->diff($dataAtual, true);
        return $diff->y;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    protected function beforeSave() {
        if (!empty($this->password) && strlen($this->password) < 50) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
    }

    public function passwordCheck($password) {
        if (empty($password)) return false;
        return password_verify($password, $this->password);
    }

    public function loadCargo() {
        if (isset($this->cargo)) return;
        if (!isset($this->id_cargo)) return;
        $this->cargo = Cargo::findLocal($this->id_cargo);
    }

    public function loadAgenda() {
        if (isset($this->agendas)) return;

        $this->agendas = Agenda::fetchSimpler([['id_usuario', '=', $this->id]]);
    }

    public function getAgenda(DateTime $start, DateTime $end) {
        return Agenda::fetchSimpler([['id_usuario', '=', $this->id], ['data', '>', $start], ['data', '<', $end]]);
    }

    public function getConsultas(DateTime $start, DateTime $end) {
        return Consulta::fetchSimpler([['id', '=', $this->id], ['data', '>', $start], ['data', '<', $end]]);
    }

    public function loadEspecialidades() {
        if (isset($this->especialidades)) return;
        
        $usuario_especialidades = Usuario_especialidade::fetchSimpler([['id_usuario', '=', $this->id]]);
        $ids = [];
        foreach ($usuario_especialidades as $usuario_especialidade) {
            $ids[] = $usuario_especialidade->id;
        }

        $this->especialidades = Especialidade::fetchSimpler([['id', 'in', $ids]]);
    }
}
<?php
require_once('config/entity.php');
require_once __DIR__ . '/cargo.php';
require_once __DIR__ . '/especialidade.php';

class User extends Entity {
    protected static $table = 'user';
    public Cargo $cargo;
    public Especialidade $especialidade;

    /**
     * @column
     * primary
     * @var int
     */
    public $id;
    /**
     * @column
     * @var string
     */
    public $username;
    /**
     * @column
     * @var string
     * log_only_prop_name
     */
    protected $password;
    /**
     * @column
     * @var string
     */
    public $name;
    /** @column */
    public ?int $id_cargo;
    /** @column */
    public ?int $id_especialidade;
    /**
     * @column
     * @var string
     */
    public $surname;
    /**
     * @column
     * @var bool
     */
    public $active;
    /**
     * @var string[] | null
     * @column
     * json
     */
    public $roles;

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

    public function loadEspecialidade() {
        if (isset($this->especialidade)) return;
        if (!isset($this->id_especialidade)) return;
        $this->especialidade = Especialidade::findLocal($this->id_especialidade);
    }
}
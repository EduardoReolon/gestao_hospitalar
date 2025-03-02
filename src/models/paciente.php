<?php
require_once('config/entity.php');
require_once __DIR__ . '/exame.php';
require_once __DIR__ . '/paciente_exame.php';
require_once __DIR__ . '/prescricao.php';
require_once __DIR__ . '/prontuario.php';
require_once __DIR__ . '/consulta.php';

class Paciente extends Entity {
    protected static $table = 'paciente';
    /** @var Paciente_exame[] */
    public array $paciente_exames;
    /** @var Prescricao[] */
    public array $prescricoes;
    /** @var Prontuario[] */
    public array $prontuarios;
    /** @var Consulta[] */
    public array $consultas;

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public string $nome;
    /** @column */
    public string $cpf;
    /** @column */
    public DateTime $data_nascimento;
    /** @column */
    public string $rua;
    /** @column */
    public ?string $numero;
    /** @column */
    public ?string $complemento;
    /** @column */
    public string $cep;
    /** @column */
    public string $cidade;
    /** @column */
    public string $estado;

    public function getIdade(): int|false {
        if (!isset($this->data_nascimento)) return false;

        $dataAtual = new DateTime();

        $diff = $this->data_nascimento->diff($dataAtual, true);
        return $diff->y;
    }

    public function loadPacienteExames() {
        if (isset($this->paciente_exames)) return;

        $this->paciente_exames = Paciente_exame::fetchSimpler([['id_paciente', '=', $this->id]]);

        foreach ($this->paciente_exames as $paciente_exame) {
            $paciente_exame->loadExame();
        }
    }

    public function loadPrecricoes() {
        if (isset($this->prescricoes)) return;
        $this->prescricoes = Prescricao::fetchSimpler([['id_paciente', '=', $this->id]]);
    }

    public function loadProntuarios() {
        if (isset($this->prontuarios)) return;
        $this->prontuarios = Prontuario::fetchSimpler([['id_paciente', '=', $this->id]]);
    }

    public function loadConsultas() {
        if (isset($this->consultas)) return;
        $this->consultas = Consulta::fetchSimpler([['id_paciente', '=', $this->id]]);
    }
}
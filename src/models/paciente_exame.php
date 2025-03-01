<?php
require_once('config/entity.php');
require_once __DIR__ . '/exame.php';

class Paciente_exame extends Entity {
    protected static $table = 'paciente_exame';
    public Exame $exame;

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public int $id_paciente;
    /** @column */
    public ?int $id_usuario;
    /** @column */
    public int $id_exame;
    /** @column */
    public DateTime $data;
    /** @column */
    public ?string $notas;

    public function loadExame() {
        if (isset($this->exame)) return;
        if (!isset($this->id_exame)) return;
        $this->exame = Exame::findLocal($this->id_exame);
    }
}
<?php
require_once('config/entity.php');

class Paciente_exame extends Entity {
    protected static $table = 'paciente_exame';

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public int $id_paciente;
    /** @column */
    public int $id_usuario;
    /** @column */
    public int $id_exame;
    /** @column */
    public DateTime $data;
    /** @column */
    public ?string $notas;
}
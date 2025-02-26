<?php
require_once('config/entity.php');

class Prontuario extends Entity {
    protected static $table = 'prontuario';

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
    public DateTime $data;
    /** @column */
    public string $notas;
}
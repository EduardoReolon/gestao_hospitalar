<?php
require_once('config/entity.php');

class Prescricao extends Entity {
    protected static $table = 'prescricao';

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public int $id_usuario;
    /** @column */
    public int $id_paciente;
    /** @column */
    public DateTime $data;
    /** @column */
    public string $notas;
}
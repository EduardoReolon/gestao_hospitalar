<?php
require_once('config/entity.php');

class Usuario_especialidade extends Entity {
    protected static $table = 'usuario_especialidade';

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public int $id_usuario;
    /** @column */
    public int $id_especialidade;
}
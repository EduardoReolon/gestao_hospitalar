<?php
require_once('config/entity.php');

class Agenda extends Entity {
    protected static $table = 'agenda';

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public int $id_usuario;
    /** @column */
    public bool $cancelado;
    /** @column */
    public DateTime $data;
    /** @column */
    public int $duracao_minutos;
    /** @column */
    public string $descricao;
}
<?php
require_once('config/entity.php');

class Paciente extends Entity {
    protected static $table = 'paciente';

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public string $nome;
    /** @column */
    public DateTime $data_nascimento;
    /** @column */
    public string $rua;
    /** @column */
    public string $numero;
    /** @column */
    public string $cep;
    /** @column */
    public string $cidade;
    /** @column */
    public string $estado;
}
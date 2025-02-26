<?php
require_once('config/entity.php');

class Consulta extends Entity {
    protected static $table = 'consulta';

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public int $id_usuario_cadastro;
    /** @column */
    public ?int $id_usuario_atendimento;
    /** @column */
    public int $id_especialidade;
    /** @column */
    public bool $teleconsulta = false;
    /** @column */
    public int $id_paciente;
    /** @column */
    public DateTime $data;
    /** @column */
    public int $duracao_minutos;
    /** @column */
    public ?string $notas_cadastro;
    /** @column */
    public ?string $notas_atendimento;
}
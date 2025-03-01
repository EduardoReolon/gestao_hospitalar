<?php
require_once __DIR__ . '/../config/base_request.php';

class Consulta_update_request extends Base_request {
    public ?int $id_usuario_atendimento;
    public int $id_especialidade;
    public bool $teleconsulta = false;
    public DateTime $data;
    public int $duracao_minutos;
    public ?string $notas_cadastro;
    public ?string $notas_atendimento;
}
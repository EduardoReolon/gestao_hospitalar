<?php
require_once __DIR__ . '/../config/base_request.php';

class Agenda_update_request extends Base_request {
    public DateTime $data;
    public int $duracao_minutos;
    public string $descricao;
    public bool $cancelado = false;
}
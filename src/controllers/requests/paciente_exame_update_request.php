<?php
require_once __DIR__ . '/../config/base_request.php';

class Paciente_exame_update_request extends Base_request {
    public ?int $id_usuario;
    public int $id_exame;
    public DateTime $data;
    public ?string $notas;
}
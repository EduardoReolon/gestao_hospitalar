<?php
require_once __DIR__ . '/../config/base_request.php';

class Prescricao_update_request extends Base_request {
    public DateTime $data;
    public string $notas;
}
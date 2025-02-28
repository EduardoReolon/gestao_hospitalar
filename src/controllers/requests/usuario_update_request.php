<?php
require_once __DIR__ . '/../config/base_request.php';

class Usuario_update_request extends Base_request {
    public ?string $nome;
    public ?string $password;
    public ?DateTime $data_nascimento;
    public ?int $id_cargo;
}
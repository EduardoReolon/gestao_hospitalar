<?php
require_once __DIR__ . '/../config/base_request.php';

class Usuario_update_request extends Base_request {
    /**
     * pattern email
     */
    public ?string $username;
    public ?string $nome;
    /**
     * pattern cpf
     */
    public ?string $cpf;
    public ?string $password;
    public ?DateTime $data_nascimento;
    public ?int $id_cargo;
}
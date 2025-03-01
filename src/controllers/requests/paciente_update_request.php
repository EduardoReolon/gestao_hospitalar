<?php
require_once __DIR__ . '/../config/base_request.php';

class Paciente_update_request extends Base_request {
    public string $nome;
    public DateTime $data_nascimento;
    public string $rua;
    public ?string $numero;
    public ?string $complemento;
    public string $cep;
    public string $cidade;
    public string $estado;
}
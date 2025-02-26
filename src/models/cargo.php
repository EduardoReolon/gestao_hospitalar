<?php
require_once('config/entity.php');

class Cargo extends Entity {
    protected static $table = 'cargo';
    /** @var self[] */
    protected static array $cargos;

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public string $nome;

    private static function loadLocal() {
        if (isset(self::$cargos)) return;

        self::$cargos = [];
    
        $valores = [
            ['id'=>1, 'nome'=>'médico'],
            ['id'=>2, 'nome'=>'enfermeiro'],
            ['id'=>3, 'nome'=>'técnico'],
        ];
    
        foreach ($valores as $valor) {
            $cargo = new self();
            $cargo->id = $valor['id'];
            $cargo->nome = $valor['nome'];
            self::$cargos[] = $cargo;
        }
    }

    public static function findLocal(int $id): self|null {
        self::loadLocal();

        foreach (self::$cargos as $cargo) {
            if ($cargo->id === $id) return $cargo;
        }

        return null;
    }

    public static function fetchSimpler($conditions = []): array {
        self::loadLocal();
        
        return self::$cargos;
    }
}
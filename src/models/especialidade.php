<?php
require_once('config/entity.php');

class Especialidade extends Entity {
    protected static $table = 'especialidade';
    /** @var self[] */
    protected static array $especialidades;

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public string $nome;

    private static function loadLocal() {
        if (isset(self::$especialidades)) return;

        self::$especialidades = [];
    
        $valores = [
            ['id'=>1, 'nome'=>'clínico geral'],
            ['id'=>2, 'nome'=>'obstetra'],
            ['id'=>3, 'nome'=>'geriatra'],
        ];
    
        foreach ($valores as $valor) {
            $especialidade = new self();
            $especialidade->id = $valor['id'];
            $especialidade->nome = $valor['nome'];
            self::$especialidades[] = $especialidade;
        }
    }

    public static function findLocal(int $id): self|null {
        self::loadLocal();

        foreach (self::$especialidades as $especialidade) {
            if ($especialidade->id === $id) return $especialidade;
        }

        return null;
    }

    public static function fetchSimpler($conditions = []): array {
        self::loadLocal();
        
        return self::$especialidades;
    }
}
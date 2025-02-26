<?php
require_once('config/entity.php');

class Exame extends Entity {
    protected static $table = 'exame';
    /** @var self[] */
    protected static array $exames;

    /**
     * @column
     * primary
     */
    public int $id;
    /** @column */
    public string $nome;

    private static function loadLocal() {
        if (isset(self::$exames)) return;

        self::$exames = [];
    
        $valores = [
            ['id'=>1, 'nome'=>'sangue'],
            ['id'=>2, 'nome'=>'raio-X'],
            ['id'=>3, 'nome'=>'hemograma'],
        ];
    
        foreach ($valores as $valor) {
            $exame = new self();
            $exame->id = $valor['id'];
            $exame->nome = $valor['nome'];
            self::$exames[] = $exame;
        }
    }

    public static function findLocal(int $id): self|null {
        self::loadLocal();

        foreach (self::$exames as $exame) {
            if ($exame->id === $id) return $exame;
        }

        return null;
    }

    public static function fetchSimpler($conditions = []): array {
        self::loadLocal();
        
        return self::$exames;
    }
}
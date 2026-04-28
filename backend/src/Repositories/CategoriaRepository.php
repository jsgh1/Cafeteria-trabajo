<?php
namespace App\Repositories;

use PDO;

final class CategoriaRepository extends BaseRepository
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'categorias', ['nombre', 'descripcion', 'activo'], ['nombre', 'descripcion']);
    }
}

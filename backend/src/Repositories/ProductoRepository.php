<?php
namespace App\Repositories;

use PDO;

final class ProductoRepository extends BaseRepository
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'productos', ['categoria_id', 'nombre', 'descripcion', 'precio', 'stock', 'activo'], ['nombre', 'descripcion']);
    }
}

<?php
namespace App\Repositories;

use PDO;

final class PedidoRepository extends BaseRepository
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'pedidos', ['cliente_id', 'fecha', 'estado', 'total'], ['estado']);
    }
}

<?php
namespace App\Repositories;

use PDO;

final class PedidoItemRepository extends BaseRepository
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'pedido_items', ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario'], ['pedido_id', 'producto_id']);
    }
}

<?php
namespace App\Services;

use App\Repositories\PedidoItemRepository;

final class PedidoItemService extends BaseService
{
    public function __construct(PedidoItemRepository $repository)
    {
        parent::__construct($repository, ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario']);
    }
}

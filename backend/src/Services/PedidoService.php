<?php
namespace App\Services;

use App\Repositories\PedidoRepository;

final class PedidoService extends BaseService
{
    public function __construct(PedidoRepository $repository)
    {
        parent::__construct($repository, ['cliente_id']);
    }
}

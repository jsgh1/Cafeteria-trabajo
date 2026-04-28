<?php
namespace App\Controllers;

use App\Services\PedidoItemService;

final class PedidoItemController extends BaseController
{
    public function __construct(PedidoItemService $service)
    {
        parent::__construct($service);
    }
}

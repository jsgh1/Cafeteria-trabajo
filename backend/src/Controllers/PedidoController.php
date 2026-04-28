<?php
namespace App\Controllers;

use App\Services\PedidoService;

final class PedidoController extends BaseController
{
    public function __construct(PedidoService $service)
    {
        parent::__construct($service);
    }
}

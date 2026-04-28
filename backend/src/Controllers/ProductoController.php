<?php
namespace App\Controllers;

use App\Services\ProductoService;

final class ProductoController extends BaseController
{
    public function __construct(ProductoService $service)
    {
        parent::__construct($service);
    }
}

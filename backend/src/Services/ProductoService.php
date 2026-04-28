<?php
namespace App\Services;

use App\Repositories\ProductoRepository;

final class ProductoService extends BaseService
{
    public function __construct(ProductoRepository $repository)
    {
        parent::__construct($repository, ['categoria_id', 'nombre', 'precio']);
    }
}

<?php
namespace App\Controllers;

use App\Services\CategoriaService;

final class CategoriaController extends BaseController
{
    public function __construct(CategoriaService $service)
    {
        parent::__construct($service);
    }
}

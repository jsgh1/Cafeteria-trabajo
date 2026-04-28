<?php
namespace App\Services;

use App\Repositories\CategoriaRepository;

final class CategoriaService extends BaseService
{
    public function __construct(CategoriaRepository $repository)
    {
        parent::__construct($repository, ['nombre']);
    }
}

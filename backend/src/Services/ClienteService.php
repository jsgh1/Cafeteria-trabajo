<?php
namespace App\Services;

use App\Repositories\ClienteRepository;

final class ClienteService extends BaseService
{
    public function __construct(ClienteRepository $repository)
    {
        parent::__construct($repository, ['nombre', 'email']);
    }
}

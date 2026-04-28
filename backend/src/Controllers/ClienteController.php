<?php
namespace App\Controllers;

use App\Services\ClienteService;

final class ClienteController extends BaseController
{
    public function __construct(ClienteService $service)
    {
        parent::__construct($service);
    }
}

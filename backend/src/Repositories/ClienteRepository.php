<?php
namespace App\Repositories;

use PDO;

final class ClienteRepository extends BaseRepository
{
    public function __construct(PDO $db)
    {
        parent::__construct($db, 'clientes', ['nombre', 'email', 'telefono'], ['nombre', 'email', 'telefono']);
    }
}

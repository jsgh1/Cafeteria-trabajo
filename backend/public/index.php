<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Core\Response;
use App\Repositories\CategoriaRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\PedidoRepository;
use App\Repositories\PedidoItemRepository;
use App\Services\CategoriaService;
use App\Services\ProductoService;
use App\Services\ClienteService;
use App\Services\PedidoService;
use App\Services\PedidoItemService;
use App\Controllers\CategoriaController;
use App\Controllers\ProductoController;
use App\Controllers\ClienteController;
use App\Controllers\PedidoController;
use App\Controllers\PedidoItemController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

if ($path === '/' || $path === '/health') {
    Response::json(['status' => 'ok', 'service' => 'cafeteria-backend']);
    exit;
}
if ($path === '/docs') {
    header('Content-Type: text/html; charset=utf-8');
    echo file_get_contents(__DIR__ . '/../docs/swagger-ui.html');
    exit;
}
if ($path === '/openapi.json') {
    header('Content-Type: application/json; charset=utf-8');
    echo file_get_contents(__DIR__ . '/../docs/openapi.json');
    exit;
}

$db = Database::getConnection();
$controllers = [
    'categorias' => new CategoriaController(new CategoriaService(new CategoriaRepository($db))),
    'productos' => new ProductoController(new ProductoService(new ProductoRepository($db))),
    'clientes' => new ClienteController(new ClienteService(new ClienteRepository($db))),
    'pedidos' => new PedidoController(new PedidoService(new PedidoRepository($db))),
    'pedido_items' => new PedidoItemController(new PedidoItemService(new PedidoItemRepository($db))),
];

if (preg_match('#^/api/([a-z_]+)(?:/(filter|\d+))?$#', $path, $matches)) {
    $resource = $matches[1];
    $argument = $matches[2] ?? null;
    if (!isset($controllers[$resource])) {
        Response::json(['error' => 'Recurso no existe'], 404); exit;
    }
    $controller = $controllers[$resource];
    if ($argument === 'filter' && $method === 'GET') { $controller->filter(); exit; }
    if ($argument !== null && ctype_digit($argument)) {
        $id = (int)$argument;
        match ($method) {
            'GET' => $controller->show($id),
            'PUT' => $controller->update($id),
            'DELETE' => $controller->destroy($id),
            default => Response::json(['error' => 'Método no permitido'], 405),
        };
        exit;
    }
    if ($argument === null) {
        match ($method) {
            'GET' => $controller->index(),
            'POST' => $controller->store(),
            default => Response::json(['error' => 'Método no permitido'], 405),
        };
        exit;
    }
}
Response::json(['error' => 'Ruta no encontrada'], 404);

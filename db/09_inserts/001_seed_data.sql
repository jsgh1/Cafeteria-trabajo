INSERT INTO categorias (nombre, descripcion, activo) VALUES
('Café', 'Bebidas calientes y frías preparadas con café', true),
('Panadería', 'Productos horneados para acompañar bebidas', true),
('Postres', 'Opciones dulces de la cafetería', true)
ON CONFLICT (nombre) DO NOTHING;

INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, activo) VALUES
((SELECT id FROM categorias WHERE nombre='Café'), 'Capuccino', 'Café espresso con leche vaporizada y espuma', 8500, 50, true),
((SELECT id FROM categorias WHERE nombre='Café'), 'Latte Vainilla', 'Latte con jarabe artesanal de vainilla', 9500, 40, true),
((SELECT id FROM categorias WHERE nombre='Panadería'), 'Croissant', 'Croissant de mantequilla recién horneado', 6500, 30, true),
((SELECT id FROM categorias WHERE nombre='Postres'), 'Cheesecake', 'Porción de cheesecake con frutos rojos', 12000, 20, true),
((SELECT id FROM categorias WHERE nombre='Café'), 'Americano', 'Café americano clásico', 6000, 60, true)
ON CONFLICT (nombre) DO NOTHING;

INSERT INTO clientes (nombre, email, telefono) VALUES
('Ana Torres', 'ana.torres@example.com', '3001112233'),
('Carlos Pérez', 'carlos.perez@example.com', '3002223344'),
('Lucía Gómez', 'lucia.gomez@example.com', '3003334455')
ON CONFLICT (email) DO NOTHING;

INSERT INTO pedidos (cliente_id, estado, total) VALUES
((SELECT id FROM clientes WHERE email='ana.torres@example.com'), 'PAGADO', 15000),
((SELECT id FROM clientes WHERE email='carlos.perez@example.com'), 'PENDIENTE', 21500),
((SELECT id FROM clientes WHERE email='lucia.gomez@example.com'), 'ENTREGADO', 12000);

INSERT INTO pedido_items (pedido_id, producto_id, cantidad, precio_unitario) VALUES
(1, (SELECT id FROM productos WHERE nombre='Americano'), 1, 6000),
(1, (SELECT id FROM productos WHERE nombre='Croissant'), 1, 6500),
(2, (SELECT id FROM productos WHERE nombre='Latte Vainilla'), 1, 9500),
(2, (SELECT id FROM productos WHERE nombre='Cheesecake'), 1, 12000),
(3, (SELECT id FROM productos WHERE nombre='Cheesecake'), 1, 12000);

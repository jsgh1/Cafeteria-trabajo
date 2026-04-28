DELETE FROM pedido_items WHERE pedido_id IN (1,2,3);
DELETE FROM pedidos WHERE id IN (1,2,3);
DELETE FROM clientes WHERE email IN ('ana.torres@example.com','carlos.perez@example.com','lucia.gomez@example.com');
DELETE FROM productos WHERE nombre IN ('Capuccino','Latte Vainilla','Croissant','Cheesecake','Americano');
DELETE FROM categorias WHERE nombre IN ('Café','Panadería','Postres');

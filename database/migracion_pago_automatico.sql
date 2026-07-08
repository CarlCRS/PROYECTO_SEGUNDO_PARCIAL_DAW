ALTER TABLE pagos
    ADD COLUMN estado_pago ENUM('pendiente','pagado','cancelado','reembolsado') NOT NULL DEFAULT 'pendiente' AFTER monto;

ALTER TABLE pagos
    MODIFY COLUMN metodo_pago ENUM('pendiente','efectivo','tarjeta','transferencia') NOT NULL DEFAULT 'pendiente';
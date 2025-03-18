CREATE TABLE empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ventas_menores_300 INT DEFAULT 0,
    ventas_300_800 INT DEFAULT 0,
    ventas_mayores_800 INT DEFAULT 0,
    total_ventas DECIMAL(10, 2) DEFAULT 0,
    bonificacion DECIMAL(10, 2) DEFAULT 0,
    pago_total DECIMAL(10, 2) DEFAULT 0
);
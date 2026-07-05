CREATE DATABASE IF NOT EXISTS citas_medicas
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE citas_medicas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','medico','paciente') NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nombre VARCHAR(100) NOT NULL,
    especialidad_id INT,
    telefono VARCHAR(20),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (especialidad_id) REFERENCES especialidades(id) ON DELETE SET NULL
);

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nombre VARCHAR(100) NOT NULL,
    cedula VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('pendiente','confirmada','cancelada','atendida') DEFAULT 'pendiente',
    motivo VARCHAR(255),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE,
    UNIQUE KEY horario_unico (medico_id, fecha, hora)
);

CREATE TABLE antecedentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    fecha_registro DATE NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE
);

CREATE TABLE horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    dia_semana ENUM('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE
);

CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    especialidad_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    tarifa DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (especialidad_id) REFERENCES especialidades(id) ON DELETE CASCADE
);

CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cita_id INT NOT NULL,
    monto DECIMAL(8,2) NOT NULL,
    metodo_pago ENUM('efectivo','tarjeta','transferencia') NOT NULL,
    fecha_pago DATE NOT NULL,
    FOREIGN KEY (cita_id) REFERENCES citas(id) ON DELETE CASCADE
);

INSERT INTO especialidades (nombre) VALUES
('Medicina General'),
('Pediatria'),
('Odontologia'),
('Dermatologia');

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Admin Sistema', 'admin@clinica.com', '$2y$10$hashDeEjemplo', 'admin');

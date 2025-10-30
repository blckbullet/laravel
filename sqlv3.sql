-- ===================================================
-- SCRIPT PARA LA BASE DE DATOS 'escuelita'
-- ESTRUCTURA FINAL CON DATOS DE PRUEBA COHERENTES
-- ===================================================

DROP DATABASE IF EXISTS escuelita;
CREATE DATABASE escuelita;
USE escuelita;

-- Tabla: areas
CREATE TABLE areas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    jefe_area VARCHAR(100),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Tabla: carreras
CREATE TABLE carreras (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    area_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_carreras_areas FOREIGN KEY (area_id) REFERENCES areas(id)
);

-- Tabla: profesores
CREATE TABLE profesores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    area_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_profesores_areas FOREIGN KEY (area_id) REFERENCES areas(id)
);

-- Tabla: materias
CREATE TABLE materias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    creditos INT,
    semestre_optimo INT,
    carrera_id BIGINT UNSIGNED NOT NULL,
    prerequisito_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_materias_carreras FOREIGN KEY (carrera_id) REFERENCES carreras(id),
    CONSTRAINT fk_materias_prerequisito FOREIGN KEY (prerequisito_id) REFERENCES materias(id)
);

-- Tabla: paquetes
CREATE TABLE paquetes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Tabla: paquete_materias (Pivote)
CREATE TABLE paquete_materias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    paquete_id BIGINT UNSIGNED NOT NULL,
    materia_id BIGINT UNSIGNED NOT NULL,
    UNIQUE (paquete_id, materia_id),
    CONSTRAINT fk_paquete_materias_paquetes FOREIGN KEY (paquete_id) REFERENCES paquetes(id) ON DELETE CASCADE,
    CONSTRAINT fk_paquete_materias_materias FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
);

-- Tabla: materia_profesores (Pivote)
CREATE TABLE materia_profesores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profesor_id BIGINT UNSIGNED NOT NULL,
    materia_id BIGINT UNSIGNED NOT NULL,
    UNIQUE (profesor_id, materia_id),
    CONSTRAINT fk_materia_profesores_profesores FOREIGN KEY (profesor_id) REFERENCES profesores(id) ON DELETE CASCADE,
    CONSTRAINT fk_materia_profesores_materias FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
);

-- Tabla: grupos
CREATE TABLE grupos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL,
    materia_id BIGINT UNSIGNED NOT NULL,
    profesor_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_grupos_materias FOREIGN KEY (materia_id) REFERENCES materias(id),
    CONSTRAINT fk_grupos_profesores FOREIGN KEY (profesor_id) REFERENCES profesores(id)
);


--  Tabla: alumnos (MODIFICADA)
CREATE TABLE alumnos (
    matricula VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    segundo_nombre VARCHAR(50) NULL, -- Columna agregada
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    carrera_id BIGINT UNSIGNED NOT NULL,
    semestre_actual TINYINT UNSIGNED NULL DEFAULT NULL,
    es_egresado BOOLEAN NOT NULL DEFAULT FALSE,
    esta_activo BOOLEAN NOT NULL DEFAULT TRUE, -- CAMBIO APLICADO
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_alumnos_carreras FOREIGN KEY (carrera_id) REFERENCES carreras(id)
);

-- Tabla: historiales
CREATE TABLE historiales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    alumno_matricula VARCHAR(20) NOT NULL,
    materia_id BIGINT UNSIGNED NOT NULL,
    grupo_id BIGINT UNSIGNED NULL, -- CAMBIO APLICADO
    calificacion DECIMAL(5, 2) NULL, -- CAMBIO APLICADO
    semestre INT,
    año INT,
    tipo VARCHAR(50),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    -- Se eliminó la restricción UNIQUE(alumno_matricula, materia_id)
    
    CONSTRAINT fk_historiales_alumnos FOREIGN KEY (alumno_matricula) REFERENCES alumnos(matricula),
    CONSTRAINT fk_historiales_materias FOREIGN KEY (materia_id) REFERENCES materias(id),
    CONSTRAINT fk_historiales_grupos FOREIGN KEY (grupo_id) REFERENCES grupos(id) -- CAMBIO APLICADO
);


-- Tabla: horarios (NUEVA TABLA)
CREATE TABLE horarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    grupo_id BIGINT UNSIGNED NOT NULL,
    -- CORRECCIÓN: ENUM en minúsculas y sin acentos para coincidir con la lógica del controlador
    dia_semana ENUM('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    CONSTRAINT fk_horarios_grupos FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON DELETE CASCADE
);

-- ===================================================
-- INSERCIÓN DE DATOS DE PRUEBA
-- ===================================================
USE escuelita;

-- ===================================================
-- Tabla: areas (5 registros)
-- ===================================================
INSERT INTO `areas` (`id`, `nombre`, `descripcion`, `jefe_area`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería y Ciencias Exactas', 'Área enfocada en el desarrollo tecnológico y las ciencias fundamentales.', 'Dr. Armando Paredes', NOW(), NOW()),
(2, 'Ciencias Sociales y Humanidades', 'Área para el estudio de la sociedad, la historia y el arte.', 'Lic. Aquiles Voy', NOW(), NOW()),
(3, 'Ciencias de la Salud', 'Área dedicada a la medicina, enfermería y nutrición.', 'Dr. Aniceto Pital', NOW(), NOW()),
(4, 'Ciencias Económico-Administrativas', 'Área de negocios, contaduría y finanzas.', 'Mtro. Bill Gates', NOW(), NOW()),
(5, 'Artes y Diseño', 'Fomento de la creatividad y la expresión artística.', 'Lic. Vincent Van Gogh', NOW(), NOW());

-- ===================================================
-- Tabla: carreras (5 registros)
-- ===================================================
INSERT INTO `carreras` (`id`, `nombre`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería en Sistemas Computacionales', 1, NOW(), NOW()),
(2, 'Licenciatura en Administración de Empresas', 4, NOW(), NOW()),
(3, 'Licenciatura en Derecho', 2, NOW(), NOW()),
(4, 'Medicina', 3, NOW(), NOW()),
(5, 'Licenciatura en Diseño Gráfico', 5, NOW(), NOW());

-- ===================================================
-- Tabla: profesores (50 registros)
-- ===================================================
INSERT INTO `profesores` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'Alberto', 'Gómez', 'Hernández', 'prof1@escuela.edu', '22200001', 1, NOW(), NOW()),
(2, 'Beatriz', 'Pérez', 'López', 'prof2@escuela.edu', '22200002', 4, NOW(), NOW()),
(3, 'Carlos', 'Martínez', 'García', 'prof3@escuela.edu', '22200003', 2, NOW(), NOW()),
(4, 'Diana', 'Ramírez', 'Rodríguez', 'prof4@escuela.edu', '22200004', 3, NOW(), NOW()),
(5, 'Ernesto', 'Sánchez', 'Fernández', 'prof5@escuela.edu', '22200005', 5, NOW(), NOW()),
(6, 'Fátima', 'González', 'Díaz', 'prof6@escuela.edu', '22200006', 1, NOW(), NOW()),
(7, 'Gerardo', 'Cruz', 'Moreno', 'prof7@escuela.edu', '22200007', 2, NOW(), NOW()),
(8, 'Hilda', 'Flores', 'Jiménez', 'prof8@escuela.edu', '22200008', 3, NOW(), NOW()),
(9, 'Ignacio', 'Vázquez', 'Ruiz', 'prof9@escuela.edu', '22200009', 4, NOW(), NOW()),
(10, 'Julieta', 'Mendoza', 'Torres', 'prof10@escuela.edu', '22200010', 5, NOW(), NOW()),
(11, 'Kevin', 'Silva', 'Rojas', 'prof11@escuela.edu', '22200011', 1, NOW(), NOW()),
(12, 'Laura', 'Ortiz', 'Soto', 'prof12@escuela.edu', '22200012', 2, NOW(), NOW()),
(13, 'Mario', 'Guerrero', 'Reyes', 'prof13@escuela.edu', '22200013', 3, NOW(), NOW()),
(14, 'Norma', 'Luna', 'Acosta', 'prof14@escuela.edu', '22200014', 4, NOW(), NOW()),
(15, 'Óscar', 'Castillo', 'Navarro', 'prof15@escuela.edu', '22200015', 5, NOW(), NOW()),
(16, 'Patricia', 'Herrera', 'Salazar', 'prof16@escuela.edu', '22200016', 1, NOW(), NOW()),
(17, 'Quintín', 'Mora', 'Campos', 'prof17@escuela.edu', '22200017', 2, NOW(), NOW()),
(18, 'Raquel', 'Chávez', 'Vega', 'prof18@escuela.edu', '22200018', 3, NOW(), NOW()),
(19, 'Sergio', 'León', 'Medina', 'prof19@escuela.edu', '22200019', 4, NOW(), NOW()),
(20, 'Tania', 'Pineda', 'Guzmán', 'prof20@escuela.edu', '22200020', 5, NOW(), NOW()),
(21, 'Ulises', 'Rangel', 'Cabrera', 'prof21@escuela.edu', '22200021', 1, NOW(), NOW()),
(22, 'Verónica', 'Juárez', 'Osorio', 'prof22@escuela.edu', '22200022', 2, NOW(), NOW()),
(23, 'Walter', 'Domínguez', 'Delgado', 'prof23@escuela.edu', '22200023', 3, NOW(), NOW()),
(24, 'Ximena', 'Ríos', 'Ibarra', 'prof24@escuela.edu', '22200024', 4, NOW(), NOW()),
(25, 'Yael', 'Montes', 'Ponce', 'prof25@escuela.edu', '22200025', 5, NOW(), NOW()),
(26, 'Zoe', 'Solís', 'Padilla', 'prof26@escuela.edu', '22200026', 1, NOW(), NOW()),
(27, 'Adrián', 'Cervantes', 'Lara', 'prof27@escuela.edu', '22200027', 2, NOW(), NOW()),
(28, 'Brenda', 'Figueroa', 'Meza', 'prof28@escuela.edu', '22200028', 3, NOW(), NOW()),
(29, 'César', 'Miranda', 'Álvarez', 'prof29@escuela.edu', '22200029', 4, NOW(), NOW()),
(30, 'Daniela', 'Aguilar', 'Sandoval', 'prof30@escuela.edu', '22200030', 5, NOW(), NOW()),
(31, 'Eduardo', 'Benítez', 'Valencia', 'prof31@escuela.edu', '22200031', 1, NOW(), NOW()),
(32, 'Fernanda', 'Castro', 'Blanco', 'prof32@escuela.edu', '22200032', 2, NOW(), NOW()),
(33, 'Gustavo', 'Rosas', 'Estrella', 'prof33@escuela.edu', '22200033', 3, NOW(), NOW()),
(34, 'Isabel', 'Zavala', 'Márquez', 'prof34@escuela.edu', '22200034', 4, NOW(), NOW()),
(35, 'Javier', 'Paredes', 'Cortés', 'prof35@escuela.edu', '22200035', 5, NOW(), NOW()),
(36, 'Karla', 'Gallardo', 'Ochoa', 'prof36@escuela.edu', '22200036', 1, NOW(), NOW()),
(37, 'Luis', 'Bravo', 'Villalobos', 'prof37@escuela.edu', '22200037', 2, NOW(), NOW()),
(38, 'Mónica', 'Escobar', 'Galindo', 'prof38@escuela.edu', '22200038', 3, NOW(), NOW()),
(39, 'Natalia', 'Fuentes', 'Roldán', 'prof39@escuela.edu', '22200039', 4, NOW(), NOW()),
(40, 'Omar', 'Cano', 'Ortega', 'prof40@escuela.edu', '22200040', 5, NOW(), NOW()),
(41, 'Pedro', 'Vargas', 'Solis', 'prof41@escuela.edu', '22200041', 1, NOW(), NOW()),
(42, 'Queren', 'Valdez', 'Camacho', 'prof42@escuela.edu', '22200042', 2, NOW(), NOW()),
(43, 'Roberto', 'Castañeda', 'Rico', 'prof43@escuela.edu', '22200043', 3, NOW(), NOW()),
(44, 'Sandra', 'Núñez', 'Peña', 'prof44@escuela.edu', '22200044', 4, NOW(), NOW()),
(45, 'Tomás', 'Salas', 'Franco', 'prof45@escuela.edu', '22200045', 5, NOW(), NOW()),
(46, 'Uriel', 'Pacheco', 'Parra', 'prof46@escuela.edu', '22200046', 1, NOW(), NOW()),
(47, 'Violeta', 'Corona', 'Serrano', 'prof47@escuela.edu', '22200047', 2, NOW(), NOW()),
(48, 'William', 'Barrios', 'Romo', 'prof48@escuela.edu', '22200048', 3, NOW(), NOW()),
(49, 'Xochitl', 'Galvan', 'Bautista', 'prof49@escuela.edu', '22200049', 4, NOW(), NOW()),
(50, 'Yadira', 'Escamilla', 'Celis', 'prof50@escuela.edu', '22200050', 5, NOW(), NOW());

-- ===================================================
-- Tabla: materias (50 registros)
-- ===================================================
INSERT INTO `materias` (`id`, `nombre`, `creditos`, `semestre_optimo`, `carrera_id`, `prerequisito_id`, `created_at`, `updated_at`) VALUES
(1, 'Cálculo Diferencial', 8, 1, 1, NULL, NOW(), NOW()),
(2, 'Fundamentos de Programación', 8, 1, 1, NULL, NOW(), NOW()),
(3, 'Contabilidad Básica', 8, 1, 2, NULL, NOW(), NOW()),
(4, 'Introducción al Derecho', 8, 1, 3, NULL, NOW(), NOW()),
(5, 'Anatomía Humana I', 10, 1, 4, NULL, NOW(), NOW()),
(6, 'Dibujo Arquitectónico', 6, 1, 5, NULL, NOW(), NOW()),
(7, 'Cálculo Integral', 8, 2, 1, 1, NOW(), NOW()),
(8, 'Programación Orientada a Objetos', 8, 2, 1, 2, NOW(), NOW()),
(9, 'Contabilidad de Costos', 8, 2, 2, 3, NOW(), NOW()),
(10, 'Derecho Romano', 8, 2, 3, 4, NOW(), NOW()),
(11, 'Anatomía Humana II', 10, 2, 4, 5, NOW(), NOW()),
(12, 'Geometría Descriptiva', 6, 2, 5, 6, NOW(), NOW()),
(13, 'Estructuras de Datos', 8, 3, 1, 8, NOW(), NOW()),
(14, 'Bases de Datos', 8, 3, 1, 8, NOW(), NOW()),
(15, 'Administración Financiera', 8, 3, 2, 9, NOW(), NOW()),
(16, 'Derecho Constitucional', 8, 3, 3, 10, NOW(), NOW()),
(17, 'Fisiología', 10, 3, 4, 11, NOW(), NOW()),
(18, 'Teoría del Diseño', 6, 3, 5, 12, NOW(), NOW()),
(19, 'Sistemas Operativos', 8, 4, 1, 13, NOW(), NOW()),
(20, 'Redes de Computadoras', 8, 4, 1, 13, NOW(), NOW()),
(21, 'Mercadotecnia', 8, 4, 2, 15, NOW(), NOW()),
(22, 'Derecho Penal', 8, 4, 3, 16, NOW(), NOW()),
(23, 'Farmacología', 10, 4, 4, 17, NOW(), NOW()),
(24, 'Diseño Editorial', 6, 4, 5, 18, NOW(), NOW()),
(25, 'Ingeniería de Software', 8, 5, 1, 19, NOW(), NOW()),
(26, 'Inteligencia Artificial', 8, 5, 1, 19, NOW(), NOW()),
(27, 'Recursos Humanos', 8, 5, 2, 21, NOW(), NOW()),
(28, 'Derecho Mercantil', 8, 5, 3, 22, NOW(), NOW()),
(29, 'Salud Pública', 10, 5, 4, 23, NOW(), NOW()),
(30, 'Diseño Web', 6, 5, 5, 24, NOW(), NOW()),
(31, 'Desarrollo de Aplicaciones Web', 8, 6, 1, 25, NOW(), NOW()),
(32, 'Seguridad Informática', 8, 6, 1, 26, NOW(), NOW()),
(33, 'Comercio Internacional', 8, 6, 2, 27, NOW(), NOW()),
(34, 'Derecho Fiscal', 8, 6, 3, 28, NOW(), NOW()),
(35, 'Pediatría', 10, 6, 4, 29, NOW(), NOW()),
(36, 'Animación Digital', 6, 6, 5, 30, NOW(), NOW()),
(37, 'Tópicos Avanzados de Programación', 8, 7, 1, 31, NOW(), NOW()),
(38, 'Gestión de Proyectos de TI', 8, 7, 1, 32, NOW(), NOW()),
(39, 'Simulación de Negocios', 8, 7, 2, 33, NOW(), NOW()),
(40, 'Derecho Laboral', 8, 7, 3, 34, NOW(), NOW()),
(41, 'Ginecología', 10, 7, 4, 35, NOW(), NOW()),
(42, 'Modelado 3D', 6, 7, 5, 36, NOW(), NOW()),
(43, 'Residencias Profesionales I', 4, 8, 1, 37, NOW(), NOW()),
(44, 'Proyecto de Titulación I', 4, 8, 1, 38, NOW(), NOW()),
(45, 'Planeación Estratégica', 8, 8, 2, 39, NOW(), NOW()),
(46, 'Amparo', 8, 8, 3, 40, NOW(), NOW()),
(47, 'Cirugía', 10, 8, 4, 41, NOW(), NOW()),
(48, 'Portafolio Profesional', 6, 8, 5, 42, NOW(), NOW()),
(49, 'Residencias Profesionales II', 4, 9, 1, 43, NOW(), NOW()),
(50, 'Proyecto de Titulación II', 4, 9, 1, 44, NOW(), NOW());

-- ===================================================
-- Tabla: alumnos (50 registros)
-- ===================================================
INSERT INTO `alumnos` (`matricula`, `nombre`, `segundo_nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `carrera_id`, `semestre_actual`, `es_egresado`, `esta_activo`, `created_at`, `updated_at`) VALUES
('21220501', 'Ana', 'Sofía', 'García', 'López', '21220501@escuela.mx', '22210501', 1, 3, 0, 1, NOW(), NOW()),
('21220502', 'Bruno', NULL, 'Hernández', 'Martínez', '21220502@escuela.mx', '22210502', 2, 5, 0, 1, NOW(), NOW()),
('21220503', 'Carla', 'Patricia', 'Rodríguez', 'Pérez', '21220503@escuela.mx', '22210503', 3, 7, 0, 1, NOW(), NOW()),
('21220504', 'David', 'Alejandro', 'Fernández', 'Gómez', '21220504@escuela.mx', '22210504', 4, 9, 0, 1, NOW(), NOW()),
('21220505', 'Elena', NULL, 'Díaz', 'Sánchez', '21220505@escuela.mx', '22210505', 5, 1, 0, 1, NOW(), NOW()),
('21220506', 'Fernando', 'José', 'Moreno', 'González', '21220506@escuela.mx', '22210506', 1, 3, 0, 1, NOW(), NOW()),
('21220507', 'Gabriela', NULL, 'Jiménez', 'Cruz', '21220507@escuela.mx', '22210507', 2, 5, 0, 1, NOW(), NOW()),
('21220508', 'Hugo', 'Alberto', 'Ruiz', 'Flores', '21220508@escuela.mx', '22210508', 3, 7, 0, 1, NOW(), NOW()),
('21220509', 'Irene', 'Beatriz', 'Torres', 'Vázquez', '21220509@escuela.mx', '22210509', 4, 9, 0, 1, NOW(), NOW()),
('21220510', 'Jorge', NULL, 'Rojas', 'Mendoza', '21220510@escuela.mx', '22210510', 5, 2, 0, 1, NOW(), NOW()),
('21220511', 'Karen', 'Daniela', 'Soto', 'Silva', '21220511@escuela.mx', '22210511', 1, 4, 0, 1, NOW(), NOW()),
('21220512', 'Leonardo', NULL, 'Reyes', 'Ortiz', '21220512@escuela.mx', '22210512', 2, 6, 0, 1, NOW(), NOW()),
('21220513', 'Marcela', 'Eugenia', 'Acosta', 'Guerrero', '21220513@escuela.mx', '22210513', 3, 8, 0, 1, NOW(), NOW()),
('21220514', 'Nicolás', 'Esteban', 'Navarro', 'Luna', '21220514@escuela.mx', '22210514', 4, 1, 0, 1, NOW(), NOW()),
('21220515', 'Olivia', NULL, 'Salazar', 'Castillo', '21220515@escuela.mx', '22210515', 5, 3, 0, 1, NOW(), NOW()),
('21220516', 'Pablo', 'Francisco', 'Campos', 'Herrera', '21220516@escuela.mx', '22210516', 1, 5, 0, 1, NOW(), NOW()),
('21220517', 'Quetzalli', NULL, 'Vega', 'Mora', '21220517@escuela.mx', '22210517', 2, 7, 0, 1, NOW(), NOW()),
('21220518', 'Ricardo', 'Gerardo', 'Medina', 'Chávez', '21220518@escuela.mx', '22210518', 3, 9, 0, 1, NOW(), NOW()),
('21220519', 'Sofía', 'Guadalupe', 'Guzmán', 'León', '21220519@escuela.mx', '22210519', 4, 2, 0, 1, NOW(), NOW()),
('21220520', 'Tomás', NULL, 'Cabrera', 'Pineda', '21220520@escuela.mx', '22210520', 5, 4, 0, 1, NOW(), NOW()),
('21220521', 'Úrsula', 'Isabel', 'Osorio', 'Rangel', '21220521@escuela.mx', '22210521', 1, 6, 0, 1, NOW(), NOW()),
('21220522', 'Víctor', NULL, 'Delgado', 'Juárez', '21220522@escuela.mx', '22210522', 2, 8, 0, 1, NOW(), NOW()),
('21220523', 'Wendy', 'Julieta', 'Ibarra', 'Domínguez', '21220523@escuela.mx', '22210523', 3, 1, 0, 1, NOW(), NOW()),
('21220524', 'Xavier', 'Kevin', 'Ponce', 'Ríos', '21220524@escuela.mx', '22210524', 4, 3, 0, 1, NOW(), NOW()),
('21220525', 'Yara', NULL, 'Padilla', 'Montes', '21220525@escuela.mx', '22210525', 5, 5, 0, 1, NOW(), NOW()),
('21220526', 'Zacarías', 'Luis', 'Lara', 'Solís', '21220526@escuela.mx', '22210526', 1, 7, 0, 1, NOW(), NOW()),
('21220527', 'Alicia', NULL, 'Meza', 'Cervantes', '21220527@escuela.mx', '22210527', 2, 9, 0, 1, NOW(), NOW()),
('21220528', 'Benjamín', 'Mario', 'Álvarez', 'Figueroa', '21220528@escuela.mx', '22210528', 3, 2, 0, 1, NOW(), NOW()),
('21220529', 'Clara', 'Norma', 'Sandoval', 'Miranda', '21220529@escuela.mx', '22210529', 4, 4, 0, 1, NOW(), NOW()),
('21220530', 'Diego', NULL, 'Valencia', 'Aguilar', '21220530@escuela.mx', '22210530', 5, 6, 0, 1, NOW(), NOW()),
('21220531', 'Estela', 'Ofelia', 'Blanco', 'Benítez', '21220531@escuela.mx', '22210531', 1, 8, 0, 1, NOW(), NOW()),
('21220532', 'Felipe', NULL, 'Estrella', 'Castro', '21220532@escuela.mx', '22210532', 2, 1, 0, 1, NOW(), NOW()),
('21220533', 'Gloria', 'Paula', 'Márquez', 'Rosas', '21220533@escuela.mx', '22210533', 3, 3, 0, 1, NOW(), NOW()),
('21220534', 'Héctor', 'Quintín', 'Cortés', 'Zavala', '21220534@escuela.mx', '22210534', 4, 5, 0, 1, NOW(), NOW()),
('21220535', 'Ismael', NULL, 'Ochoa', 'Paredes', '21220535@escuela.mx', '22210535', 5, 7, 0, 1, NOW(), NOW()),
('21220536', 'Javier', 'Raúl', 'Villalobos', 'Gallardo', '21220536@escuela.mx', '22210536', 1, 9, 1, 1, NULL, NOW()),
('21220537', 'Lorena', NULL, 'Galindo', 'Bravo', '21220537@escuela.mx', '22210537', 2, 2, 0, 1, NOW(), NOW()),
('21220538', 'Manuel', 'Sergio', 'Roldán', 'Escobar', '21220538@escuela.mx', '22210538', 3, 4, 0, 1, NOW(), NOW()),
('21220539', 'Nancy', 'Teresa', 'Ortega', 'Fuentes', '21220539@escuela.mx', '22210539', 4, 6, 0, 1, NOW(), NOW()),
('21220540', 'Óliver', NULL, 'Vargas', 'Cano', '21220540@escuela.mx', '22210540', 5, 8, 1, 1, NULL, NOW()),
('21220541', 'Pamela', 'Úrsula', 'Ramos', 'Guerra', '21220541@escuela.mx', '22210541', 1, 1, 0, 1, NOW(), NOW()),
('21220542', 'Ramiro', NULL, 'Zamora', 'Sosa', '21220542@escuela.mx', '22210542', 2, 3, 0, 1, NOW(), NOW()),
('21220543', 'Susana', 'Verónica', 'Abad', 'Orozco', '21220543@escuela.mx', '22210543', 3, 5, 0, 1, NOW(), NOW()),
('21220544', 'Tadeo', 'Walter', 'Báez', 'Peralta', '21220544@escuela.mx', '22210544', 4, 7, 0, 1, NOW(), NOW()),
('21220545', 'Valeria', NULL, 'Cárdenas', 'Quiroz', '21220545@escuela.mx', '22210545', 5, 9, 0, 1, NOW(), NOW()),
('21220546', 'Alfredo', 'Xavier', 'Del Ángel', 'Salcido', '21220546@escuela.mx', '22210546', 1, 2, 0, 1, NOW(), NOW()),
('21220547', 'Blanca', 'Yara', 'Esquivel', 'Téllez', '21220547@escuela.mx', '22210547', 2, 4, 0, 1, NOW(), NOW()),
('21220548', 'Cristian', NULL, 'Fajardo', 'Urbina', '21220548@escuela.mx', '22210548', 3, 6, 0, 1, NOW(), NOW()),
('21220549', 'Dafne', 'Zoe', 'Galicia', 'Varela', '21220549@escuela.mx', '22210549', 4, 8, 0, 1, NOW(), NOW()),
('21220550', 'Efraín', NULL, 'Haro', 'Zepeda', '21220550@escuela.mx', '22210550', 5, 1, 0, 1, NOW(), NOW());

-- ===================================================
-- Tabla: grupos (50 registros)
-- ===================================================
INSERT INTO `grupos` (`id`, `nombre`, `materia_id`, `profesor_id`, `created_at`, `updated_at`) VALUES
(1, '101A', 1, 1, NOW(), NOW()), (2, '101B', 2, 6, NOW(), NOW()), (3, '201A', 3, 2, NOW(), NOW()), (4, '301A', 4, 3, NOW(), NOW()), (5, '401A', 5, 4, NOW(), NOW()),
(6, '501A', 6, 5, NOW(), NOW()), (7, '102A', 7, 11, NOW(), NOW()), (8, '102B', 8, 16, NOW(), NOW()), (9, '202A', 9, 9, NOW(), NOW()), (10, '302A', 10, 8, NOW(), NOW()),
(11, '402A', 11, 13, NOW(), NOW()), (12, '502A', 12, 10, NOW(), NOW()), (13, '103A', 13, 21, NOW(), NOW()), (14, '103B', 14, 26, NOW(), NOW()), (15, '203A', 15, 14, NOW(), NOW()),
(16, '303A', 16, 17, NOW(), NOW()), (17, '403A', 17, 18, NOW(), NOW()), (18, '503A', 18, 15, NOW(), NOW()), (19, '104A', 19, 31, NOW(), NOW()), (20, '104B', 20, 36, NOW(), NOW()),
(21, '204A', 21, 19, NOW(), NOW()), (22, '304A', 22, 23, NOW(), NOW()), (23, '404A', 23, 28, NOW(), NOW()), (24, '504A', 24, 20, NOW(), NOW()), (25, '105A', 25, 41, NOW(), NOW()),
(26, '105B', 26, 46, NOW(), NOW()), (27, '205A', 27, 24, NOW(), NOW()), (28, '305A', 28, 33, NOW(), NOW()), (29, '405A', 29, 38, NOW(), NOW()), (30, '505A', 30, 25, NOW(), NOW()),
(31, '106A', 31, 49, NOW(), NOW()), (32, '106B', 32, 32, NOW(), NOW()), (33, '206A', 33, 29, NOW(), NOW()), (34, '306A', 34, 37, NOW(), NOW()), (35, '406A', 35, 43, NOW(), NOW()),
(36, '506A', 36, 30, NOW(), NOW()), (37, '107A', 37, 48, NOW(), NOW()), (38, '107B', 38, 27, NOW(), NOW()), (39, '207A', 39, 34, NOW(), NOW()), (40, '307A', 40, 42, NOW(), NOW()),
(41, '407A', 41, 48, NOW(), NOW()), (42, '507A', 42, 35, NOW(), NOW()), (43, '108A', 43, 1, NOW(), NOW()), (44, '108B', 44, 6, NOW(), NOW()), (45, '208A', 45, 39, NOW(), NOW()),
(46, '308A', 46, 47, NOW(), NOW()), (47, '408A', 47, 22, NOW(), NOW()), (48, '508A', 48, 40, NOW(), NOW()), (49, '109A', 49, 11, NOW(), NOW()), (50, '109B', 50, 16, NOW(), NOW());

-- ===================================================
-- Tabla: historiales (50 registros)
-- CORREGIDO: Se añade 'grupo_id' para ser coherente
-- ===================================================
INSERT INTO `historiales` (`alumno_matricula`, `materia_id`, `grupo_id`, `calificacion`, `semestre`, `año`, `tipo`, `created_at`, `updated_at`) VALUES
('21220501', 1, 1, 9.50, 1, 2023, 'Ordinario', NOW(), NOW()),
('21220501', 2, 2, 10.00, 1, 2023, 'Ordinario', NOW(), NOW()),
('21220502', 3, 3, 8.00, 1, 2022, 'Ordinario', NOW(), NOW()),
('21220503', 4, 4, 7.50, 1, 2021, 'Ordinario', NOW(), NOW()),
('21220504', 5, 5, 9.00, 1, 2020, 'Ordinario', NOW(), NOW()),
('21220505', 6, 6, 8.80, 1, 2024, 'Ordinario', NOW(), NOW()),
('21220506', 1, 1, 9.20, 1, 2023, 'Repite', NOW(), NOW()),
('21220507', 3, 3, 10.00, 2, 2022, 'Ordinario', NOW(), NOW()),
('21220508', 4, 4, 6.50, 1, 2021, 'Extraordinario', NOW(), NOW()),
('21220509', 5, 5, 8.50, 2, 2020, 'Ordinario', NOW(), NOW()),
('21220510', 6, 6, 9.70, 2, 2024, 'Ordinario', NOW(), NOW()),
('21220511', 7, 7, 8.10, 2, 2023, 'Ordinario', NOW(), NOW()),
('21220512', 9, 9, 7.90, 2, 2022, 'Ordinario', NOW(), NOW()),
('21220513', 10, 10, 9.40, 2, 2021, 'Ordinario', NOW(), NOW()),
('21220514', 11, 11, 8.60, 2, 2020, 'Ordinario', NOW(), NOW()),
('21220515', 12, 12, 9.90, 2, 2024, 'Ordinario', NOW(), NOW()),
('21220516', 7, 7, 7.00, 3, 2023, 'Ordinario', NOW(), NOW()),
('21220517', 9, 9, 10.00, 3, 2022, 'Ordinario', NOW(), NOW()),
('21220518', 10, 10, 8.30, 3, 2021, 'Ordinario', NOW(), NOW()),
('21220519', 11, 11, 9.00, 3, 2020, 'Repite', NOW(), NOW()),
('21220520', 12, 12, 8.50, 3, 2024, 'Ordinario', NOW(), NOW()),
('21220521', 13, 13, 9.80, 3, 2023, 'Ordinario', NOW(), NOW()),
('21220522', 15, 15, 7.20, 3, 2022, 'Extraordinario', NOW(), NOW()),
('21220523', 16, 16, 8.80, 3, 2021, 'Ordinario', NOW(), NOW()),
('21220524', 17, 17, 9.10, 3, 2020, 'Ordinario', NOW(), NOW()),
('21220525', 18, 18, 8.40, 3, 2024, 'Ordinario', NOW(), NOW()),
('21220526', 13, 13, 9.30, 4, 2023, 'Ordinario', NOW(), NOW()),
('21220527', 15, 15, 9.90, 4, 2022, 'Ordinario', NOW(), NOW()),
('21220528', 16, 16, 7.70, 4, 2021, 'Ordinario', NOW(), NOW()),
('21220529', 17, 17, 8.90, 4, 2020, 'Ordinario', NOW(), NOW()),
('21220530', 18, 18, 9.60, 4, 2024, 'Ordinario', NOW(), NOW()),
('21220531', 19, 19, 8.00, 4, 2023, 'Ordinario', NOW(), NOW()),
('21220532', 21, 21, 7.80, 4, 2022, 'Ordinario', NOW(), NOW()),
('21220533', 22, 22, 9.50, 4, 2021, 'Ordinario', NOW(), NOW()),
('21220534', 23, 23, 8.20, 4, 2020, 'Ordinario', NOW(), NOW()),
('21220535', 24, 24, 8.50, 4, 2024, 'Ordinario', NOW(), NOW()),
('21220536', 1, 1, 10.00, 1, 2020, 'Ordinario', NOW(), NOW()),
('21220537', 3, 3, 10.00, 1, 2021, 'Ordinario', NOW(), NOW()),
('21220538', 4, 4, 9.00, 1, 2022, 'Ordinario', NOW(), NOW()),
('21220539', 5, 5, 9.50, 1, 2023, 'Ordinario', NOW(), NOW()),
('21220540', 6, 6, 8.50, 1, 2024, 'Ordinario', NOW(), NOW()),
('21220541', 2, 2, 7.0, 1, 2024, 'Extraordinario', NOW(), NOW()),
('21220542', 9, 9, 6.0, 2, 2023, 'Repite', NOW(), NOW()),
('21220543', 10, 10, 8.8, 2, 2022, 'Ordinario', NOW(), NOW()),
('21220544', 11, 11, 9.1, 2, 2021, 'Ordinario', NOW(), NOW()),
('21220545', 12, 12, 7.6, 2, 2020, 'Ordinario', NOW(), NOW()),
('21220546', 14, 14, 9.3, 3, 2024, 'Ordinario', NOW(), NOW()),
('21220547', 15, 15, 8.2, 3, 2023, 'Ordinario', NOW(), NOW()),
('21220548', 16, 16, 9.9, 3, 2022, 'Ordinario', NOW(), NOW()),
('21220549', 17, 17, 7.4, 3, 2021, 'Ordinario', NOW(), NOW()),
('21220550', 18, 18, 8.0, 3, 2020, 'Ordinario', NOW(), NOW());

-- ===================================================
-- Tabla: horarios (100 registros)
-- AÑADIDO: Se agregan 2 horarios por cada grupo
-- ===================================================
INSERT INTO `horarios` (`grupo_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
(1, 'lunes', '07:00', '09:00', NOW(), NOW()), (1, 'miercoles', '07:00', '09:00', NOW(), NOW()),
(2, 'lunes', '09:00', '11:00', NOW(), NOW()), (2, 'miercoles', '09:00', '11:00', NOW(), NOW()),
(3, 'martes', '07:00', '09:00', NOW(), NOW()), (3, 'jueves', '07:00', '09:00', NOW(), NOW()),
(4, 'martes', '09:00', '11:00', NOW(), NOW()), (4, 'jueves', '09:00', '11:00', NOW(), NOW()),
(5, 'miercoles', '11:00', '13:00', NOW(), NOW()), (5, 'viernes', '11:00', '13:00', NOW(), NOW()),
(6, 'lunes', '11:00', '13:00', NOW(), NOW()), (6, 'jueves', '11:00', '13:00', NOW(), NOW()),
(7, 'lunes', '13:00', '15:00', NOW(), NOW()), (7, 'miercoles', '13:00', '15:00', NOW(), NOW()),
(8, 'martes', '13:00', '15:00', NOW(), NOW()), (8, 'jueves', '13:00', '15:00', NOW(), NOW()),
(9, 'lunes', '08:00', '10:00', NOW(), NOW()), (9, 'jueves', '08:00', '10:00', NOW(), NOW()),
(10, 'viernes', '07:00', '10:00', NOW(), NOW()), (10, 'sabado', '09:00', '12:00', NOW(), NOW()),
(11, 'lunes', '10:00', '12:00', NOW(), NOW()), (11, 'miercoles', '10:00', '12:00', NOW(), NOW()),
(12, 'martes', '10:00', '12:00', NOW(), NOW()), (12, 'jueves', '10:00', '12:00', NOW(), NOW()),
(13, 'lunes', '16:00', '18:00', NOW(), NOW()), (13, 'miercoles', '16:00', '18:00', NOW(), NOW()),
(14, 'martes', '16:00', '18:00', NOW(), NOW()), (14, 'jueves', '16:00', '18:00', NOW(), NOW()),
(15, 'viernes', '15:00', '17:00', NOW(), NOW()), (15, 'sabado', '10:00', '12:00', NOW(), NOW()),
(16, 'lunes', '18:00', '20:00', NOW(), NOW()), (16, 'miercoles', '18:00', '20:00', NOW(), NOW()),
(17, 'martes', '18:00', '20:00', NOW(), NOW()), (17, 'jueves', '18:00', '20:00', NOW(), NOW()),
(18, 'lunes', '07:00', '09:00', NOW(), NOW()), (18, 'viernes', '07:00', '09:00', NOW(), NOW()),
(19, 'martes', '09:00', '11:00', NOW(), NOW()), (19, 'miercoles', '08:00', '10:00', NOW(), NOW()),
(20, 'jueves', '09:00', '11:00', NOW(), NOW()), (20, 'viernes', '09:00', '11:00', NOW(), NOW()),
(21, 'lunes', '11:00', '13:00', NOW(), NOW()), (21, 'miercoles', '11:00', '13:00', NOW(), NOW()),
(22, 'martes', '11:00', '13:00', NOW(), NOW()), (22, 'jueves', '11:00', '13:00', NOW(), NOW()),
(23, 'lunes', '13:00', '15:00', NOW(), NOW()), (23, 'viernes', '13:00', '15:00', NOW(), NOW()),
(24, 'martes', '13:00', '15:00', NOW(), NOW()), (24, 'sabado', '09:00', '11:00', NOW(), NOW()),
(25, 'lunes', '15:00', '17:00', NOW(), NOW()), (25, 'miercoles', '15:00', '17:00', NOW(), NOW()),
(26, 'martes', '15:00', '17:00', NOW(), NOW()), (26, 'jueves', '15:00', '17:00', NOW(), NOW()),
(27, 'lunes', '17:00', '19:00', NOW(), NOW()), (27, 'miercoles', '17:00', '19:00', NOW(), NOW()),
(28, 'martes', '17:00', '19:00', NOW(), NOW()), (28, 'jueves', '17:00', '19:00', NOW(), NOW()),
(29, 'lunes', '07:00', '10:00', NOW(), NOW()), (29, 'miercoles', '07:00', '10:00', NOW(), NOW()),
(30, 'viernes', '14:00', '17:00', NOW(), NOW()), (30, 'sabado', '11:00', '14:00', NOW(), NOW()),
(31, 'lunes', '10:00', '12:00', NOW(), NOW()), (31, 'jueves', '10:00', '12:00', NOW(), NOW()),
(32, 'martes', '10:00', '12:00', NOW(), NOW()), (32, 'viernes', '10:00', '12:00', NOW(), NOW()),
(33, 'lunes', '12:00', '14:00', NOW(), NOW()), (33, 'miercoles', '12:00', '14:00', NOW(), NOW()),
(34, 'martes', '12:00', '14:00', NOW(), NOW()), (34, 'jueves', '12:00', '14:00', NOW(), NOW()),
(35, 'lunes', '14:00', '16:00', NOW(), NOW()), (35, 'miercoles', '14:00', '16:00', NOW(), NOW()),
(36, 'martes', '14:00', '16:00', NOW(), NOW()), (36, 'jueves', '14:00', '16:00', NOW(), NOW()),
(37, 'lunes', '16:00', '18:00', NOW(), NOW()), (37, 'viernes', '16:00', '18:00', NOW(), NOW()),
(38, 'martes', '16:00', '18:00', NOW(), NOW()), (38, 'sabado', '13:00', '15:00', NOW(), NOW()),
(39, 'lunes', '18:00', '20:00', NOW(), NOW()), (39, 'miercoles', '18:00', '20:00', NOW(), NOW()),
(40, 'martes', '18:00', '20:00', NOW(), NOW()), (40, 'jueves', '18:00', '20:00', NOW(), NOW()),
(41, 'lunes', '08:00', '11:00', NOW(), NOW()), (41, 'miercoles', '08:00', '11:00', NOW(), NOW()),
(42, 'martes', '08:00', '11:00', NOW(), NOW()), (42, 'jueves', '08:00', '11:00', NOW(), NOW()),
(43, 'viernes', '08:00', '10:00', NOW(), NOW()), (43, 'sabado', '09:00', '11:00', NOW(), NOW()),
(44, 'lunes', '11:00', '13:00', NOW(), NOW()), (44, 'miercoles', '11:00', '13:00', NOW(), NOW()),
(45, 'martes', '11:00', '13:00', NOW(), NOW()), (45, 'jueves', '11:00', '13:00', NOW(), NOW()),
(46, 'lunes', '13:00', '15:00', NOW(), NOW()), (46, 'miercoles', '13:00', '15:00', NOW(), NOW()),
(47, 'martes', '13:00', '15:00', NOW(), NOW()), (47, 'jueves', '13:00', '15:00', NOW(), NOW()),
(48, 'lunes', '15:00', '17:00', NOW(), NOW()), (48, 'miercoles', '15:00', '17:00', NOW(), NOW()),
(49, 'martes', '15:00', '17:00', NOW(), NOW()), (49, 'jueves', '15:00', '17:00', NOW(), NOW()),
(50, 'viernes', '17:00', '19:00', NOW(), NOW()), (50, 'sabado', '14:00', '16:00', NOW(), NOW());

-- ===================================================
-- Tabla: paquetes (50 registros)
-- ===================================================
INSERT INTO `paquetes` (`nombre`, `created_at`, `updated_at`) VALUES
('Básico de Sistemas 1', NOW(), NOW()), ('Básico de Sistemas 2', NOW(), NOW()),
('Básico de Administración 1', NOW(), NOW()), ('Básico de Administración 2', NOW(), NOW()),
('Básico de Derecho 1', NOW(), NOW()), ('Básico de Derecho 2', NOW(), NOW()),
('Básico de Medicina 1', NOW(), NOW()), ('Básico de Medicina 2', NOW(), NOW()),
('Básico de Diseño 1', NOW(), NOW()), ('Básico de Diseño 2', NOW(), NOW()),
('Avanzado de Sistemas 1', NOW(), NOW()), ('Avanzado de Sistemas 2', NOW(), NOW()),
('Avanzado de Administración 1', NOW(), NOW()), ('Avanzado de Administración 2', NOW(), NOW()),
('Avanzado de Derecho 1', NOW(), NOW()), ('Avanzado de Derecho 2', NOW(), NOW()),
('Avanzado de Medicina 1', NOW(), NOW()), ('Avanzado de Medicina 2', NOW(), NOW()),
('Avanzado de Diseño 1', NOW(), NOW()), ('Avanzado de Diseño 2', NOW(), NOW()),
('Optativas Sistemas A', NOW(), NOW()), ('Optativas Sistemas B', NOW(), NOW()),
('Optativas Administración A', NOW(), NOW()), ('Optativas Administración B', NOW(), NOW()),
('Optativas Derecho A', NOW(), NOW()), ('Optativas Derecho B', NOW(), NOW()),
('Optativas Medicina A', NOW(), NOW()), ('Optativas Medicina B', NOW(), NOW()),
('Optativas Diseño A', NOW(), NOW()), ('Optativas Diseño B', NOW(), NOW()),
('Complementario Humanidades', NOW(), NOW()), ('Complementario Finanzas', NOW(), NOW()),
('Complementario Salud', NOW(), NOW()), ('Complementario Arte', NOW(), NOW()),
('Complementario Programación', NOW(), NOW()), ('Taller de Tesis Sistemas', NOW(), NOW()),
('Taller de Tesis Administración', NOW(), NOW()), ('Taller de Tesis Derecho', NOW(), NOW()),
('Taller de Tesis Medicina', NOW(), NOW()), ('Taller de Tesis Diseño', NOW(), NOW()),
('Introducción a la IA', NOW(), NOW()), ('Desarrollo Frontend', NOW(), NOW()),
('Desarrollo Backend', NOW(), NOW()), ('Marketing Digital', NOW(), NOW()),
('Estrategias de Negocios', NOW(), NOW()), ('Derecho Corporativo', NOW(), NOW()),
('Juicios Orales', NOW(), NOW()), ('Cardiología Básica', NOW(), NOW()),
('Anatomía Avanzada', NOW(), NOW()), ('Branding y Publicidad', NOW(), NOW());

-- ===================================================
-- Tabla: paquete_materias (50 registros)
-- ===================================================
INSERT INTO `paquete_materias` (`paquete_id`, `materia_id`) VALUES
(1, 1), (1, 2), (2, 7), (2, 8), (3, 3), (3, 9), (4, 15), (4, 21),
(5, 4), (5, 10), (6, 16), (6, 22), (7, 5), (7, 11), (8, 17), (8, 23),
(9, 6), (9, 12), (10, 18), (10, 24), (11, 13), (11, 14), (12, 19), (12, 20),
(13, 27), (14, 33), (15, 28), (16, 34), (17, 29), (18, 35), (19, 30), (20, 36),
(21, 31), (22, 32), (23, 39), (24, 45), (25, 40), (26, 46), (27, 41), (28, 47),
(29, 42), (30, 48), (31, 4), (32, 3), (33, 5), (34, 6), (35, 2), (36, 44),
(37, 45), (38, 46), (39, 47), (40, 48), (41, 26), (42, 25), (43, 31), (44, 27);

-- ===================================================
-- Tabla: materia_profesores (50 registros)
-- ===================================================
INSERT INTO `materia_profesores` (`profesor_id`, `materia_id`) VALUES
(1, 1), (6, 2), (11, 7), (16, 8), (21, 13), (26, 14), (31, 19), (36, 20),
(2, 3), (9, 9), (14, 15), (24, 21), (29, 27), (34, 33), (39, 39), (44, 45),
(3, 4), (8, 10), (13, 16), (18, 22), (23, 28), (28, 34), (33, 40), (38, 46),
(4, 5), (13, 11), (18, 17), (23, 23), (28, 29), (33, 35), (38, 41), (43, 47),
(5, 6), (10, 12), (15, 18), (20, 24), (25, 30), (30, 36), (35, 42), (40, 48),
(41, 25), (46, 26), (42, 49), (47, 50), (43, 29), (44, 31), (45, 32), (48, 38);

COMMIT;

-- ===================================================
-- FIN DEL SCRIPT
-- ===================================================

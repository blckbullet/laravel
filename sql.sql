-- ===================================================
-- SCRIPT CORREGIDO PARA LA BASE DE DATOS 'escuelita'
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


--  Tabla: alumnos

CREATE TABLE alumnos (
    matricula VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    carrera_id BIGINT UNSIGNED NOT NULL,
    semestre_actual TINYINT UNSIGNED NULL DEFAULT NULL, 
    es_egresado BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_alumnos_carreras FOREIGN KEY (carrera_id) REFERENCES carreras(id)
);

-- Tabla: historiales
CREATE TABLE historiales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    alumno_matricula VARCHAR(20) NOT NULL,
    materia_id BIGINT UNSIGNED NOT NULL,
    calificacion DECIMAL(5, 2),
    semestre INT,
    año INT,
    tipo VARCHAR(50),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE (alumno_matricula, materia_id),
    CONSTRAINT fk_historiales_alumnos FOREIGN KEY (alumno_matricula) REFERENCES alumnos(matricula),
    CONSTRAINT fk_historiales_materias FOREIGN KEY (materia_id) REFERENCES materias(id)
);


-- ===================================================
-- INSERCIÓN DE DATOS DE PRUEBA
-- ===================================================
USE escuelita;

-- ===================================================
-- SCRIPT DE INSERCIÓN DE DATOS PARA 'escuelita'
-- SE GENERAN 40 REGISTROS POR TABLA
-- ===================================================

USE escuelita;

-- ===================================================
-- Tabla: areas
-- ===================================================
INSERT INTO `areas` (`id`, `nombre`, `descripcion`, `jefe_area`, `created_at`, `updated_at`) VALUES
(1, 'Ciencias Exactas', 'Área dedicada a las matemáticas, física y química.', 'Dr. Armando Paredes', NOW(), NOW()),
(2, 'Ingeniería y Tecnología', 'Área enfocada en el desarrollo y aplicación de tecnología.', 'Dra. Elsa Pato', NOW(), NOW()),
(3, 'Ciencias Sociales y Humanidades', 'Área para el estudio de la sociedad, la historia y el arte.', 'Lic. Aquiles Voy', NOW(), NOW()),
(4, 'Ciencias de la Salud', 'Área dedicada a la medicina, enfermería y nutrición.', 'Dr. Aniceto Pital', NOW(), NOW()),
(5, 'Ciencias Económico-Administrativas', 'Área de negocios, contaduría y finanzas.', 'Mtro. Bill Gates', NOW(), NOW()),
(6, 'Artes y Diseño', 'Fomento de la creatividad y la expresión artística.', 'Lic. Vincent Van Gogh', NOW(), NOW()),
(7, 'Ciencias Biológicas y Agropecuarias', 'Estudio de los seres vivos y su entorno.', 'Dra. Flora intestinal', NOW(), NOW()),
(8, 'Educación', 'Formación de futuros docentes y pedagogos.', 'Mtra. Elba Gina', NOW(), NOW()),
(9, 'Ciencias de la Computación', 'Área especializada en software, hardware y redes.', 'Ing. Alan Turing', NOW(), NOW()),
(10, 'Derecho y Ciencias Políticas', 'Estudio de las leyes y los sistemas de gobierno.', 'Lic. Derecho Vengador', NOW(), NOW()),
(11, 'Arquitectura', 'Diseño y construcción de espacios habitables.', 'Arq. Armando Casas', NOW(), NOW()),
(12, 'Comunicación y Periodismo', 'Formación en medios masivos y comunicación digital.', 'Lic. Clark Kent', NOW(), NOW()),
(13, 'Psicología', 'Estudio del comportamiento y los procesos mentales.', 'Dra. Mente Brillante', NOW(), NOW()),
(14, 'Física y Astronomía', 'Exploración del universo y sus leyes fundamentales.', 'Dr. Stephen Hawking', NOW(), NOW()),
(15, 'Química e Ingeniería Química', 'Transformación de la materia para el bienestar humano.', 'Ing. Marie Curie', NOW(), NOW()),
(16, 'Matemáticas Aplicadas', 'Uso de las matemáticas para resolver problemas prácticos.', 'Dr. Isaac Newton', NOW(), NOW()),
(17, 'Historia del Arte', 'Análisis de las manifestaciones artísticas a lo largo del tiempo.', 'Lic. Mona Lisa', NOW(), NOW()),
(18, 'Filosofía', 'Búsqueda del conocimiento y la verdad sobre la existencia.', 'Lic. Sócrates Platón', NOW(), NOW()),
(19, 'Letras Modernas', 'Estudio de la literatura y la lingüística contemporánea.', 'Dra. Virginia Woolf', NOW(), NOW()),
(20, 'Antropología Social', 'Estudio de las culturas humanas y sus estructuras sociales.', 'Dr. Indiana Jones', NOW(), NOW()),
(21, 'Mecatrónica', 'Integración de mecánica, electrónica e informática.', 'Ing. Tony Stark', NOW(), NOW()),
(22, 'Biotecnología', 'Aplicación de la tecnología en organismos vivos.', 'Dra. Rosalind Franklin', NOW(), NOW()),
(23, 'Gastronomía', 'Arte y ciencia de la preparación de alimentos.', 'Chef. Remy Gusteau', NOW(), NOW()),
(24, 'Turismo', 'Gestión y planificación de actividades turísticas.', 'Lic. Willy Fog', NOW(), NOW()),
(25, 'Finanzas Corporativas', 'Administración de los recursos financieros de una empresa.', 'Mtro. Gordon Gekko', NOW(), NOW()),
(26, 'Mercadotecnia Digital', 'Estrategias de comercialización en medios digitales.', 'Lic. Don Draper', NOW(), NOW()),
(27, 'Ingeniería Civil', 'Diseño y construcción de infraestructuras.', 'Ing. Bob Constructor', NOW(), NOW()),
(28, 'Relaciones Internacionales', 'Estudio de las interacciones entre estados y organizaciones.', 'Lic. James Bond', NOW(), NOW()),
(29, 'Nutrición Clínica', 'Aplicación de la ciencia de la nutrición en la salud.', 'Dra. Ana Tomía', NOW(), NOW()),
(30, 'Enfermería Quirúrgica', 'Cuidados especializados en el ámbito quirúrgico.', 'Enf. Florence Nightingale', NOW(), NOW()),
(31, 'Diseño Gráfico', 'Comunicación visual a través de imágenes y tipografía.', 'Lic. Saul Bass', NOW(), NOW()),
(32, 'Animación Digital', 'Creación de movimiento en imágenes por computadora.', 'Lic. Walt Disney', NOW(), NOW()),
(33, 'Ciencias Ambientales', 'Estudio de los problemas ambientales y sus soluciones.', 'Dra. Greta Thunberg', NOW(), NOW()),
(34, 'Geología', 'Estudio de la Tierra, sus materiales y procesos.', 'Dr. Charles Darwin', NOW(), NOW()),
(35, 'Pedagogía Infantil', 'Educación y desarrollo en la primera infancia.', 'Mtra. María Montessori', NOW(), NOW()),
(36, 'Psicología Organizacional', 'Comportamiento humano en el ámbito laboral.', 'Dr. Sigmund Freud', NOW(), NOW()),
(37, 'Criminología', 'Estudio científico del delito y la conducta delictiva.', 'Lic. Sherlock Holmes', NOW(), NOW()),
(38, 'Ciencia de Datos', 'Análisis de grandes volúmenes de datos para extraer conocimiento.', 'Ing. Ada Lovelace', NOW(), NOW()),
(39, 'Inteligencia Artificial', 'Desarrollo de sistemas que imitan la inteligencia humana.', 'Dr. John McCarthy', NOW(), NOW()),
(40, 'Desarrollo de Videojuegos', 'Diseño y programación de entretenimiento interactivo.', 'Ing. Shigeru Miyamoto', NOW(), NOW());

-- ===================================================
-- Tabla: paquetes
-- ===================================================
INSERT INTO `paquetes` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Paquete Básico de Matemáticas', NOW(), NOW()),
(2, 'Paquete Introductorio de Programación', NOW(), NOW()),
(3, 'Paquete de Fundamentos de Negocios', NOW(), NOW()),
(4, 'Paquete de Humanidades Esenciales', NOW(), NOW()),
(5, 'Paquete de Ciencias de la Salud I', NOW(), NOW()),
(6, 'Paquete Avanzado de Física', NOW(), NOW()),
(7, 'Paquete de Redes y Seguridad', NOW(), NOW()),
(8, 'Paquete de Marketing Digital', NOW(), NOW()),
(9, 'Paquete de Diseño y Creatividad', NOW(), NOW()),
(10, 'Paquete de Derecho Corporativo', NOW(), NOW()),
(11, 'Paquete de Biología Celular', NOW(), NOW()),
(12, 'Paquete de Estructuras de Datos', NOW(), NOW()),
(13, 'Paquete de Finanzas para No Financieros', NOW(), NOW()),
(14, 'Paquete de Historia Universal', NOW(), NOW()),
(15, 'Paquete de Anatomía Humana', NOW(), NOW()),
(16, 'Paquete de Termodinámica', NOW(), NOW()),
(17, 'Paquete de Ciberseguridad Ofensiva', NOW(), NOW()),
(18, 'Paquete de SEO y SEM', NOW(), NOW()),
(19, 'Paquete de Ilustración Digital', NOW(), NOW()),
(20, 'Paquete de Derecho Penal', NOW(), NOW()),
(21, 'Paquete de Genética y Evolución', NOW(), NOW()),
(22, 'Paquete de Desarrollo Web Full-Stack', NOW(), NOW()),
(23, 'Paquete de Contabilidad Avanzada', NOW(), NOW()),
(24, 'Paquete de Filosofía Griega', NOW(), NOW()),
(25, 'Paquete de Fisiología Aplicada', NOW(), NOW()),
(26, 'Paquete de Mecánica Cuántica', NOW(), NOW()),
(27, 'Paquete de Hacking Ético', NOW(), NOW()),
(28, 'Paquete de Social Media Management', NOW(), NOW()),
(29, 'Paquete de Modelado 3D', NOW(), NOW()),
(30, 'Paquete de Derecho Internacional', NOW(), NOW()),
(31, 'Paquete de Botánica', NOW(), NOW()),
(32, 'Paquete de Machine Learning', NOW(), NOW()),
(33, 'Paquete de Auditoría Fiscal', NOW(), NOW()),
(34, 'Paquete de Lógica y Argumentación', NOW(), NOW()),
(35, 'Paquete de Farmacología', NOW(), NOW()),
(36, 'Paquete de Relatividad Especial', NOW(), NOW()),
(37, 'Paquete de Criptografía', NOW(), NOW()),
(38, 'Paquete de E-commerce y Ventas Online', NOW(), NOW()),
(39, 'Paquete de Animación 2D', NOW(), NOW()),
(40, 'Paquete de Derechos Humanos', NOW(), NOW());

-- ===================================================
-- Tabla: carreras
-- ===================================================
INSERT INTO `carreras` (`id`, `nombre`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería en Sistemas Computacionales', 9, NOW(), NOW()),
(2, 'Licenciatura en Administración de Empresas', 5, NOW(), NOW()),
(3, 'Licenciatura en Derecho', 10, NOW(), NOW()),
(4, 'Medicina', 4, NOW(), NOW()),
(5, 'Arquitectura', 11, NOW(), NOW()),
(6, 'Licenciatura en Psicología', 13, NOW(), NOW()),
(7, 'Ingeniería Mecatrónica', 21, NOW(), NOW()),
(8, 'Licenciatura en Diseño Gráfico', 31, NOW(), NOW()),
(9, 'Licenciatura en Contaduría Pública', 5, NOW(), NOW()),
(10, 'Ingeniería Civil', 27, NOW(), NOW()),
(11, 'Licenciatura en Nutrición', 29, NOW(), NOW()),
(12, 'Licenciatura en Comunicación', 12, NOW(), NOW()),
(13, 'Ingeniería Química', 15, NOW(), NOW()),
(14, 'Licenciatura en Gastronomía', 23, NOW(), NOW()),
(15, 'Actuaría', 1, NOW(), NOW()),
(16, 'Licenciatura en Relaciones Internacionales', 28, NOW(), NOW()),
(17, 'Ingeniería en Biotecnología', 22, NOW(), NOW()),
(18, 'Licenciatura en Filosofía', 18, NOW(), NOW()),
(19, 'Física', 14, NOW(), NOW()),
(20, 'Licenciatura en Mercadotecnia', 26, NOW(), NOW()),
(21, 'Ingeniería Industrial', 2, NOW(), NOW()),
(22, 'Licenciatura en Enfermería', 30, NOW(), NOW()),
(23, 'Ciencias Políticas y Administración Pública', 10, NOW(), NOW()),
(24, 'Ingeniería en Energías Renovables', 2, NOW(), NOW()),
(25, 'Licenciatura en Historia', 3, NOW(), NOW()),
(26, 'Matemáticas Aplicadas', 16, NOW(), NOW()),
(27, 'Licenciatura en Turismo', 24, NOW(), NOW()),
(28, 'Ingeniería en Alimentos', 7, NOW(), NOW()),
(29, 'Licenciatura en Pedagogía', 8, NOW(), NOW()),
(30, 'Criminología y Criminalística', 37, NOW(), NOW()),
(31, 'Licenciatura en Ciencias de la Computación', 9, NOW(), NOW()),
(32, 'Finanzas y Banca', 25, NOW(), NOW()),
(33, 'Ingeniería en Telecomunicaciones', 2, NOW(), NOW()),
(34, 'Licenciatura en Antropología', 20, NOW(), NOW()),
(35, 'Diseño Industrial', 6, NOW(), NOW()),
(36, 'Químico Farmacéutico Biólogo', 15, NOW(), NOW()),
(37, 'Licenciatura en Letras Hispánicas', 19, NOW(), NOW()),
(38, 'Ingeniería Geofísica', 34, NOW(), NOW()),
(39, 'Ciencia de Datos', 38, NOW(), NOW()),
(40, 'Licenciatura en Animación y Arte Digital', 40, NOW(), NOW());

-- ===================================================
-- Tabla: profesores
-- ===================================================
INSERT INTO `profesores` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'Alberto', 'Gómez', 'Hernández', 'prof1@escuela.edu', '22200001', 9, NOW(), NOW()),
(2, 'Beatriz', 'Pérez', 'López', 'prof2@escuela.edu', '22200002', 5, NOW(), NOW()),
(3, 'Carlos', 'Martínez', 'García', 'prof3@escuela.edu', '22200003', 10, NOW(), NOW()),
(4, 'Diana', 'Ramírez', 'Rodríguez', 'prof4@escuela.edu', '22200004', 4, NOW(), NOW()),
(5, 'Ernesto', 'Sánchez', 'Fernández', 'prof5@escuela.edu', '22200005', 11, NOW(), NOW()),
(6, 'Fátima', 'González', 'Díaz', 'prof6@escuela.edu', '22200006', 13, NOW(), NOW()),
(7, 'Gerardo', 'Cruz', 'Moreno', 'prof7@escuela.edu', '22200007', 21, NOW(), NOW()),
(8, 'Hilda', 'Flores', 'Jiménez', 'prof8@escuela.edu', '22200008', 31, NOW(), NOW()),
(9, 'Ignacio', 'Vázquez', 'Ruiz', 'prof9@escuela.edu', '22200009', 5, NOW(), NOW()),
(10, 'Julieta', 'Mendoza', 'Torres', 'prof10@escuela.edu', '22200010', 27, NOW(), NOW()),
(11, 'Kevin', 'Silva', 'Rojas', 'prof11@escuela.edu', '22200011', 29, NOW(), NOW()),
(12, 'Laura', 'Ortiz', 'Soto', 'prof12@escuela.edu', '22200012', 12, NOW(), NOW()),
(13, 'Mario', 'Guerrero', 'Reyes', 'prof13@escuela.edu', '22200013', 15, NOW(), NOW()),
(14, 'Norma', 'Luna', 'Acosta', 'prof14@escuela.edu', '22200014', 23, NOW(), NOW()),
(15, 'Óscar', 'Castillo', 'Navarro', 'prof15@escuela.edu', '22200015', 1, NOW(), NOW()),
(16, 'Patricia', 'Herrera', 'Salazar', 'prof16@escuela.edu', '22200016', 28, NOW(), NOW()),
(17, 'Quintín', 'Mora', 'Campos', 'prof17@escuela.edu', '22200017', 22, NOW(), NOW()),
(18, 'Raquel', 'Chávez', 'Vega', 'prof18@escuela.edu', '22200018', 18, NOW(), NOW()),
(19, 'Sergio', 'León', 'Medina', 'prof19@escuela.edu', '22200019', 14, NOW(), NOW()),
(20, 'Tania', 'Pineda', 'Guzmán', 'prof20@escuela.edu', '22200020', 26, NOW(), NOW()),
(21, 'Ulises', 'Rangel', 'Cabrera', 'prof21@escuela.edu', '22200021', 2, NOW(), NOW()),
(22, 'Verónica', 'Juárez', 'Osorio', 'prof22@escuela.edu', '22200022', 30, NOW(), NOW()),
(23, 'Walter', 'Domínguez', 'Delgado', 'prof23@escuela.edu', '22200023', 10, NOW(), NOW()),
(24, 'Ximena', 'Ríos', 'Ibarra', 'prof24@escuela.edu', '22200024', 2, NOW(), NOW()),
(25, 'Yael', 'Montes', 'Ponce', 'prof25@escuela.edu', '22200025', 3, NOW(), NOW()),
(26, 'Zoe', 'Solís', 'Padilla', 'prof26@escuela.edu', '22200026', 16, NOW(), NOW()),
(27, 'Adrián', 'Cervantes', 'Lara', 'prof27@escuela.edu', '22200027', 24, NOW(), NOW()),
(28, 'Brenda', 'Figueroa', 'Meza', 'prof28@escuela.edu', '22200028', 7, NOW(), NOW()),
(29, 'César', 'Miranda', 'Álvarez', 'prof29@escuela.edu', '22200029', 8, NOW(), NOW()),
(30, 'Daniela', 'Aguilar', 'Sandoval', 'prof30@escuela.edu', '22200030', 37, NOW(), NOW()),
(31, 'Eduardo', 'Benítez', 'Valencia', 'prof31@escuela.edu', '22200031', 9, NOW(), NOW()),
(32, 'Fernanda', 'Castro', 'Blanco', 'prof32@escuela.edu', '22200032', 25, NOW(), NOW()),
(33, 'Gustavo', 'Rosas', 'Estrella', 'prof33@escuela.edu', '22200033', 2, NOW(), NOW()),
(34, 'Isabel', 'Zavala', 'Márquez', 'prof34@escuela.edu', '22200034', 20, NOW(), NOW()),
(35, 'Javier', 'Paredes', 'Cortés', 'prof35@escuela.edu', '22200035', 6, NOW(), NOW()),
(36, 'Karla', 'Gallardo', 'Ochoa', 'prof36@escuela.edu', '22200036', 15, NOW(), NOW()),
(37, 'Luis', 'Bravo', 'Villalobos', 'prof37@escuela.edu', '22200037', 19, NOW(), NOW()),
(38, 'Mónica', 'Escobar', 'Galindo', 'prof38@escuela.edu', '22200038', 34, NOW(), NOW()),
(39, 'Natalia', 'Fuentes', 'Roldán', 'prof39@escuela.edu', '22200039', 38, NOW(), NOW()),
(40, 'Omar', 'Cano', 'Ortega', 'prof40@escuela.edu', '22200040', 40, NOW(), NOW());

-- ===================================================
-- Tabla: materias
-- ===================================================
INSERT INTO `materias` (`id`, `nombre`, `creditos`, `semestre_optimo`, `carrera_id`, `prerequisito_id`, `created_at`, `updated_at`) VALUES
(1, 'Cálculo Diferencial', 8, 1, 1, NULL, NOW(), NOW()),
(2, 'Fundamentos de Programación', 8, 1, 1, NULL, NOW(), NOW()),
(3, 'Contabilidad Básica', 8, 1, 2, NULL, NOW(), NOW()),
(4, 'Introducción al Derecho', 8, 1, 3, NULL, NOW(), NOW()),
(5, 'Anatomía Humana I', 10, 1, 4, NULL, NOW(), NOW()),
(6, 'Dibujo Arquitectónico', 6, 1, 5, NULL, NOW(), NOW()),
(7, 'Psicología General', 8, 1, 6, NULL, NOW(), NOW()),
(8, 'Álgebra Lineal', 8, 2, 7, NULL, NOW(), NOW()),
(9, 'Teoría del Color', 6, 1, 8, NULL, NOW(), NOW()),
(10, 'Microeconomía', 8, 2, 9, NULL, NOW(), NOW()),
(11, 'Estática', 8, 2, 10, NULL, NOW(), NOW()),
(12, 'Bases de la Nutrición', 8, 1, 11, NULL, NOW(), NOW()),
(13, 'Teorías de la Comunicación', 8, 1, 12, NULL, NOW(), NOW()),
(14, 'Química Orgánica I', 8, 2, 13, NULL, NOW(), NOW()),
(15, 'Introducción a la Gastronomía', 6, 1, 14, NULL, NOW(), NOW()),
(16, 'Probabilidad y Estadística', 8, 2, 15, 1, NOW(), NOW()),
(17, 'Derecho Internacional Público', 8, 3, 16, NULL, NOW(), NOW()),
(18, 'Biología Molecular', 10, 3, 17, NULL, NOW(), NOW()),
(19, 'Historia de la Filosofía Antigua', 8, 1, 18, NULL, NOW(), NOW()),
(20, 'Fundamentos de Mercadotecnia', 8, 1, 20, NULL, NOW(), NOW()),
(21, 'Cálculo Integral', 8, 2, 1, 1, NOW(), NOW()),
(22, 'Programación Orientada a Objetos', 8, 2, 1, 2, NOW(), NOW()),
(23, 'Contabilidad de Costos', 8, 2, 2, 3, NOW(), NOW()),
(24, 'Derecho Romano', 8, 2, 3, 4, NOW(), NOW()),
(25, 'Anatomía Humana II', 10, 2, 4, 5, NOW(), NOW()),
(26, 'Geometría Descriptiva', 6, 2, 5, 6, NOW(), NOW()),
(27, 'Psicología del Desarrollo', 8, 2, 6, 7, NOW(), NOW()),
(28, 'Circuitos Eléctricos', 8, 3, 7, 8, NOW(), NOW()),
(29, 'Tipografía', 6, 2, 8, 9, NOW(), NOW()),
(30, 'Macroeconomía', 8, 3, 9, 10, NOW(), NOW()),
(31, 'Dinámica', 8, 3, 10, 11, NOW(), NOW()),
(32, 'Evaluación del Estado Nutricional', 8, 2, 11, 12, NOW(), NOW()),
(33, 'Comunicación Organizacional', 8, 2, 12, 13, NOW(), NOW()),
(34, 'Química Orgánica II', 8, 3, 13, 14, NOW(), NOW()),
(35, 'Técnicas Culinarias', 6, 2, 14, 15, NOW(), NOW()),
(36, 'Inferencia Estadística', 8, 3, 15, 16, NOW(), NOW()),
(37, 'Bases de Datos', 8, 3, 1, 22, NOW(), NOW()),
(38, 'Estructuras de Datos', 8, 3, 1, 22, NOW(), NOW()),
(39, 'Derecho Constitucional', 8, 3, 3, 24, NOW(), NOW()),
(40, 'Fisiología', 10, 3, 4, 25, NOW(), NOW());

-- ===================================================
-- Tabla: alumnos
-- ===================================================
INSERT INTO `alumnos` (`matricula`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `carrera_id`, `semestre_actual`, `es_egresado`, `created_at`, `updated_at`) VALUES
('A001', 'Ana', 'García', 'López', 'a001@escuela.mx', '22210001', 1, 3, 0, NOW(), NOW()),
('A002', 'Bruno', 'Hernández', 'Martínez', 'a002@escuela.mx', '22210002', 2, 5, 0, NOW(), NOW()),
('A003', 'Carla', 'Rodríguez', 'Pérez', 'a003@escuela.mx', '22210003', 3, 7, 0, NOW(), NOW()),
('A004', 'David', 'Fernández', 'Gómez', 'a004@escuela.mx', '22210004', 4, 9, 0, NOW(), NOW()),
('A005', 'Elena', 'Díaz', 'Sánchez', 'a005@escuela.mx', '22210005', 5, 1, 0, NOW(), NOW()),
('A006', 'Fernando', 'Moreno', 'González', 'a006@escuela.mx', '22210006', 6, 3, 0, NOW(), NOW()),
('A007', 'Gabriela', 'Jiménez', 'Cruz', 'a007@escuela.mx', '22210007', 7, 5, 0, NOW(), NOW()),
('A008', 'Hugo', 'Ruiz', 'Flores', 'a008@escuela.mx', '22210008', 8, 7, 0, NOW(), NOW()),
('A009', 'Irene', 'Torres', 'Vázquez', 'a009@escuela.mx', '22210009', 9, 9, 0, NOW(), NOW()),
('A010', 'Jorge', 'Rojas', 'Mendoza', 'a010@escuela.mx', '22210010', 10, 2, 0, NOW(), NOW()),
('A011', 'Karen', 'Soto', 'Silva', 'a011@escuela.mx', '22210011', 11, 4, 0, NOW(), NOW()),
('A012', 'Leonardo', 'Reyes', 'Ortiz', 'a012@escuela.mx', '22210012', 12, 6, 0, NOW(), NOW()),
('A013', 'Marcela', 'Acosta', 'Guerrero', 'a013@escuela.mx', '22210013', 13, 8, 0, NOW(), NOW()),
('A014', 'Nicolás', 'Navarro', 'Luna', 'a014@escuela.mx', '22210014', 14, 1, 0, NOW(), NOW()),
('A015', 'Olivia', 'Salazar', 'Castillo', 'a015@escuela.mx', '22210015', 15, 3, 0, NOW(), NOW()),
('A016', 'Pablo', 'Campos', 'Herrera', 'a016@escuela.mx', '22210016', 16, 5, 0, NOW(), NOW()),
('A017', 'Quetzalli', 'Vega', 'Mora', 'a017@escuela.mx', '22210017', 17, 7, 0, NOW(), NOW()),
('A018', 'Ricardo', 'Medina', 'Chávez', 'a018@escuela.mx', '22210018', 18, 9, 0, NOW(), NOW()),
('A019', 'Sofía', 'Guzmán', 'León', 'a019@escuela.mx', '22210019', 19, 2, 0, NOW(), NOW()),
('A020', 'Tomás', 'Cabrera', 'Pineda', 'a020@escuela.mx', '22210020', 20, 4, 0, NOW(), NOW()),
('A021', 'Úrsula', 'Osorio', 'Rangel', 'a021@escuela.mx', '22210021', 21, 6, 0, NOW(), NOW()),
('A022', 'Víctor', 'Delgado', 'Juárez', 'a022@escuela.mx', '22210022', 22, 8, 0, NOW(), NOW()),
('A023', 'Wendy', 'Ibarra', 'Domínguez', 'a023@escuela.mx', '22210023', 23, 1, 0, NOW(), NOW()),
('A024', 'Xavier', 'Ponce', 'Ríos', 'a024@escuela.mx', '22210024', 24, 3, 0, NOW(), NOW()),
('A025', 'Yara', 'Padilla', 'Montes', 'a025@escuela.mx', '22210025', 25, 5, 0, NOW(), NOW()),
('A026', 'Zacarías', 'Lara', 'Solís', 'a026@escuela.mx', '22210026', 26, 7, 0, NOW(), NOW()),
('A027', 'Alicia', 'Meza', 'Cervantes', 'a027@escuela.mx', '22210027', 27, 9, 0, NOW(), NOW()),
('A028', 'Benjamín', 'Álvarez', 'Figueroa', 'a028@escuela.mx', '22210028', 28, 2, 0, NOW(), NOW()),
('A029', 'Clara', 'Sandoval', 'Miranda', 'a029@escuela.mx', '22210029', 29, 4, 0, NOW(), NOW()),
('A030', 'Diego', 'Valencia', 'Aguilar', 'a030@escuela.mx', '22210030', 30, 6, 0, NOW(), NOW()),
('A031', 'Estela', 'Blanco', 'Benítez', 'a031@escuela.mx', '22210031', 31, 8, 0, NOW(), NOW()),
('A032', 'Felipe', 'Estrella', 'Castro', 'a032@escuela.mx', '22210032', 32, 1, 0, NOW(), NOW()),
('A033', 'Gloria', 'Márquez', 'Rosas', 'a033@escuela.mx', '22210033', 33, 3, 0, NOW(), NOW()),
('A034', 'Héctor', 'Cortés', 'Zavala', 'a034@escuela.mx', '22210034', 34, 5, 0, NOW(), NOW()),
('A035', 'Ismael', 'Ochoa', 'Paredes', 'a035@escuela.mx', '22210035', 35, 7, 0, NOW(), NOW()),
('A036', 'Javier', 'Villalobos', 'Gallardo', 'a036@escuela.mx', '22210036', 36, 9, 1, NULL, NOW()),
('A037', 'Lorena', 'Galindo', 'Bravo', 'a037@escuela.mx', '22210037', 37, 2, 0, NOW(), NOW()),
('A038', 'Manuel', 'Roldán', 'Escobar', 'a038@escuela.mx', '22210038', 38, 4, 0, NOW(), NOW()),
('A039', 'Nancy', 'Ortega', 'Fuentes', 'a039@escuela.mx', '22210039', 39, 6, 0, NOW(), NOW()),
('A040', 'Óliver', 'Vargas', 'Cano', 'a040@escuela.mx', '22210040', 40, 8, 1, NULL, NOW());

-- ===================================================
-- Tabla: grupos
-- ===================================================
INSERT INTO `grupos` (`id`, `nombre`, `materia_id`, `profesor_id`, `created_at`, `updated_at`) VALUES
(1, '101A', 1, 15, NOW(), NOW()),
(2, '101B', 2, 1, NOW(), NOW()),
(3, '202A', 3, 2, NOW(), NOW()),
(4, '301A', 4, 3, NOW(), NOW()),
(5, '401A', 5, 4, NOW(), NOW()),
(6, '501A', 6, 5, NOW(), NOW()),
(7, '601A', 7, 6, NOW(), NOW()),
(8, '701A', 8, 7, NOW(), NOW()),
(9, '801A', 9, 8, NOW(), NOW()),
(10, '901A', 10, 9, NOW(), NOW()),
(11, '1001A', 11, 10, NOW(), NOW()),
(12, '1101A', 12, 11, NOW(), NOW()),
(13, '1201A', 13, 12, NOW(), NOW()),
(14, '1301A', 14, 13, NOW(), NOW()),
(15, '1401A', 15, 14, NOW(), NOW()),
(16, '1501A', 16, 15, NOW(), NOW()),
(17, '1601A', 17, 16, NOW(), NOW()),
(18, '1701A', 18, 17, NOW(), NOW()),
(19, '1801A', 19, 18, NOW(), NOW()),
(20, '2001A', 20, 20, NOW(), NOW()),
(21, '102A', 21, 15, NOW(), NOW()),
(22, '102B', 22, 1, NOW(), NOW()),
(23, '203A', 23, 2, NOW(), NOW()),
(24, '302A', 24, 3, NOW(), NOW()),
(25, '402A', 25, 4, NOW(), NOW()),
(26, '502A', 26, 5, NOW(), NOW()),
(27, '602A', 27, 6, NOW(), NOW()),
(28, '702A', 28, 7, NOW(), NOW()),
(29, '802A', 29, 8, NOW(), NOW()),
(30, '902A', 30, 9, NOW(), NOW()),
(31, '1002A', 31, 10, NOW(), NOW()),
(32, '1102A', 32, 11, NOW(), NOW()),
(33, '1202A', 33, 12, NOW(), NOW()),
(34, '1302A', 34, 13, NOW(), NOW()),
(35, '1402A', 35, 14, NOW(), NOW()),
(36, '1502A', 36, 15, NOW(), NOW()),
(37, '103A', 37, 1, NOW(), NOW()),
(38, '103B', 38, 31, NOW(), NOW()),
(39, '303A', 39, 3, NOW(), NOW()),
(40, '403A', 40, 4, NOW(), NOW());

-- ===================================================
-- Tabla: historiales
-- ===================================================
INSERT INTO `historiales` (`id`, `alumno_matricula`, `materia_id`, `calificacion`, `semestre`, `año`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'A001', 1, 9.50, 1, 2024, 'Ordinario', NOW(), NOW()),
(2, 'A001', 2, 10.00, 1, 2024, 'Ordinario', NOW(), NOW()),
(3, 'A002', 3, 8.00, 1, 2023, 'Ordinario', NOW(), NOW()),
(4, 'A003', 4, 7.50, 1, 2022, 'Ordinario', NOW(), NOW()),
(5, 'A004', 5, 9.00, 1, 2021, 'Ordinario', NOW(), NOW()),
(6, 'A005', 6, 8.80, 1, 2025, 'Ordinario', NOW(), NOW()),
(7, 'A006', 7, 9.20, 1, 2024, 'Ordinario', NOW(), NOW()),
(8, 'A007', 8, 10.00, 2, 2023, 'Ordinario', NOW(), NOW()),
(9, 'A008', 9, 6.50, 1, 2022, 'Extraordinario', NOW(), NOW()),
(10, 'A009', 10, 8.50, 2, 2021, 'Ordinario', NOW(), NOW()),
(11, 'A010', 11, 9.70, 2, 2025, 'Ordinario', NOW(), NOW()),
(12, 'A011', 12, 8.10, 1, 2024, 'Ordinario', NOW(), NOW()),
(13, 'A012', 13, 7.90, 1, 2023, 'Ordinario', NOW(), NOW()),
(14, 'A013', 14, 9.40, 2, 2022, 'Ordinario', NOW(), NOW()),
(15, 'A014', 15, 8.60, 1, 2025, 'Ordinario', NOW(), NOW()),
(16, 'A015', 16, 9.90, 2, 2024, 'Ordinario', NOW(), NOW()),
(17, 'A016', 17, 7.00, 3, 2023, 'Ordinario', NOW(), NOW()),
(18, 'A017', 18, 10.00, 3, 2022, 'Ordinario', NOW(), NOW()),
(19, 'A018', 19, 8.30, 1, 2021, 'Ordinario', NOW(), NOW()),
(20, 'A019', 1, 9.00, 1, 2025, 'Ordinario', NOW(), NOW()),
(21, 'A001', 21, 8.50, 2, 2025, 'Ordinario', NOW(), NOW()),
(22, 'A001', 22, 9.80, 2, 2025, 'Ordinario', NOW(), NOW()),
(23, 'A002', 23, 7.20, 2, 2023, 'Extraordinario', NOW(), NOW()),
(24, 'A003', 24, 8.80, 2, 2022, 'Ordinario', NOW(), NOW()),
(25, 'A004', 25, 9.10, 2, 2021, 'Ordinario', NOW(), NOW()),
(26, 'A005', 26, 8.40, 2, 2025, 'Ordinario', NOW(), NOW()),
(27, 'A006', 27, 9.30, 2, 2024, 'Ordinario', NOW(), NOW()),
(28, 'A007', 28, 9.90, 3, 2023, 'Ordinario', NOW(), NOW()),
(29, 'A008', 29, 7.70, 2, 2022, 'Ordinario', NOW(), NOW()),
(30, 'A009', 30, 8.90, 3, 2021, 'Ordinario', NOW(), NOW()),
(31, 'A010', 31, 9.60, 3, 2025, 'Ordinario', NOW(), NOW()),
(32, 'A011', 32, 8.00, 2, 2024, 'Ordinario', NOW(), NOW()),
(33, 'A012', 33, 7.80, 2, 2023, 'Ordinario', NOW(), NOW()),
(34, 'A013', 34, 9.50, 3, 2022, 'Ordinario', NOW(), NOW()),
(35, 'A014', 35, 8.20, 2, 2025, 'Ordinario', NOW(), NOW()),
(36, 'A036', 1, 10.00, 1, 2020, 'Ordinario', NOW(), NOW()),
(37, 'A036', 2, 10.00, 1, 2020, 'Ordinario', NOW(), NOW()),
(38, 'A040', 6, 9.00, 1, 2021, 'Ordinario', NOW(), NOW()),
(39, 'A040', 26, 9.50, 2, 2022, 'Ordinario', NOW(), NOW()),
(40, 'A020', 20, 8.5, 1, 2024, 'Ordinario', NOW(), NOW());

-- ===================================================
-- Tabla: paquete_materias (Pivote)
-- ===================================================
INSERT INTO `paquete_materias` (`paquete_id`, `materia_id`) VALUES
(1, 1), (1, 21), (1, 8), (1, 16),
(2, 2), (2, 22), (2, 37), (2, 38),
(3, 3), (3, 10), (3, 23), (3, 30),
(4, 4), (4, 19), (4, 24), (4, 39),
(5, 5), (5, 12), (5, 25), (5, 32),
(6, 11), (6, 31),
(7, 37), (7, 38),
(8, 20),
(9, 6), (9, 9), (9, 26), (9, 29),
(10, 4), (10, 39),
(11, 18),
(12, 38),
(13, 10), (13, 30),
(14, 19), (14, 24),
(15, 5), (15, 25), (15, 40),
(16, 8),
(17, 2),
(18, 20),
(19, 9), (19, 29),
(20, 4), (20, 39);

-- ===================================================
-- Tabla: materia_profesores (Pivote)
-- ===================================================
INSERT INTO `materia_profesores` (`profesor_id`, `materia_id`) VALUES
(1, 2), (1, 22), (1, 37), (1, 38),
(2, 3), (2, 23),
(3, 4), (3, 24), (3, 39),
(4, 5), (4, 25), (4, 40),
(5, 6), (5, 26),
(6, 7), (6, 27),
(7, 8), (7, 28),
(8, 9), (8, 29),
(9, 10), (9, 30),
(10, 11), (10, 31),
(11, 12), (11, 32),
(12, 13), (12, 33),
(13, 14), (13, 34),
(14, 15), (14, 35),
(15, 1), (15, 16), (15, 21), (15, 36),
(16, 17),
(17, 18),
(18, 19),
(20, 20),
(31, 2), (31, 22),
(19, 1),
(21, 8),
(22, 5),
(23, 4),
(24, 11),
(25, 19),
(26, 17),
(27, 15),
(28, 8);
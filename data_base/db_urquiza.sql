-- Creación de la base de datos y selección de la misma
CREATE DATABASE IF NOT EXISTS db_urquiza;
USE db_urquiza;

CREATE TABLE Alumnos (
    ID_Alumno INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(45) NOT NULL,
    Apellido VARCHAR(45) NOT NULL,
    DNI INT NOT NULL,
    Mail VARCHAR(45),
    Domicilio VARCHAR(45)
);

CREATE TABLE Docentes (
    ID_Docente INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(45) NOT NULL,
    Apellido VARCHAR(45) NOT NULL,
    Legajo VARCHAR(45) NOT NULL,
    Mail VARCHAR(45),
    Domicilio VARCHAR(45)
);

CREATE TABLE Bedeles (
    ID_Bedel INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(45) NOT NULL,
    Apellido VARCHAR(45) NOT NULL,
    Legajo VARCHAR(45) NOT NULL,
    Telefono VARCHAR(45),
    Domicilio VARCHAR(45)
);

CREATE TABLE Carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE Materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrera_id INT,
    nombre VARCHAR(100) NOT NULL,
    anio INT NOT NULL,
    FOREIGN KEY (carrera_id) REFERENCES Carreras(id)
);

CREATE TABLE Comisiones (
    ID_Comision INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(45) NOT NULL
);

CREATE TABLE MateriasProfesores (
    ID_Materia INT,
    ID_Profesor INT,
    PRIMARY KEY (ID_Materia, ID_Profesor),
    FOREIGN KEY (ID_Materia) REFERENCES Materias(id),  -- Asegúrate de usar 'id'
    FOREIGN KEY (ID_Profesor) REFERENCES Docentes(ID_Docente)
);

CREATE TABLE MateriasComisiones (
    ID_Materia INT,
    ID_Comision INT,
    CantidadHoras INT,
    PRIMARY KEY (ID_Materia, ID_Comision),
    FOREIGN KEY (ID_Materia) REFERENCES Materias(id),  -- Asegúrate de usar 'id'
    FOREIGN KEY (ID_Comision) REFERENCES Comisiones(ID_Comision)
);

CREATE TABLE AlumnosMaterias (
    ID_Alumno INT,
    ID_Materia INT,
    PRIMARY KEY (ID_Alumno, ID_Materia),
    FOREIGN KEY (ID_Alumno) REFERENCES Alumnos(ID_Alumno),
    FOREIGN KEY (ID_Materia) REFERENCES Materias(id)  -- Asegúrate de usar 'id'
);

CREATE TABLE Mesas (
    ID_Mesa INT PRIMARY KEY AUTO_INCREMENT,
    FechaMesa DATE NOT NULL
);

CREATE TABLE MesasMaterias (
    ID_Mesa INT,
    ID_Materia INT,
    PRIMARY KEY (ID_Mesa, ID_Materia),
    FOREIGN KEY (ID_Mesa) REFERENCES Mesas(ID_Mesa),
    FOREIGN KEY (ID_Materia) REFERENCES Materias(id)  -- Asegúrate de usar 'id'
);

CREATE TABLE MesasProfesores (
    ID_Mesa INT,
    ID_Profesor INT,
    PRIMARY KEY (ID_Mesa, ID_Profesor),
    FOREIGN KEY (ID_Mesa) REFERENCES Mesas(ID_Mesa),
    FOREIGN KEY (ID_Profesor) REFERENCES Docentes(ID_Docente)
);

CREATE TABLE MesasAlumnosMaterias (
    ID_Mesa INT,
    ID_Alumno INT,
    ID_Materia INT,
    PRIMARY KEY (ID_Mesa, ID_Alumno, ID_Materia),
    FOREIGN KEY (ID_Mesa) REFERENCES Mesas(ID_Mesa),
    FOREIGN KEY (ID_Alumno) REFERENCES Alumnos(ID_Alumno),
    FOREIGN KEY (ID_Materia) REFERENCES Materias(id)  -- Asegúrate de usar 'id'
);

CREATE TABLE inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    carrera_id INT,
    materia_id INT,
    FOREIGN KEY (carrera_id) REFERENCES Carreras(id),
    FOREIGN KEY (materia_id) REFERENCES Materias(id)  -- Asegúrate de usar 'id'
);



INSERT INTO carreras (nombre) VALUES 
    ('Analista Funcional'), 
    ('Desarrollador de Software'), 
    ('Infraestructura en Tecnologia de la Información');
    
    INSERT INTO materias (carrera_id, nombre, anio) VALUES    
    -- Materias de Analista Funcional
    -- Primer año
    (1, 'Comunicación 1', 1),
    (1, 'UDI 1', 1),
    (1, 'Matemática', 1),
    (1, 'Inglés Técnico 1', 1),
    (1, 'Psicosociología de las Organizaciones', 1), 
    (1, 'Modelos de Negocios', 1),
    (1, 'Arquitectura de las Computadoras', 1), 
    (1, 'Gestión de Software', 1), 
    (1, 'Análisis de Sistemas Organizacionales', 1),
    -- Segundo año
    (1, 'Problemáticas Socio Contemporáneas', 2),
    (1, 'UDI 2', 2),
    (1, 'Inglés Técnico 2', 2), 
    (1, 'Estadística', 2),
    (1, 'Innovación y Desarrollo Emprendedor', 2),
    (1, 'Gestión de Software 2', 2),
    (1, 'Estrategias de Negocios', 2),
    (1, 'Desarrollo de Sistemas', 2),
    (1, 'Práctica Profesionalizante 1', 2),
    -- Tercer año
    (1, 'Ética y Responsabilidad Social', 3),
    (1, 'Derecho y Legislación Laboral', 3),
    (1, 'Redes y Comunicaciones', 3),
    (1, 'Seguridad de los Sistemas', 3),
    (1, 'Bases de Datos', 3),
    (1, 'Sistema de Información Organizacional', 3),
    (1, 'Desarrollo de Sistemas Web', 3),
    (1, 'Práctica Profesionalizante 2', 3),
    -- Materias de Desarrollo de Software
    -- Primer año
    (2, 'Comunicación 1', 1),
    (2, 'UDI 1', 1),
    (2, 'Matemática', 1),
    (2, 'Inglés Técnico 1', 1),
    (2, 'Administración', 1),
    (2, 'Tecnología de la Información', 1),
    (2, 'Lógica y Estructura de Datos', 1),
    (2, 'Ingeniería de Software 1', 1),
    (2, 'Sistemas Operativos', 1),
    -- Segundo año
    (2, 'Problemáticas Socio Contemporáneas', 2),
    (2, 'UDI 2', 2),
    (2, 'Inglés Técnico 2', 2), 
    (2, 'Estadística', 2),
    (2, 'Innovación y Desarrollo Emprendedor', 2),
    (2, 'Ingenieria de Software 2', 2),
    (2, 'Programación 1', 2),
    (2, 'Bases de Datos 1', 2),
    (2, 'Práctica Profesionalizante 1', 2),
    -- Tercer año
    (2, 'Ética y Responsabilidad Social', 3),
    (2, 'Derecho y Legislación Laboral', 3),
    (2, 'Redes y Comunicaciones', 3),
    (2, 'Bases de Datos 2', 3),
    (2, 'Programación 2', 3),
    (2, 'Gestión de Proyectos de Software', 3),
    (2, 'Práctica Profesionalizante 2', 3),
    -- Materias de Infraestructura en Tecnología de la Información
    -- Primer año
    (3, 'Comunicación 1', 1),
    (3, 'UDI 1', 1),
    (3, 'Matemática', 1),
    (3, 'Inglés Técnico', 1),
    (3, 'Administración', 1),
    (3, 'Física Aplicada a las Tecnologías de la Información', 1),
    (3, 'Arquitectura de las Computadoras', 1),
    (3, 'Lógica y Programación', 1),
    (3, 'Infraestructura de Redes 1', 1),
    -- Segundo año
    (3, 'Problemáticas Socio Contemporáneas', 2),
    (3, 'UDI 2', 2),
    (3, 'Estadística', 2),
    (3, 'Innovación y Desarrollo Emprendedor', 2),
    (3, 'Sistemas Operativos', 2),
    (3, 'Bases de Datos', 2),
    (3, 'Algoritmos y Estructura de Datos', 2),
    (3, 'Infraestructura de Redes 2', 2),
    (3, 'Práctica Profesionalizante 1', 2),
    -- Tercer año
    (3, 'Ética y Responsabilidad Social', 3),
    (3, 'Derecho y Legislación Laboral', 3),
    (3, 'Administración de Bases de Datos', 3),
    (3, 'Seguridad de los Sistemas', 3),
    (3, 'Integridad y Migración de Datos', 3),
    (3, 'Administración de Sistemas Operativos y Redes', 3),
    (3, 'Práctica Profesionalizante 2', 3);
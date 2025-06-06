
-- Crear tabla de médicos
CREATE TABLE medico (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL,
    imagen TEXT,
    contacto TEXT,
    email TEXT
);

-- Crear tabla de clínicas
CREATE TABLE clinica (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL
);

-- Crear tabla de especialidades
CREATE TABLE especialidad (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL
);

-- Crear tabla de procedimientos
CREATE TABLE procedimiento (
    id INTEGER PRIMARY KEY,
    nombre TEXT NOT NULL
);

-- Relación N:M entre médicos y clínicas
CREATE TABLE medico_clinica (
    medico_id INTEGER,
    clinica_id INTEGER,
    FOREIGN KEY (medico_id) REFERENCES medico(id),
    FOREIGN KEY (clinica_id) REFERENCES clinica(id)
);

-- Relación N:M entre médicos y especialidades
CREATE TABLE medico_especialidad (
    medico_id INTEGER,
    especialidad_id INTEGER,
    FOREIGN KEY (medico_id) REFERENCES medico(id),
    FOREIGN KEY (especialidad_id) REFERENCES especialidad(id)
);

-- Relación N:M entre médicos y procedimientos
CREATE TABLE medico_procedimiento (
    medico_id INTEGER,
    procedimiento_id INTEGER,
    FOREIGN KEY (medico_id) REFERENCES medico(id),
    FOREIGN KEY (procedimiento_id) REFERENCES procedimiento(id)
);

CREATE TABLE especialidad_area (
  id_especialidad INTEGER,
  id_area INTEGER,
  FOREIGN KEY(id_especialidad) REFERENCES especialidad(id),
  FOREIGN KEY(id_area) REFERENCES area(id)
);


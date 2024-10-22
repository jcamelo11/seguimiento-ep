-- Tabla programa_formacion
CREATE TABLE programa_formacion (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre_programa VARCHAR(255),
  ficha VARCHAR(255) UNIQUE,
  nivel_formacion VARCHAR(255),
  modalidad VARCHAR(255),
  municipio_ficha VARCHAR(255),
  lider_programa VARCHAR(255),
  fecha_final DATE,
  pruebas_tyt VARCHAR(255)
);

-- Tabla aprendiz
CREATE TABLE aprendiz (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  tipo_documento VARCHAR(255),
  numero_documento VARCHAR(255) UNIQUE,
  nombres VARCHAR(255),
  apellidos VARCHAR(255),
  celular1 VARCHAR(20),
  celular2 VARCHAR(20),
  correo_personal VARCHAR(255),
  correo_institucional VARCHAR(255),
  estado VARCHAR(255),
  genero VARCHAR(255),
  programa_formacion_id BIGINT,
  FOREIGN KEY (programa_formacion_id) REFERENCES programa_formacion(id)
);


-- Tabla instructor_seguimiento
CREATE TABLE instructor_seguimiento (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255),
  apellidos VARCHAR(255),
  telefono VARCHAR(20),
  correo VARCHAR(255),
  profesion VARCHAR(255),
  area VARCHAR(255)
);

-- Tabla etapa_productiva
CREATE TABLE etapa_productiva (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  aprendiz_id BIGINT,
  modalidad_etapa VARCHAR(255),
  fecha_inicio DATE,
  fecha_final DATE,
  fecha_final_prorroga DATE,
  empresa VARCHAR(255),
  ciudad_practica VARCHAR(255),
  estado_etapa_productiva VARCHAR(255),
  etapa_de_la_practica VARCHAR(255),
  patrocinio VARCHAR(255),
  FOREIGN KEY (aprendiz_id) REFERENCES aprendiz(id)
);

-- Tabla seguimiento
CREATE TABLE seguimiento (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  aprendiz_id BIGINT,
  instructor_id BIGINT,
  fecha_asignacion DATE,
  estado VARCHAR(255),
  FOREIGN KEY (aprendiz_id) REFERENCES aprendiz(id),
  FOREIGN KEY (instructor_id) REFERENCES instructor_seguimiento(id)
);

-- Tabla informes_seguimiento
CREATE TABLE informes_seguimiento (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  seguimiento_id BIGINT,
  nombre VARCHAR(255),
  fecha_inicio DATE,
  fecha_entrega DATE,
  observaciones TEXT,
  FOREIGN KEY (seguimiento_id) REFERENCES seguimiento(id)
);

-- Tabla aval
CREATE TABLE aval (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  seguimiento_id BIGINT,
  fecha DATE,
  observaciones TEXT,
  FOREIGN KEY (seguimiento_id) REFERENCES seguimiento(id)
);

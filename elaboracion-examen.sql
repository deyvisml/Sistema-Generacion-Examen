CREATE DATABASE elaboracion_examen;

USE elaboracion_examen;

CREATE TABLE usuarios(
    id_usuario INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(256),
    password VARCHAR(256),
    nombre VARCHAR(256),
    apellidos VARCHAR(256),
    telefono VARCHAR(32),
    creado TIMESTAMP,
    PRIMARY KEY(id_usuario)
);

CREATE TABLE procesos_admision(
    id_proceso_admision INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(256),
    areas_configuradas BOOL,
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_proceso_admision),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE areas(
    id_area INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(256),
    scope INT,
    participa BOOL,
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_area),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE pa_areas(
    id_proceso_admision INT NOT NULL,
    id_area INT NOT NULL,
    materias_configuradas BOOL,
    n_tipos_examenes INT,
    examenes_generados BOOL,
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_proceso_admision, id_area),
    FOREIGN KEY(id_proceso_admision) REFERENCES procesos_admision(id_proceso_admision),
    FOREIGN KEY(id_area) REFERENCES areas(id_area),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE materias(
    id_materia INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(256),
    scope INT,
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_materia),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE areas_materias(
    id_area INT NOT NULL,
    id_materia INT NOT NULL,
    n_orden INT,
    n_preguntas INT,
    puntaje_pregunta FLOAT,
    participa BOOL,
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_area, id_materia),
    FOREIGN KEY(id_area) REFERENCES areas(id_area),
    FOREIGN KEY(id_materia) REFERENCES materias(id_materia),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE pa_areas_materias(
    id_proceso_admision INT NOT NULL,
    id_area INT NOT NULL,
    id_materia INT NOT NULL,
    n_orden INT,
    n_preguntas INT,
    puntaje_pregunta FLOAT,
    preguntas_guardadas BOOL,
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_proceso_admision, id_area, id_materia),
    FOREIGN KEY(id_proceso_admision, id_area) REFERENCES pa_areas(id_proceso_admision, id_area),
    FOREIGN KEY(id_materia) REFERENCES materias(id_materia),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE examenes(
    id_proceso_admision INT NOT NULL,
    id_area INT NOT NULL,
    tipo_examen CHAR(1),
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_proceso_admision, id_area, tipo_examen),
    FOREIGN KEY(id_proceso_admision, id_area) REFERENCES pa_areas(id_proceso_admision, id_area),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE preguntas(
    id_pregunta INT NOT NULL AUTO_INCREMENT,
    pregunta TEXT,
    n_orden INT,
    creado TIMESTAMP,
    creador INT,
    id_proceso_admision INT NOT NULL,
    id_area INT NOT NULL,
    id_materia INT NOT NULL,
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario),
    PRIMARY KEY(id_pregunta),
    FOREIGN KEY(id_proceso_admision, id_area, id_materia) REFERENCES pa_areas_materias(id_proceso_admision, id_area, id_materia) 
);

CREATE TABLE examenes_preguntas(
    id_proceso_admision INT NOT NULL,
    id_area INT NOT NULL,
    tipo_examen CHAR(1) NOT NULL,
    id_pregunta INT NOT NULL,
    n_orden_general INT,
    letra_respuesta CHAR(1),
    creado TIMESTAMP,
    creador INT,
    PRIMARY KEY(id_proceso_admision, id_area, tipo_examen, id_pregunta),
    FOREIGN KEY(id_proceso_admision, id_area, tipo_examen) REFERENCES examenes(id_proceso_admision, id_area, tipo_examen),
    FOREIGN KEY(id_pregunta) REFERENCES preguntas(id_pregunta),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario)
);

CREATE TABLE alternativas(
    id_alternativa INT NOT NULL AUTO_INCREMENT,
    alternativa VARCHAR(256),
    respuesta BOOL,
    creado TIMESTAMP,
    creador INT,
    id_pregunta INT NOT NULL,
    PRIMARY KEY(id_alternativa),
    FOREIGN KEY(creador) REFERENCES usuarios(id_usuario),
    FOREIGN KEY(id_pregunta) REFERENCES preguntas(id_pregunta)
);
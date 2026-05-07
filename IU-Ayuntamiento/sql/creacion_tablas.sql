USE gestion_incidencias;

/*
Tabla roles:
Guarda los tipos de usuarios que tenemos:
- ciudadano: está registrado y puede reportar nuevas incidencias.
- tecnico: gestiona las incidencias desde el panel del ayuntamiento.
En caso de no estar identificado, no se guarda porque no inicia sesión.
*/
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

/*
Tabla usuarios:
Guarda los datos de los usuarios registrados en la web.
Puede haber usuarios ciudadanos y usuarios técnicos.
El campo rol_id indica qué permisos tiene cada usuario.
*/
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    activo BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

/*
Tabla departamentos:
Representa las áreas del ayuntamiento que se encargan de resolver incidencias.
Nos permite saber a qué departamento hay que enviar cada incidencia.
*/
CREATE TABLE departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    email_contacto VARCHAR(150),
    telefono VARCHAR(20),
    activo BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

/*
Tabla tipos_incidencia:
Guarda las categorías de incidencias que se pueden seleccionar.
Cada tipo de incidencia pertenece a un departamento.
*/
CREATE TABLE tipos_incidencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departamento_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    activo BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (departamento_id) REFERENCES departamentos(id)
);

/*
Tabla estados_incidencia:
Guarda los estados por los que puede pasar una incidencia.
Nos permite hacer seguimiento del aviso desde que se registra hasta que se resuelve.
*/
CREATE TABLE estados_incidencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    color VARCHAR(30),
    orden INT NOT NULL,
    es_final BOOLEAN NOT NULL DEFAULT 0
);

/*
Tabla prioridades:
Guarda el nivel de urgencia de una incidencia.
Sirve para que el técnico pueda distinguir incidencias normales de incidencias urgentes.
*/
CREATE TABLE prioridades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    nivel INT NOT NULL,
    color VARCHAR(30)
);

/*
Tabla barrios:
Guarda las zonas o barrios donde se pueden producir incidencias.
Permite clasificar y filtrar incidencias por ubicación.
*/
CREATE TABLE barrios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    distrito VARCHAR(100),
    codigo_postal VARCHAR(10)
);

/*
Tabla incidencias:
Es la tabla principal del proyecto.
Guarda cada aviso urbano creado por un ciudadano.
Cada incidencia tiene usuario, tipo, estado, prioridad, ubicación y puede tener un técnico asignado.
*/
CREATE TABLE incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,
    tipo_id INT NOT NULL,
    estado_id INT NOT NULL,
    prioridad_id INT NOT NULL,
    barrio_id INT,
    tecnico_asignado_id INT,

    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    codigo_postal VARCHAR(10),
    latitud DECIMAL(10, 7),
    longitud DECIMAL(10, 7),

    fecha_incidencia DATE NOT NULL,
    fecha_resolucion DATE,
    visible_publicamente BOOLEAN NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (tipo_id) REFERENCES tipos_incidencia(id),
    FOREIGN KEY (estado_id) REFERENCES estados_incidencia(id),
    FOREIGN KEY (prioridad_id) REFERENCES prioridades(id),
    FOREIGN KEY (barrio_id) REFERENCES barrios(id),
    FOREIGN KEY (tecnico_asignado_id) REFERENCES usuarios(id)
);

/*
Tabla imagenes_incidencia:
Guarda las imágenes asociadas a una incidencia.
En la base de datos se guarda la ruta del archivo, no la imagen directamente.
Esto permite que una incidencia pueda tener varias fotografías.
*/
CREATE TABLE imagenes_incidencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incidencia_id INT NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    nombre_original VARCHAR(255) NOT NULL,
    tipo_mime VARCHAR(100) NOT NULL,
    tamano INT NOT NULL,
    es_principal BOOLEAN NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (incidencia_id) REFERENCES incidencias(id)
);

/*
Tabla historial_estados:
Guarda todos los cambios de estado de una incidencia.
Permite consultar la evolución completa del aviso.
También registra qué usuario realizó el cambio y un comentario asociado.
*/
CREATE TABLE historial_estados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incidencia_id INT NOT NULL,
    estado_anterior_id INT,
    estado_nuevo_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (incidencia_id) REFERENCES incidencias(id),
    FOREIGN KEY (estado_anterior_id) REFERENCES estados_incidencia(id),
    FOREIGN KEY (estado_nuevo_id) REFERENCES estados_incidencia(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

/*
Tabla comentarios_incidencia:
Guarda comentarios relacionados con una incidencia.
Pueden ser comentarios del ciudadano, respuestas del técnico o notas internas.
*/
CREATE TABLE comentarios_incidencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incidencia_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT NOT NULL,
    tipo ENUM('comentario_usuario', 'comentario_tecnico', 'nota_interna') NOT NULL,
    visible_publicamente BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (incidencia_id) REFERENCES incidencias(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

/*
Tabla notificaciones:
Guarda avisos internos para los usuarios.
Se usa para informar al ciudadano cuando cambia el estado de una incidencia.
*/
CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    incidencia_id INT,
    titulo VARCHAR(150) NOT NULL,
    mensaje TEXT NOT NULL,
    leida BOOLEAN NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (incidencia_id) REFERENCES incidencias(id)
);
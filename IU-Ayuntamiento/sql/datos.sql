USE gestion_incidencias;

/*
Datos iniciales de roles.
*/
INSERT INTO roles (nombre, descripcion) VALUES
('ciudadano', 'Usuario registrado que puede crear incidencias y seguir sus avisos'),
('tecnico', 'Usuario con permisos especiales que gestiona incidencias desde el panel del ayuntamiento');

/*
Departamentos municipales del Ayuntamiento de Algeciras.
*/
INSERT INTO departamentos (nombre, descripcion, email_contacto, telefono) VALUES
('Alumbrado público', 'Gestión de farolas y problemas de iluminación urbana', 'alumbrado@ayuntamiento-algeciras.es', '956000001'),
('Limpieza urbana', 'Gestión de residuos, basura y limpieza de calles', 'limpieza@ayuntamiento-algeciras.es', '956000002'),
('Obras y mantenimiento', 'Gestión de baches, aceras y desperfectos en la vía pública', 'obras@ayuntamiento-algeciras.es', '956000003'),
('Jardines', 'Gestión de parques, árboles y zonas verdes', 'jardines@ayuntamiento-algeciras.es', '956000004'),
('Mobiliario urbano', 'Gestión de bancos, papeleras, señales y otros elementos urbanos', 'mobiliario@ayuntamiento-algeciras.es', '956000005');

/*
Tipos de incidencia.
Cada tipo está asociado a un departamento.
*/
INSERT INTO tipos_incidencia (departamento_id, nombre, descripcion) VALUES
(1, 'Farola rota', 'Farola apagada, rota o con funcionamiento incorrecto'),
(1, 'Zona sin iluminación', 'Calle o zona con iluminación insuficiente'),
(2, 'Basura acumulada', 'Acumulación de basura en la vía pública'),
(2, 'Contenedor roto', 'Contenedor dañado o inutilizable'),
(3, 'Bache en calzada', 'Desperfecto en carretera o calle'),
(3, 'Acerado en mal estado', 'Aceras rotas o peligrosas para peatones'),
(4, 'Árbol caído', 'Árbol o rama caída en zona pública'),
(4, 'Zona verde descuidada', 'Parque o jardín en mal estado'),
(5, 'Banco roto', 'Banco público deteriorado'),
(5, 'Señal dañada', 'Señal de tráfico o informativa rota');

/*
Estados posibles de una incidencia.
*/
INSERT INTO estados_incidencia (nombre, descripcion, color, orden, es_final) VALUES
('Pendiente', 'La incidencia ha sido registrada pero todavía no ha sido revisada', 'gris', 1, 0),
('Validada', 'La incidencia ha sido revisada y aceptada por el ayuntamiento', 'azul', 2, 0),
('En proceso', 'La incidencia está siendo atendida por el departamento correspondiente', 'naranja', 3, 0),
('Solucionado', 'La incidencia ha sido resuelta', 'verde', 4, 1),
('Rechazada', 'La incidencia no procede o no corresponde al ayuntamiento', 'rojo', 5, 1);

/*
Prioridades disponibles.
*/
INSERT INTO prioridades (nombre, descripcion, nivel, color) VALUES
('Baja', 'No supone peligro inmediato', 1, 'verde'),
('Media', 'Requiere revisión normal', 2, 'amarillo'),
('Alta', 'Puede afectar a peatones o tráfico', 3, 'naranja'),
('Urgente', 'Supone peligro inmediato', 4, 'rojo');

/*
Barrios y zonas de Algeciras.
*/
INSERT INTO barrios (nombre, distrito, codigo_postal) VALUES
('Centro', 'Centro', '11201'),
('San García', 'Zona sur', '11207'),
('Getares', 'Zona sur', '11207'),
('El Rinconcillo', 'Zona norte', '11205'),
('La Granja', 'Zona oeste', '11206'),
('Los Pastores', 'Zona oeste', '11206'),
('La Bajadilla', 'Zona centro', '11203'),
('El Saladillo', 'Zona norte', '11205'),
('San Bernabé', 'Zona norte', '11205'),
('Pelayo', 'Zona rural', '11206');
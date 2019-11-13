  
CREATE TABLE cartas_casaluker.aplicaciones_lub (
  id_aplicacion int(11) NOT NULL AUTO_INCREMENT,
  tipo varchar(10) NOT NULL,
  aplicacion varchar(50) NOT NULL,
  id_colores int(11) NOT NULL,
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  activo tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (id_aplicacion),
  KEY color (id_colores)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('1', 'Aceite', 'ACEITE DE AVIACION', '11', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('2', 'Aceite', 'ACEITE DE CORTE, MAQUINARIA Y HERRAMIENTAS', '9', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('3', 'Aceite', 'ACEITE DE REFRIGERACION', '14', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('4', 'Aceite', 'ACEITE DE TRANSFERENCIA DE CALOR', '4', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('5', 'Aceite', 'ACEITE DIELECTRICOS', '5', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('6', 'Aceite', 'ACEITE HIDRAULICOS', '10', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('7', 'Aceite', 'ACEITE PARA CADENAS Y RODAMIENTOS', '8', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('8', 'Aceite', 'ACEITE PARA COMPRESORES', '7', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('9', 'Aceite', 'ACEITE PARA ENGRANAJES', '6', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('10', 'Aceite', 'ACEITE PARA SISTEMAS NEUMATICOS', '16', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('11', 'Aceite', 'ACEITE PARA TURBINAS DE GAS', '18', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('12', 'Aceite', 'ACEITE PARA TURBINAS DE VAPOR', '3', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('13', 'Aceite', 'ACEITE PARA TURBINAS HIDRAULICAS', '13', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('14', 'Aceite', 'ACEITE PARA MAQUINAS TEXTILES', '17', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('15', 'Aceite', 'ACEITES PARA MOTORES A GAS', '19', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('16', 'Aceite', 'BOMBAS DE VACIO', '12', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('17', 'Grasa', 'ARCILLA', '20', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('18', 'Grasa', 'BARIO', '10', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('19', 'Grasa', 'BENTONITA', '3', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('20', 'Grasa', 'CALCIO', '4', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('21', 'Grasa', 'SULFANATO DE CALCIO', '6', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('22', 'Grasa', 'CALCIO/LITIO', '9', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('23', 'Grasa', 'COMPLEJO DE ALUMINIO', '17', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('24', 'Grasa', 'COMPLEJO DE CALCIO', '11', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('25', 'Grasa', 'COMPLEJO DE LITIO', '14', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('26', 'Grasa', 'LITIO', '5', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('27', 'Grasa', 'LITIO - 12 HIDROXIESTEARICO', '18', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('28', 'Grasa', 'POLIUREA', '13', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('29', 'Grasa', 'OLEATO DE CALCIO', '8', '2017-07-28 15:36:02', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('30', 'Aceite', 'ACEITE PARA MOTORES COMBUSTION INTERNA', '18', '2017-08-24 07:00:00', '2', '1');
INSERT INTO cartas_casaluker.aplicaciones_lub VALUES ('31', 'Aceite', 'ACEITE DE ENGRANAJES AUTOMOTRICES', '6', '2017-08-24 07:00:00', '2', '1');

CREATE TABLE cartas_casaluker.clasificaciones (
  id_clasificaciones int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(100) NOT NULL,
  abreviatura varchar(10) NOT NULL,
  id_colores int(11) NOT NULL,
  activo tinyint(4) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_clasificaciones),
  KEY color (id_colores)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.clasificaciones VALUES ('3', 'ISO 100', 'ISO 100', '11', '1', '2017-07-27 22:05:41', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('4', 'ISO 100AW', 'ISO 100AW', '11', '1', '2018-04-14 20:05:11', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('5', 'ISO 15', 'ISO 15', '18', '1', '2017-07-28 16:02:46', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('6', 'ISO 150', 'ISO 150', '8', '1', '2017-07-27 22:06:54', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('7', 'ISO 320', 'ISO 320', '19', '1', '2017-07-28 16:03:34', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('8', 'SAE 40', 'SAE 40', '11', '1', '2017-07-28 16:03:49', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('9', 'ISO 46 AW', 'ISO 46', '14', '1', '2017-07-27 22:09:15', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('10', 'ISO 68', 'ISO 68', '6', '1', '2017-07-28 16:05:31', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('11', 'NLGI 2', 'NLGI 2', '11', '1', '2017-07-27 22:10:33', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('12', 'SAE 15W40', 'SAE 15W40', '4', '1', '2017-07-27 22:11:04', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('13', 'N/A', 'N/A', '15', '1', '2017-07-27 07:00:00', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('14', 'NLGI 00', 'NLGI 00', '10', '1', '2018-04-14 07:00:00', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('15', 'ISO 10', 'ISO 10', '20', '1', '2018-04-14 07:00:00', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('16', 'ISO 220', 'ISO 220', '18', '1', '2018-04-14 07:00:00', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('17', 'ISO 32', 'ISO 32', '4', '1', '2018-04-14 07:00:00', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('18', 'ISO 460', 'ISO 460', '17', '1', '2018-04-14 07:00:00', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('19', 'ISO 680 EP1', 'ISO 680', '5', '1', '2018-04-22 13:57:49', '2');
INSERT INTO cartas_casaluker.clasificaciones VALUES ('20', 'NLGI 1 EP1', 'NLGI 1', '6', '1', '2018-05-04 13:03:25', '2');

CREATE TABLE cartas_casaluker.colores (
  id_colores int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(100) NOT NULL,
  hexadecimal varchar(50) NOT NULL,
  activo tinyint(4) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_colores)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.colores VALUES ('3', 'AMARILLO', '#ffff00', '1', '2018-02-08 18:55:05', '2');
INSERT INTO cartas_casaluker.colores VALUES ('4', 'LILA', '#e082ee', '1', '2018-04-13 19:59:02', '2');
INSERT INTO cartas_casaluker.colores VALUES ('5', 'MORADO CLARO', '#e100e1', '1', '2018-04-13 19:59:20', '2');
INSERT INTO cartas_casaluker.colores VALUES ('6', 'ROJO', '#ff0000', '1', '2017-07-27 22:01:57', '2');
INSERT INTO cartas_casaluker.colores VALUES ('7', 'AZUL REY', '#0000ff', '1', '2017-07-28 15:06:15', '2');
INSERT INTO cartas_casaluker.colores VALUES ('8', 'NEGRO', '#000000', '1', '2017-07-27 22:02:10', '2');
INSERT INTO cartas_casaluker.colores VALUES ('9', 'NARANJA', '#ff8000', '1', '2017-07-28 15:08:13', '2');
INSERT INTO cartas_casaluker.colores VALUES ('10', 'VERDE CLARO', '#00ff80', '1', '2017-07-28 15:06:33', '2');
INSERT INTO cartas_casaluker.colores VALUES ('11', 'BLANCO', '#ffffff', '1', '2018-04-13 19:59:33', '2');
INSERT INTO cartas_casaluker.colores VALUES ('12', 'ROSADO', '#ff80c0', '1', '2017-07-28 15:11:13', '2');
INSERT INTO cartas_casaluker.colores VALUES ('13', 'GRIS CLARO', '#c0c0c0', '1', '2017-07-28 15:07:28', '2');
INSERT INTO cartas_casaluker.colores VALUES ('14', 'AZUL CLARO', '#b3b3ff', '1', '2018-04-13 20:01:58', '2');
INSERT INTO cartas_casaluker.colores VALUES ('15', 'SIN COLOR', '', '1', '2017-07-27 22:09:43', '2');
INSERT INTO cartas_casaluker.colores VALUES ('16', 'MORADO OSCURO', '#800080', '1', '0000-00-00 00:00:00', '2');
INSERT INTO cartas_casaluker.colores VALUES ('17', 'VERDE OSCURO', '#008000', '1', '0000-00-00 00:00:00', '2');
INSERT INTO cartas_casaluker.colores VALUES ('18', 'AZUL OSCURO', '#0054a8', '1', '2018-04-13 20:02:15', '2');
INSERT INTO cartas_casaluker.colores VALUES ('19', 'GRIS OSCURO', '#808080', '1', '2018-04-13 20:02:26', '2');
INSERT INTO cartas_casaluker.colores VALUES ('20', 'MARRON', '#804000', '1', '2018-04-13 20:02:37', '2');
INSERT INTO cartas_casaluker.colores VALUES ('21', 'PIEL', '#ffd7ae', '1', '2018-06-11 23:51:07', '2');

CREATE TABLE cartas_casaluker.componentes (
  id_componentes int(11) NOT NULL AUTO_INCREMENT,
  id_equipos int(11) NOT NULL,
  descripcion varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  codigo_empresa varchar(15) DEFAULT NULL,
  consecutivo int(11) DEFAULT '0',
  id_fabricante varchar(20) DEFAULT NULL,
  tempmaxima int(11) NOT NULL DEFAULT '0',
  activo tinyint(4) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_componentes),
  KEY equipo (id_equipos)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.empresas (
  id_empresa int(11) NOT NULL AUTO_INCREMENT,
  NOMBRE varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  TIPOACTIVIDAD varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  LOGO varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  LOGO2 varchar(255) CHARACTER SET utf8 NOT NULL,
  activo smallint(4) NOT NULL DEFAULT '1',
  ubicacion varchar(100) DEFAULT NULL,
  PRIMARY KEY (id_empresa)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.empresas VALUES ('1', 'CASALUKER', 'Alimentos', 'CASALUKER/imagenes/LOGOS_SOFTWARE_01.jpg', 'CASALUKER/imagenes/LOGOS_SOFTWARE_02.jpg', '1', 'BOGOTA');


CREATE TABLE cartas_casaluker.equipos (
  id_equipos int(11) NOT NULL AUTO_INCREMENT,
  id_secciones int(11) NOT NULL,
  id_fabricante varchar(20) DEFAULT NULL,
  descripcion varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  codigo_empresa varchar(15) DEFAULT NULL,
  consecutivo int(11) DEFAULT '0',
  codigo_carta varchar(15) DEFAULT NULL,
  activo tinyint(4) NOT NULL DEFAULT '1',
  horas_acum int(11) NOT NULL DEFAULT '0',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  temp_pagina int(4) DEFAULT '0',
  PRIMARY KEY (id_equipos),
  KEY seccion (id_secciones)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.equipos_imagen (
  id_equipo_imagen int(11) NOT NULL AUTO_INCREMENT COMMENT 'codigo imagen',
  description varchar(100) NOT NULL COMMENT 'descripcion',
  file varchar(100) NOT NULL COMMENT 'ruta archivo',
  id_equipos int(11) NOT NULL,
  orden smallint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (id_equipo_imagen),
  KEY equipo (id_equipos)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.frecuencias (
  id_frecuencias int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(100) NOT NULL COMMENT 'Contiene el nombre de la frecuencia',
  id_unidad int(11) DEFAULT '0',
  abreviatura varchar(10) DEFAULT NULL,
  tipo varchar(5) NOT NULL,
  dias_horas int(11) NOT NULL DEFAULT '0',
  activo tinyint(4) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_frecuencias),
  KEY unidad (id_unidad)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.frecuencias VALUES ('3', 'Semanal', '5', 'Sem', 'Dias', '7', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('4', 'Quincenal', '5', 'Qui', 'Dias', '15', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('5', 'Mensual', '5', 'Men', 'Dias', '30', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('6', 'Bimestral', '5', 'Bim', 'Dias', '60', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('7', 'Trimestral', '5', 'Trim', 'Dias', '90', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('8', 'Semestral', '5', 'Semes', 'Dias', '180', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('9', 'Anual', '5', 'Anual', 'Dias', '365', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('10', 'Bi-anual', '5', 'Bian', 'Dias', '730', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('11', 'Predictiva', '7', 'Predic', 'Dias', '0', '1', '2017-10-02 21:04:05', '2');
INSERT INTO cartas_casaluker.frecuencias VALUES ('12', 'Diario', '5', 'Diario', 'Dias', '1', '1', '2017-10-02 21:04:05', '3');
INSERT INTO cartas_casaluker.frecuencias VALUES ('13', 'Anual-Predic', '5', 'Anual-Pred', 'Dias', '365', '1', '2017-11-26 16:15:55', '3');
INSERT INTO cartas_casaluker.frecuencias VALUES ('14', 'Tri-anual', '5', 'Trianual', 'Dias', '1095', '1', '2018-06-12 00:26:49', '2');

CREATE TABLE cartas_casaluker.lubricantes (
  id_lubricantes int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(100) NOT NULL,
  codigo_empresa varchar(10) NOT NULL,
  clase varchar(10) NOT NULL,
  tipo varchar(15) NOT NULL,
  categoria varchar(4) NOT NULL,
  marca varchar(20) NOT NULL,
  cod_clasificacion int(11) NOT NULL,
  activo tinyint(1) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_lubricantes),
  KEY clasificacion (cod_clasificacion)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.mec_met (
  id_mec_met int(11) NOT NULL AUTO_INCREMENT,
  id_mecanismos int(11) NOT NULL,
  id_metodos int(11) NOT NULL,
  id_tareas int(11) NOT NULL,
  id_frecuencias int(11) NOT NULL,
  id_aplicacion int(11) NOT NULL DEFAULT '0',
  minutos_ejecucion int(11) NOT NULL DEFAULT '0',
  puntos int(11) NOT NULL DEFAULT '0',
  id_unidad_cant int(11) NOT NULL DEFAULT '0',
  id_simbologia int(11) NOT NULL DEFAULT '0',
  cod_lubricante int(11) NOT NULL,
  observaciones varchar(150) DEFAULT NULL,
  ultima_fecha_ejec date DEFAULT NULL,
  proxima_fecha_ejec date DEFAULT NULL,
  horas_acum_ult_prog int(11) NOT NULL DEFAULT '0',
  horas_acum_prox_prog int(11) NOT NULL DEFAULT '0',
  indnivel varchar(2) DEFAULT NULL,
  indnivel_Diametro int(11) NOT NULL DEFAULT '0',
  indnivel_Longitud int(11) NOT NULL DEFAULT '0',
  tuboventeo varchar(2) DEFAULT NULL,
  valvuladrenaje varchar(2) DEFAULT NULL,
  rotulolubaceite varchar(2) DEFAULT NULL,
  indtemp varchar(2) DEFAULT NULL,
  valvulatomamuestra varchar(2) DEFAULT NULL,
  valvulafiltracionaceite varchar(2) DEFAULT NULL,
  grasera varchar(2) DEFAULT NULL,
  tipograsera varchar(10) DEFAULT NULL,
  protectorplastico varchar(2) DEFAULT NULL,
  rotulolubgrasa varchar(2) DEFAULT NULL,
  tapondrenaje varchar(2) DEFAULT NULL,
  cantidad decimal(10,1) NOT NULL DEFAULT '0.0',
  fecha_registro datetime DEFAULT NULL,
  id_usuario int(11) NOT NULL DEFAULT '0',
  id_migracion int(11) DEFAULT '0',
  dias_ult int(11) NOT NULL DEFAULT '0',
  dias_prox int(11) NOT NULL DEFAULT '0',
  id_simbologia2 int(4) NOT NULL DEFAULT '0',
  rotulo varchar(200) DEFAULT NULL,
  PRIMARY KEY (id_mec_met),
  KEY mec_met_ibfk_1 (id_mecanismos),
  KEY metodo (id_metodos),
  KEY tarea (id_tareas),
  KEY frecuencia (id_frecuencias),
  KEY aplicacion (id_aplicacion),
  KEY unidad (id_unidad_cant),
  KEY lubricante (cod_lubricante),
  KEY simbologia (id_simbologia)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.mecanismos (
  id_mecanismos int(11) NOT NULL AUTO_INCREMENT,
  codigoempresa varchar(20) DEFAULT NULL,
  id_componente int(11) NOT NULL,
  descripcion varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  tipos_lub varchar(4) DEFAULT NULL COMMENT 'AG / A / G donde A es aceite y G es grasa',
  consecutivo int(11) DEFAULT '0',
  tempoperacion int(11) NOT NULL DEFAULT '0',
  activo tinyint(4) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id_mecanismos),
  KEY Componente (id_componente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.metodos (
  id_metodos int(11) NOT NULL AUTO_INCREMENT,
  tipo varchar(11) NOT NULL,
  mostrarencarta tinyint(4) NOT NULL COMMENT 'Define si muestra o no una carta',
  descripcion varchar(100) NOT NULL,
  activo tinyint(4) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  UNIQUE KEY id_metodos (id_metodos)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


INSERT INTO cartas_casaluker.metodos VALUES ('12', 'Preventivo', '1', 'Circulacion', '1', '2017-07-28 12:09:38', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('13', 'Preventivo', '1', 'Gota a gota', '1', '2017-07-28 12:09:38', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('15', 'Preventivo', '1', 'Inmersion', '1', '2017-07-28 12:09:38', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('16', 'Preventivo', '1', 'Salpique', '1', '2017-07-28 12:09:38', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('17', 'Preventivo', '1', 'Salpique y circulacion', '1', '2017-07-28 12:09:38', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('18', 'Preventivo', '1', 'Sellado', '1', '2017-07-01 07:00:00', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('20', 'Preventivo', '1', 'Spray', '1', '2017-08-04 07:00:00', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('21', 'Preventivo', '1', 'A perdida', '1', '2017-08-04 07:00:00', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('22', 'Preventivo', '1', 'Grasa empacada', '1', '2017-08-04 07:00:00', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('23', 'Preventivo', '1', 'Grasera', '1', '2017-08-04 07:00:00', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('24', 'Preventivo', '1', 'Vaso de lubricacion', '1', '2018-04-22 14:19:51', '2');
INSERT INTO cartas_casaluker.metodos VALUES ('25', 'Predictivo', '1', 'Sin lubricacion', '1', '2018-04-22 14:45:56', '2');

CREATE TABLE cartas_casaluker.ot (
  id_ot int(11) NOT NULL AUTO_INCREMENT,
  id_planta int(11) NOT NULL,
  fecha_inicial date DEFAULT NULL,
  fecha_final date DEFAULT NULL,
  fecha_cierre date NOT NULL,
  observacion_inicial varchar(255) DEFAULT NULL,
  observacion_final varchar(255) DEFAULT NULL,
  id_usuario_incial int(11) DEFAULT NULL,
  id_usuario_final int(11) NOT NULL,
  fecha_registro_inical date DEFAULT NULL,
  fecha_registro_final date DEFAULT NULL,
  estado tinyint(4) DEFAULT NULL,
  tipo varchar(5) NOT NULL,
  PRIMARY KEY (id_ot)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.ot_detalle (
  id_detalle int(11) NOT NULL AUTO_INCREMENT,
  id_ot int(11) DEFAULT NULL,
  id_mecanismos int(11) DEFAULT NULL,
  id_metodos int(11) DEFAULT NULL,
  id_tareas int(11) DEFAULT NULL,
  id_lubricante int(11) DEFAULT NULL,
  id_frecuencias int(11) DEFAULT NULL,
  codunidad_frec int(11) NOT NULL,
  puntos int(11) DEFAULT NULL,
  cantidad int(11) DEFAULT NULL,
  codunidad_cant int(11) DEFAULT NULL,
  cantidad_real int(11) DEFAULT NULL,
  codunidad_cant_real int(11) DEFAULT NULL,
  fecha_prog date DEFAULT NULL,
  fecha_real date DEFAULT NULL,
  ejecutado tinyint(4) DEFAULT NULL,
  observaciones_prog varchar(255) DEFAULT NULL,
  observaciones_ejec varchar(255) DEFAULT NULL,
  minutos_ejec_prog int(11) NOT NULL,
  minutos_ejec_real int(11) NOT NULL,
  PRIMARY KEY (id_detalle),
  KEY ot (id_ot),
  KEY mecanismo (id_mecanismos),
  KEY metodo (id_metodos),
  KEY tarea (id_tareas),
  KEY lubricante (id_lubricante),
  KEY frecuencia (id_frecuencias),
  KEY unidad_frec (codunidad_frec),
  KEY unidad_cant (codunidad_cant),
  KEY unidad_cant_real (codunidad_cant_real)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Guarda  el detalle de cada orden de trabajo ot';

CREATE TABLE cartas_casaluker.parametros (
  id_parametro int(11) NOT NULL AUTO_INCREMENT,
  empresa varchar(255) DEFAULT NULL,
  ruta varchar(255) NOT NULL,
  lubrimaq tinyint(4) DEFAULT '0',
  activo tinyint(4) DEFAULT '0',
  PRIMARY KEY (id_parametro)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO cartas_casaluker.parametros VALUES ('1', 'CASALUKER', 'cartas_casaluker', '0', '1');

CREATE TABLE cartas_casaluker.plantas (
  id_planta int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(100) NOT NULL,
  codigo_empresa varchar(4) DEFAULT NULL,
  consecutivo int(11) DEFAULT '0',
  activo tinyint(1) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  ubicacion varchar(100) DEFAULT NULL,
  PRIMARY KEY (id_planta)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.procedimientos_tareas (
  id_procedimientos_tareas int(11) NOT NULL AUTO_INCREMENT,
  id_tareas int(11) NOT NULL,
  descripcion varchar(100) NOT NULL,
  orden int(11) NOT NULL,
  activo tinyint(1) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_procedimientos_tareas),
  KEY tarea (id_tareas)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.secciones (
  id_secciones int(11) NOT NULL AUTO_INCREMENT,
  id_planta int(11) NOT NULL,
  descripcion varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  codigo_empresa varchar(10) DEFAULT NULL,
  consecutivo int(11) DEFAULT '0',
  activo tinyint(1) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_secciones),
  KEY planta (id_planta)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.simbologia (
  id_simbologia int(11) NOT NULL AUTO_INCREMENT,
  id_frecuencia int(11) NOT NULL,
  id_aplicacion int(11) NOT NULL,
  id_lubricante int(11) NOT NULL,
  descripcion varchar(100) NOT NULL,
  ruta varchar(100) NOT NULL,
  categoria varchar(4) NOT NULL,
  clase varchar(10) NOT NULL,
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  activo tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id_simbologia),
  KEY frecuencia (id_frecuencia),
  KEY aplicacion (id_aplicacion),
  KEY clasificacion (id_lubricante)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1 COMMENT='tabla que contiene datos para el manejo de la simbología';

CREATE TABLE cartas_casaluker.tareas (
  id_tareas int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(30) NOT NULL,
  activo tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Indica si fue eliminado por e usuario',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_tareas)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.tareas VALUES ('4', 'Aplicar aceite', '1', '2017-07-27 19:52:26', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('5', 'Cambiar aceite', '1', '2017-07-27 19:52:39', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('8', 'Reengrasar', '1', '2017-08-04 15:07:17', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('9', 'Revisar nivel', '1', '2017-07-27 19:53:53', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('10', 'Tomar muestra', '1', '2017-07-27 19:54:26', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('11', 'Aplicar lubricante', '1', '2017-08-04 15:08:06', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('12', 'Cambiar grasa', '1', '2017-08-14 07:00:00', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('13', 'Aplicar grasa', '1', '2017-08-14 07:00:00', '2');
INSERT INTO cartas_casaluker.tareas VALUES ('14', 'Chequear Nivel (Operacion)', '1', '2017-09-01 18:33:33', '3');
INSERT INTO cartas_casaluker.tareas VALUES ('15', 'Revisar estado del aceite', '1', '2018-02-10 13:56:47', '3');

CREATE TABLE cartas_casaluker.tipo_usuario (
  id_tipo_usuario int(11) NOT NULL,
  descripcion varchar(120) NOT NULL,
  activo int(11) NOT NULL DEFAULT '1',
  fecharegistro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_tipo_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.tipo_usuario VALUES ('0', 'Usuario Final', '1', '2018-06-05 19:55:01', '0');
INSERT INTO cartas_casaluker.tipo_usuario VALUES ('1', 'Propietario', '1', '2018-06-05 19:55:01', '0');
INSERT INTO cartas_casaluker.tipo_usuario VALUES ('2', 'Administrador', '1', '2018-06-05 19:55:01', '0');
INSERT INTO cartas_casaluker.tipo_usuario VALUES ('3', 'Consulta', '1', '2018-06-05 19:55:01', '0');

CREATE TABLE cartas_casaluker.tpm_paginacion_carta (
  id_usuario int(20) NOT NULL DEFAULT '0',
  id_equipos int(11) NOT NULL DEFAULT '0',
  pagina int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE cartas_casaluker.unidades (
  id_unidades int(11) NOT NULL AUTO_INCREMENT,
  descripcion varchar(15) NOT NULL,
  abreviatura varchar(10) NOT NULL,
  activo tinyint(1) NOT NULL DEFAULT '1',
  fecha_registro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_usuario int(11) NOT NULL,
  PRIMARY KEY (id_unidades)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.unidades VALUES ('1', 'Galones', 'Gal', '1', '2017-07-27 21:04:57', '2');
INSERT INTO cartas_casaluker.unidades VALUES ('2', 'Gramos', 'Gr', '1', '2017-07-27 21:05:13', '2');
INSERT INTO cartas_casaluker.unidades VALUES ('3', 'Litros', 'Lt', '1', '2017-08-05 14:19:14', '2');
INSERT INTO cartas_casaluker.unidades VALUES ('4', 'Mililitro', 'Ml', '1', '2017-08-05 07:00:00', '2');
INSERT INTO cartas_casaluker.unidades VALUES ('5', 'Dias', 'Dias', '1', '2017-08-05 07:00:00', '2');
INSERT INTO cartas_casaluker.unidades VALUES ('6', 'Horas', 'Horas', '1', '2017-08-05 07:00:00', '2');
INSERT INTO cartas_casaluker.unidades VALUES ('7', 'Predictiva', 'Predic.', '1', '2017-08-23 07:00:00', '2');

CREATE TABLE cartas_casaluker.usuarios (
  id_usuario int(20) NOT NULL AUTO_INCREMENT,
  id_facebook varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  tipo_usuario int(11) NOT NULL DEFAULT '1',
  email varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  nombres varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  apellidos varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  tipo_documento int(2) DEFAULT NULL,
  numero_documento varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  telefono varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  pass varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  fecha_registro date DEFAULT NULL,
  pais int(11) DEFAULT NULL,
  ciudad int(11) DEFAULT NULL,
  activo int(1) DEFAULT '1',
  foto int(1) DEFAULT '0' COMMENT '1: Foto Local, 2: Foto Face, 0: Sin Foto',
  fecha_recordar datetime NOT NULL COMMENT 'fecha en la que solicito reseteo de contraseña',
  codigo_reseteo varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL COMMENT 'Código único generado para el reseteo de la contraseña.',
  duenocliente int(11) DEFAULT NULL,
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO cartas_casaluker.usuarios VALUES ('2', null, '2', 'confiabilidad1@ingenierosdelubricacion.com', 'Nueva', 'Empresa', '1', '0', '0', 'e10adc3949ba59abbe56e057f20f883e', 0000-00-00, '0', '0', '1', '0', '0000-00-00 00:00:00', '', '1');
INSERT INTO cartas_casaluker.usuarios VALUES ('1', null, '1', 'amartinezgomez@hotmail.com', 'Agustin', 'Martinez Gomez', '1', '91257236', '0', 'e10adc3949ba59abbe56e057f20f883e', 0000-00-00, '0', '0', '1', '0', '0000-00-00 00:00:00', '', '1');

CREATE TABLE cartas_casaluker.usuarios_parametros (
  id_parametro int(11) DEFAULT NULL,
  id_usuario int(11) DEFAULT NULL,
  lubrimaq int(11) DEFAULT NULL,
  duenocliente int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


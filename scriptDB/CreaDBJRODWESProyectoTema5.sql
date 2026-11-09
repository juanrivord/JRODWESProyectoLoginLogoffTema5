-- Creación de la base de datos, tabla y usuario de aplicación

CREATE DATABASE IF NOT EXISTS DBJRODWESProyectoTema5;

USE DBJRODWESProyectoTema5;

CREATE TABLE IF NOT EXISTS T02_Departamento (
  T02_CodDepartamento  CHAR(3) PRIMARY KEY,
  T02_DescDepartamento VARCHAR(255),
  T02_FechaCreacionDepartamento DATETIME DEFAULT CURRENT_TIMESTAMP,
  T02_VolumenDeNegocio DOUBLE,
  T02_FechaBajaDepartamento DATETIME DEFAULT NULL) ENGINE=InnoDB;

CREATE USER 'userJRODWESProyectoTema5'@'%' 
  IDENTIFIED BY 'paso';

GRANT ALL ON DBJRODWESProyectoTema5.* to 'userJRODWESProyectoTema5'@'%';

FLUSH PRIVILEGES;
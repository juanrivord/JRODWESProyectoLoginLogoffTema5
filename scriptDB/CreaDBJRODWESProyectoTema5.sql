-- Creación de la base de datos, tabla y usuario de aplicación

CREATE DATABASE IF NOT EXISTS DBJRODWESProyectoLoginLogoffTema5;

USE DBJRODWESProyectoLoginLogoffTema5;

CREATE TABLE IF NOT EXISTS T02_Departamento (
  T02_CodDepartamento  CHAR(3) PRIMARY KEY,
  T02_DescDepartamento VARCHAR(255),
  T02_FechaCreacionDepartamento DATETIME DEFAULT CURRENT_TIMESTAMP,
  T02_VolumenDeNegocio DOUBLE,
  T02_FechaBajaDepartamento DATETIME DEFAULT NULL) ENGINE=InnoDB;

CREATE USER 'userJRODWESProyectoLoginLogoffTema5'@'%' 
  IDENTIFIED BY 'paso';

GRANT ALL ON DBJRODWESProyectoLoginLogoffTema5.* to 'userJRODWESProyectoLoginLogoffTema5'@'%';

FLUSH PRIVILEGES;
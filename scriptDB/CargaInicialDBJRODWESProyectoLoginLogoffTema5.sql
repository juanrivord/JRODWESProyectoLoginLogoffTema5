-- Carga inicial

USE DBJRODWESProyectoLoginLogoffTema5;

INSERT INTO T02_Departamento
  (T02_CodDepartamento,
   T02_DescDepartamento,
   T02_FechaCreacionDepartamento,
   T02_VolumenDeNegocio,
   T02_FechaBajaDepartamento)
VALUES
  ('ADM', 'Administración', '2024-01-15 09:00:00', 125000.00, NULL),
  ('COM', 'Comercial',      '2024-01-15 09:00:00', 240000.00, NULL),
  ('FIN', 'Finanzas',       '2024-01-15 09:00:00', 180000.00, '2024-07-28 10:00:00'),
  ('TEC', 'Tecnología',     '2024-01-15 09:00:00', 310000.00, NULL),
  ('VEN', 'Ventas',         '2024-01-15 09:00:00', 275000.00, NULL);

INSERT INTO T01_Usuario 
(T01_CodUsuario,
 T01_Password,
 T01_DescUsuario,
 T01_FechaHoraUltimaConexion,
 T01_NumConexiones,
 T01_Perfil)
 VALUES
('admin', SHA2(CONCAT('admin', 'paso'), 256), 'Administrador del sistema', NOW(), 1, 'administrador'),
('heraclio', SHA2(CONCAT('heraclio', 'paso'), 256), 'Heraclio Borbujo Moran', NOW(), 1, 'usuario'),
('juan', SHA2(CONCAT('juan', 'paso'), 256), 'Juan Rivera Ordoñez', NOW(), 1, 'usuario');
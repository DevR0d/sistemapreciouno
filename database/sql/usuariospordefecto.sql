-- Creación de los roles (usando el nombre de columna correcto 'nombre' en lugar de 'nombrerol')
INSERT INTO roles(nombre) VALUES
                              ('administrador'),
                              ('prevencionista'),
                              ('superadmin');

-- Insertamos usuarios por defecto (con todos los campos requeridos)
INSERT INTO users(name, email, password, idrol, email_verified_at, remember_token, created_at, updated_at) VALUES
                                                                                                               (
                                                                                                                   'administrador',
                                                                                                                   'admin@preciouno.com',
                                                                                                                   '$2y$12$ULuC2R9E0Ot7E/uLw3VguuTXepVpWC176Ovb/43V8SnSltA6Q.wJO',
                                                                                                                   1,
                                                                                                                   NOW(),
                                                                                                                   NULL,
                                                                                                                   NOW(),
                                                                                                                   NOW()
                                                                                                               ),
                                                                                                               (
                                                                                                                   'prevencionista',
                                                                                                                   'prevencionista@preciouno.com',
                                                                                                                   '$2y$12$ULuC2R9E0Ot7E/uLw3VguuTXepVpWC176Ovb/43V8SnSltA6Q.wJO',
                                                                                                                   2,
                                                                                                                   NOW(),
                                                                                                                   NULL,
                                                                                                                   NOW(),
                                                                                                                   NOW()
                                                                                                               ),
                                                                                                               (
                                                                                                                   'superadmin',
                                                                                                                   'superadmin@preciouno.com',
                                                                                                                   '$2y$12$ULuC2R9E0Ot7E/uLw3VguuTXepVpWC176Ovb/43V8SnSltA6Q.wJO',
                                                                                                                   3,
                                                                                                                   NOW(),
                                                                                                                   NULL,
                                                                                                                   NOW(),
                                                                                                                   NOW()
                                                                                                               );

-- vehiculos
INSERT INTO vehiculos (placa, placasecundaria, estado) VALUES
    ('AUJ986', 'MSKU869736-6', 'Activo');

-- transportes
INSERT INTO transporte (ruc_transportista, nombre_razonsocial, modalidadtraslado, estado) VALUES
    ('20604158657', 'AyS DISTRIBUCIONES E.I.R.L', 'Transporte Público', 'Activo');

-- conductores
INSERT INTO conductores (nombre, dni, estado, idtransportista, idvehiculo) VALUES
    ('Robert Machacuay', '43863881', 'Activo', 1, 1);

-- tipoempresa
INSERT INTO tipoempresa (direccion, provincia, departamento, ubigeo, razonsocial, ruc, codigoestablecimiento, estado) VALUES
                                                                                                                          ('Av. Centenario No. 2086', 'CORONEL PORTILLO', 'UCAYALI', '150118', 'HIPERMERCADOS TOTTUS ORIENTE S.A.C', '20393864886', '', 'ACTIVO');
-- guiaremision
INSERT INTO guiaremision (codigoguia, fechaemision, horaemision, razonsocialguia, numerotrasladotim, motivotraslado, pesobrutototal, volumenproducto, numerobultopallet, observaciones, idconductor, idtipoempresa, estado) VALUES
    ('T003-00472255', '2025-03-18', '14:35:36', 'HIPERMERCADOS TOTTUS S.A.C', '-M655265598', 'Venta', '18665', '0.00', '0', '', 1, 1,'Activo');


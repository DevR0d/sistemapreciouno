-- Procedimiento almacenado para insertar usuarios
CREATE PROCEDURE `sp_usuarioinsertar`(
    spname varchar(255),
    spemail varchar(255),
    sppassword varchar(255),
    spidrol int,
    OUT id INT,
    OUT success bit,
    out message varchar(100)
)
BEGIN
INSERT INTO users(name, email, password, idrol)
values(spname, spemail, sppassword, spidrol);

if Row_count() > 0 then
		SET id = LAST_INSERT_ID();
		set success = 1;
        set message = "Usuario Registrado Correctente";
else
		SET id = 0;
		set success = 0;
        set message = "NO SE REGISTRO EL USUARIO";
end if;
END;

-- Procedimiento almacenado para insertar vehiculos
CREATE PROCEDURE `sp_vehiculoinsertar`(
    spplaca varchar(50),
    spmarca varchar(50),
    sptipo varchar(50),
    OUT idvehiculo INT,
    OUT success bit,
    out message varchar(100)
)
BEGIN
INSERT INTO vehiculos(placa, marca, tipo, estado)
values(spplaca, spmarca, sptipo, "Activo");

if Row_count() > 0 then
		SET idvehiculo = LAST_INSERT_ID();
		set success = 1;
        set message = "Vehiculo Registrado Correctente";
else
		SET idvehiculo = 0;
		set success = 0;
        set message = "NO SE REGISTRO EL VEHICULO";
end if;
END;

-- Procedimiento almacenado para insertar conductores
CREATE PROCEDURE `sp_conductoresinsertar`(
    spnombre varchar(50),
    spdni varchar(8),
    OUT idconductor INT,
    OUT success bit,
    out message varchar(100)
)
BEGIN
INSERT INTO conductores(nombre, dni, estado)
values(spnombre, spdni, 'ACTIVO');

if Row_count() > 0 then
		SET idconductor = LAST_INSERT_ID();
		set success = 1;
        set message = "OK";
else
		SET idconductor = 0;
		set success = 0;
        set message = "NO SE REGISTRO EL CONDUCTOR";
end if;
END;

-- Procedimiento almacenado para insertar productos
CREATE PROCEDURE `sp_productosinsertar`(
    spnombre varchar(50),
    spsku varchar(15),
    spestado varchar(50),
    spfecharegistro datetime,
    OUT idproducto INT,
    OUT success bit,
    out message varchar(100)
)
BEGIN
INSERT INTO productos(nombre, sku, estado, fecharegistro)
values(spnombre, spsku, spestado, spfecharegistro);

if Row_count() > 0 then
		SET idproducto = LAST_INSERT_ID();
		set success = 1;
        set message = "OK";
else
		SET idproducto = 0;
		set success = 0;
        set message = "NO SE REGISTRO EL PRODUCTO";
end if;
END;

-- Procedimiento almacenado para insertar guia de revision
CREATE PROCEDURE sp_guiasremision(
    sptim varchar(15),
    spfechaemision date,
    sphoraemision time,
    spmotivotraslado varchar(50),
    sporigen varchar(50),
    spdestino varchar(50),
    spestado varchar(50),
    spcantidadenviada integer,
    spidvehiculo INT,
    spidconductor INT,
    OUT idguia INT,
    OUT success bit,
    out message varchar(100)
)
BEGIN
INSERT INTO guias_remision(tim ,fechaemision ,horaemision ,motivotraslado ,origen ,destino ,estado ,cantidadenviada, idvehiculo, idconductor)
values(sptim ,spfechaemision ,sphoraemision ,spmotivotraslado ,sporigen ,spdestino ,spestado ,spcantidadenviada, spidvehiculo, spidconductor);

if Row_count() > 0 then
		SET idguia = LAST_INSERT_ID();
		set success = 1;
        set message = "OK";
else
		SET idguia = 0;
		set success = 0;
        set message = "NO SE REGISTRO LA GUIA DE REMISION";
end if;
END;

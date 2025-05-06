-- crear vista vehiculos
create view v_vehiculo
as
select * from vehiculos;

-- crear vista conductores
create view v_conductores
as
select * from conductores;

-- crear vista productos
create view v_producto
as
select * from productos;

-- crear vista guiasderemision
create view v_guias_remision
as
select * from guias_remision;

-- crear vista detalleguia
create view v_detalle_guias
as
select * from detalle_guias;

/***********************************I-SCP-EGS-PROTRA-0-12/04/2020****************************************/

CREATE TABLE protra.tvpn (
  id_vpn SERIAL,
  id_funcionario INTEGER,
  fecha_desde DATE,
  fecha_hasta DATE,
  descripcion VARCHAR,
  id_proceso_wf INTEGER,
  id_estado_wf INTEGER,
  nro_tramite VARCHAR,
  estado VARCHAR,
  CONSTRAINT tvpn_pkey PRIMARY KEY(id_vpn)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE protra.tvpn_det (
  id_vpn_det SERIAL,
  sistema VARCHAR,
  justificacion VARCHAR,
  id_vpn INTEGER,
  CONSTRAINT tvpn_det_pkey PRIMARY KEY(id_vpn_det),
  CONSTRAINT tvpn_det_fk_id_vpn FOREIGN KEY (id_vpn)
    REFERENCES protra.tvpn(id_vpn)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) INHERITS (pxp.tbase)
WITH (oids = false);

/***********************************F-SCP-EGS-PROTRA-0-12/04/2020**********************************************/
/***********************************I-SCP-VAN-PROTRA-0-30/04/2020****************************************/
create table if not exists protra.tcuentas_correo
(
	id_cuenta_correo serial not null
		constraint tcuentas_correo_pk
			primary key,
	host varchar,
	port integer,
	usuario varchar,
	contrasena varchar,
	encrypto varchar,
	carpeta varchar,
	correo varchar,
	descripcion varchar
)
inherits (pxp.tbase);

alter table protra.tcuentas_correo owner to postgres;
create table if not exists protra.taperturas_digitales
(
	id_apertura_digital serial not null
		constraint taperturas_digitales_pk
			primary key,
	fecha_recepcion_desde date,
	fecha_recepcion_hasta date,
	codigo varchar,
	hora_recepcion_desde time,
	hora_recepcion_hasta time,
	id_cuenta_correo integer
		constraint taperturas_digitales_tcuentas_correo_id_cuenta_correo_fk
			references protra.tcuentas_correo
				on update cascade on delete cascade,
	id_estado_wf integer
		constraint taperturas_digitales_testado_wf_id_estado_wf_fk
			references wf.testado_wf
				on update cascade on delete cascade,
	id_proceso_wf integer
		constraint taperturas_digitales_tproceso_wf_id_proceso_wf_fk
			references wf.tproceso_wf
				on update cascade on delete cascade,
	estado varchar(255),
	num_tramite varchar(200),
	id_funcionario integer,
	ids_funcionarios_asignados integer[],
	fecha_apertura timestamp
)
inherits (pxp.tbase);

alter table protra.taperturas_digitales owner to postgres;
create table if not exists protra.taperturas_digitales_det
(
	uid_email integer not null,
	numero_email integer not null,
	remitente_email varchar not null,
	asunto_email varchar not null,
	fecha_recepcion_email timestamp not null,
	id_apertura_digital integer not null
		constraint taperturas_digitales_det_taperturas_digitales_id_apertura_digit
			references protra.taperturas_digitales
				on update cascade on delete cascade,
	id_apertura_digital_det serial not null
		constraint taperturas_digitales_det_pk
			primary key
)
inherits (pxp.tbase);

alter table protra.taperturas_digitales_det owner to dbvalvaradoetr_conexion;

create unique index if not exists taperturas_digitales_det_numero_email_uindex
	on protra.taperturas_digitales_det (numero_email);

create unique index if not exists taperturas_digitales_det_uid_email_uindex
	on protra.taperturas_digitales_det (uid_email);



/***********************************F-SCP-VAN-PROTRA-0-30/04/2020****************************************/


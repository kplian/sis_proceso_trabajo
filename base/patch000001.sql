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

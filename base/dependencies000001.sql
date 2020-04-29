/********************************************I-DEP-EGS-PROTRA-0-12/04/2020*************************************/
select pxp.f_insert_testructura_gui ('PWF', 'SISTEMA');
select pxp.f_insert_testructura_gui ('DTI', 'PWF');
select pxp.f_insert_testructura_gui ('VPN', 'DTI');
select pxp.f_insert_testructura_gui ('VpnVoBo', 'DTI');

CREATE OR REPLACE VIEW protra.vvpn(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    obs_dba,
    id_vpn,
    id_funcionario,
    fecha_desde,
    fecha_hasta,
    descripcion,
    id_proceso_wf,
    id_estado_wf,
    nro_tramite,
    estado)
AS
  SELECT tvpn.id_usuario_reg,
         tvpn.id_usuario_mod,
         tvpn.fecha_reg,
         tvpn.fecha_mod,
         tvpn.estado_reg,
         tvpn.id_usuario_ai,
         tvpn.usuario_ai,
         tvpn.obs_dba,
         tvpn.id_vpn,
         tvpn.id_funcionario,
         tvpn.fecha_desde,
         tvpn.fecha_hasta,
         tvpn.descripcion,
         tvpn.id_proceso_wf,
         tvpn.id_estado_wf,
         tvpn.nro_tramite,
         tvpn.estado
  FROM protra.tvpn;
/********************************************F-DEP-EGS-PROTRA-0-12/04/2020*************************************/

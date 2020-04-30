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
/********************************************I-DEP-VAN-PROTRA-0-30/04/2020*************************************/
select pxp.f_insert_testructura_gui ('DIGAPE', 'PWF');
select pxp.f_insert_testructura_gui ('ADGPROG', 'DIGAPE');
select pxp.f_insert_testructura_gui ('CUECO', 'DIGAPE');

create or replace view protra.vaperturas_digitales(id_apertura_digital, id_cuenta_correo, estado_reg, obs_dba, fecha_recepcion_desde, hora_recepcion_desde, fecha_recepcion_hasta, hora_recepcion_hasta, correo, descripcion, id_usuario_reg, fecha_reg, id_usuario_ai, usuario_ai, id_usuario_mod, fecha_mod, usr_reg, usr_mod, id_proceso_wf, id_estado_wf, estado, num_tramite, desc_funcionario1, id_funcionario, fecha_apertura, ids_funcionarios_asignados) as
SELECT dig.id_apertura_digital,
       dig.id_cuenta_correo,
       dig.estado_reg,
       dig.obs_dba,
       dig.fecha_recepcion_desde,
       dig.hora_recepcion_desde,
       dig.fecha_recepcion_hasta,
       dig.hora_recepcion_hasta,
       cueco.correo,
       cueco.descripcion,
       dig.id_usuario_reg,
       dig.fecha_reg,
       dig.id_usuario_ai,
       dig.usuario_ai,
       dig.id_usuario_mod,
       dig.fecha_mod,
       usu1.cuenta AS usr_reg,
       usu2.cuenta AS usr_mod,
       dig.id_proceso_wf,
       dig.id_estado_wf,
       dig.estado,
       dig.num_tramite,
       fun_ad.desc_funcionario1,
       dig.id_funcionario,
       dig.fecha_apertura,
       dig.ids_funcionarios_asignados
FROM protra.taperturas_digitales dig
         JOIN segu.tusuario usu1 ON usu1.id_usuario = dig.id_usuario_reg
         JOIN protra.tcuentas_correo cueco ON cueco.id_cuenta_correo = dig.id_cuenta_correo
         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = dig.id_usuario_mod
         LEFT JOIN orga.vfuncionario fun_ad ON fun_ad.id_funcionario = dig.id_funcionario;

alter table protra.vaperturas_digitales owner to postgres;

/********************************************F-DEP-VAN-PROTRA-0-30/04/2020*************************************/

--------------- SQL ---------------

CREATE OR REPLACE FUNCTION protra.f_fun_inicio_vpn_wf (
  p_id_vpn integer,
  p_id_usuario integer,
  p_id_usuario_ai integer,
  p_usuario_ai varchar,
  p_id_estado_wf integer,
  p_id_proceso_wf integer,
  p_codigo_estado varchar,
  p_id_depto_lb integer = NULL::integer,
  p_id_cuenta_bancaria integer = NULL::integer,
  p_estado_anterior varchar = 'no'::character varying
)
RETURNS boolean AS
$body$
/**************************************************************************
 SISTEMA:       Sistema
 FUNCION:       protra.f_fun_inicio_vpn_wf

 DESCRIPCION:   Actualiza los estados en proceso WF
 AUTOR:         EGS
 FECHA:
 COMENTARIOS:

 ***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/
DECLARE

    v_nombre_funcion                text;
    v_resp                          varchar;
    v_mensaje                       varchar;
    v_registros                     record;
    v_rec                           record;

BEGIN

    --Identificación del nombre de la función
    v_nombre_funcion = 'protra.f_fun_inicio_vpn_wf';

    --raise exception 'entra';
    ----------------------------------------------
    --Obtención de datos de la cuenta documentada
    ----------------------------------------------
    select
        c.id_vpn,
        c.estado,
        c.id_estado_wf,
        ew.id_funcionario
        into v_rec
    from protra.tvpn c
    inner join wf.testado_wf ew on ew.id_estado_wf =  c.id_estado_wf
    where c.id_vpn = p_id_vpn;

    --Actualización del estado de la solicitud
    update protra.tvpn set
    id_estado_wf    = p_id_estado_wf,
    estado          = p_codigo_estado,
    id_usuario_mod  = p_id_usuario,
    id_usuario_ai   = p_id_usuario_ai,
    usuario_ai      = p_usuario_ai,
    fecha_mod       = now()
    where id_vpn = p_id_vpn;
    --Respuesta
    return true;

EXCEPTION

    WHEN OTHERS THEN

        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
        raise exception '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100;
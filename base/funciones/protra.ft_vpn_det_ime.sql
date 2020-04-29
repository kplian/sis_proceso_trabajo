--------------- SQL ---------------

CREATE OR REPLACE FUNCTION protra.ft_vpn_det_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_vpn_det_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.tvpn_det'
 AUTOR: 		 (egutierrez)
 FECHA:	        13-04-2020 18:43:37
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				13-04-2020 18:43:37								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.tvpn_det'
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_vpn_det	integer;

BEGIN

    v_nombre_funcion = 'protra.ft_vpn_det_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'PROTRA_VPNDET_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		egutierrez
 	#FECHA:		13-04-2020 18:43:37
	***********************************/

	if(p_transaccion='PROTRA_VPNDET_INS')then

        begin
        	--Sentencia de la insercion
        	insert into protra.tvpn_det(
			estado_reg,
			sistema,
			justificacion,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod,
            id_vpn
          	) values(
			'activo',
			v_parametros.sistema,
			v_parametros.justificacion,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null,
            v_parametros.id_vpn



			)RETURNING id_vpn_det into v_id_vpn_det;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Vpn detalle almacenado(a) con exito (id_vpn_det'||v_id_vpn_det||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_vpn_det',v_id_vpn_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'PROTRA_VPNDET_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		egutierrez
 	#FECHA:		13-04-2020 18:43:37
	***********************************/

	elsif(p_transaccion='PROTRA_VPNDET_MOD')then

		begin
			--Sentencia de la modificacion
			update protra.tvpn_det set
			sistema = v_parametros.sistema,
			justificacion = v_parametros.justificacion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            id_vpn = v_parametros.id_vpn
			where id_vpn_det=v_parametros.id_vpn_det;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Vpn detalle modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_vpn_det',v_parametros.id_vpn_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'PROTRA_VPNDET_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		egutierrez
 	#FECHA:		13-04-2020 18:43:37
	***********************************/

	elsif(p_transaccion='PROTRA_VPNDET_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from protra.tvpn_det
            where id_vpn_det=v_parametros.id_vpn_det;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Vpn detalle eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_vpn_det',v_parametros.id_vpn_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	else

    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION

	WHEN OTHERS THEN
		v_resp='';
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
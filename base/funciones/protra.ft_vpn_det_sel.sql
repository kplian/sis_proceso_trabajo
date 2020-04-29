--------------- SQL ---------------

CREATE OR REPLACE FUNCTION protra.ft_vpn_det_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_vpn_det_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.tvpn_det'
 AUTOR: 		 (egutierrez)
 FECHA:	        13-04-2020 18:43:37
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				13-04-2020 18:43:37								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.tvpn_det'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;

BEGIN

	v_nombre_funcion = 'protra.ft_vpn_det_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'PROTRA_VPNDET_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		egutierrez
 	#FECHA:		13-04-2020 18:43:37
	***********************************/

	if(p_transaccion='PROTRA_VPNDET_SEL')then

    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						vpndet.id_vpn_det,
						vpndet.estado_reg,
						vpndet.sistema,
						vpndet.justificacion,
						vpndet.id_usuario_reg,
						vpndet.fecha_reg,
						vpndet.id_usuario_ai,
						vpndet.usuario_ai,
						vpndet.id_usuario_mod,
						vpndet.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        vpndet.id_vpn
						from protra.tvpn_det vpndet
						inner join segu.tusuario usu1 on usu1.id_usuario = vpndet.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = vpndet.id_usuario_mod
				        where  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'PROTRA_VPNDET_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		egutierrez
 	#FECHA:		13-04-2020 18:43:37
	***********************************/

	elsif(p_transaccion='PROTRA_VPNDET_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_vpn_det)
					    from protra.tvpn_det vpndet
					    inner join segu.tusuario usu1 on usu1.id_usuario = vpndet.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = vpndet.id_usuario_mod
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	else

		raise exception 'Transaccion inexistente';

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
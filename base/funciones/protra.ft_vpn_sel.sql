--------------- SQL ---------------

CREATE OR REPLACE FUNCTION protra.ft_vpn_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_vpn_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.tvpn'
 AUTOR: 		 (egutierrez)
 FECHA:	        12-04-2020 17:37:52
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-04-2020 17:37:52								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.tvpn'
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
	v_filtro			varchar;

BEGIN

	v_nombre_funcion = 'protra.ft_vpn_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'PROTRA_SOLVPN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		egutierrez
 	#FECHA:		12-04-2020 17:37:52
	***********************************/

	if(p_transaccion='PROTRA_SOLVPN_SEL')then

         IF p_administrador !=1 then

         			--raise exception 'v_parametros.nombreVista %',v_parametros.nombreVista;
                 --si es la vista del help y estan en estado asignado y finalizado muestra solo os registristros del funcionario solicitante
                    IF v_parametros.nombreVista = 'Vpn'   THEN

                        v_filtro = '(solvpn.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' ) and ';

                    --Si no soy administrador y estoy en pendiente no veo nada
                    ElSIF v_parametros.nombreVista = 'VpnVoBo' THEN
                        v_filtro = '(ew.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' )and ';

                    ELSE
                    v_filtro = ' ';
                    END IF;
         ELSE
                 v_filtro = ' ';
         END IF;


    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						solvpn.id_vpn,
						solvpn.estado_reg,
						solvpn.id_funcionario,
						solvpn.fecha_desde,
						solvpn.fecha_hasta,
						solvpn.descripcion,
						solvpn.id_usuario_reg,
						solvpn.fecha_reg,
						solvpn.id_usuario_ai,
						solvpn.usuario_ai,
						solvpn.id_usuario_mod,
						solvpn.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        solvpn.id_proceso_wf,
                        solvpn.id_estado_wf,
                        solvpn.nro_tramite,
                        solvpn.estado,
                        fun.desc_funcionario1::varchar as desc_funcionario,
                        funi.desc_funcionario1::varchar as desc_funcionario_responsable,
                        ew.obs::varchar
						from protra.tvpn solvpn
						inner join segu.tusuario usu1 on usu1.id_usuario = solvpn.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = solvpn.id_usuario_mod
				        left join orga.vfuncionario fun on fun.id_funcionario = solvpn.id_funcionario
                        inner join wf.testado_wf ew on ew.id_proceso_wf = solvpn.id_proceso_wf and  ew.estado_reg = ''activo''
                        left join orga.vfuncionario funi on funi.id_funcionario = ew.id_funcionario
                        where  '||v_filtro;

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'PROTRA_SOLVPN_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		egutierrez
 	#FECHA:		12-04-2020 17:37:52
	***********************************/

	elsif(p_transaccion='PROTRA_SOLVPN_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_vpn)
					    from protra.tvpn solvpn
					    inner join segu.tusuario usu1 on usu1.id_usuario = solvpn.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = solvpn.id_usuario_mod
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
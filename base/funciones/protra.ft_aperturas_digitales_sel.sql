CREATE OR REPLACE FUNCTION "protra"."ft_aperturas_digitales_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_aperturas_digitales_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.taperturas_digitales'
 AUTOR: 		 (valvarado)
 FECHA:	        20-04-2020 22:13:29
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				20-04-2020 22:13:29								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.taperturas_digitales'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'protra.ft_aperturas_digitales_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PROTRA_DIG_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		valvarado	
 	#FECHA:		20-04-2020 22:13:29
	***********************************/

	if(p_transaccion='PROTRA_DIG_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						dig.id_apertura_digital,
			            dig.id_cuenta_correo,
						dig.estado_reg,
			            dig.codigo,
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
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
			            dig.id_proceso_wf,
			            dig.id_estado_wf,
			            dig.estado,
			            dig.num_tramite,
			            fun_ad.desc_funcionario1,
			            dig.id_funcionario,
			            dig.fecha_apertura,
			            dig.ids_funcionarios_asignados
						from protra.taperturas_digitales dig
						inner join segu.tusuario usu1 on usu1.id_usuario = dig.id_usuario_reg
			            inner join protra.tcuentas_correo cueco on cueco.id_cuenta_correo = dig.id_cuenta_correo
						left join segu.tusuario usu2 on usu2.id_usuario = dig.id_usuario_mod
				        left join orga.vfuncionario fun_ad on fun_ad.id_funcionario = dig.id_funcionario
			            where  ';
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_DIG_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		valvarado	
 	#FECHA:		20-04-2020 22:13:29
	***********************************/

	elsif(p_transaccion='PROTRA_DIG_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_apertura_digital)
					    from protra.taperturas_digitales dig
					    inner join segu.tusuario usu1 on usu1.id_usuario = dig.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = dig.id_usuario_mod
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "protra"."ft_aperturas_digitales_sel"(integer, integer, character varying, character varying) OWNER TO postgres;

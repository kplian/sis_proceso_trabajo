CREATE OR REPLACE FUNCTION "protra"."ft_cuentas_correo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_cuentas_correo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.tcuentas_correo'
 AUTOR: 		 (valvarado)
 FECHA:	        22-04-2020 23:57:33
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				22-04-2020 23:57:33								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.tcuentas_correo'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'protra.ft_cuentas_correo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PROTRA_CUECO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		valvarado	
 	#FECHA:		22-04-2020 23:57:33
	***********************************/

	if(p_transaccion='PROTRA_CUECO_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						cueco.id_cuenta_correo,
						cueco.estado_reg,
						cueco.obs_dba,
						cueco.host,
						cueco.port,
						cueco.usuario,
						cueco.contrasena,
						cueco.encrypto,
						cueco.carpeta,
						cueco.correo,
						cueco.descripcion,
						cueco.id_usuario_reg,
						cueco.fecha_reg,
						cueco.id_usuario_ai,
						cueco.usuario_ai,
						cueco.id_usuario_mod,
						cueco.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
			            cueco.texto_asunto_confirmacion,
			            cueco.texto_mensaje_confirmacion
						from protra.tcuentas_correo cueco
						inner join segu.tusuario usu1 on usu1.id_usuario = cueco.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cueco.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_CUECO_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		valvarado	
 	#FECHA:		22-04-2020 23:57:33
	***********************************/

	elsif(p_transaccion='PROTRA_CUECO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_cuenta_correo)
					    from protra.tcuentas_correo cueco
					    inner join segu.tusuario usu1 on usu1.id_usuario = cueco.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cueco.id_usuario_mod
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
ALTER FUNCTION "protra"."ft_cuentas_correo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;

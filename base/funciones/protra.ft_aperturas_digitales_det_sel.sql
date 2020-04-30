CREATE OR REPLACE FUNCTION "protra"."ft_aperturas_digitales_det_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_aperturas_digitales_det_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.taperturas_digitales_det'
 AUTOR: 		 (valvarado)
 FECHA:	        21-04-2020 23:09:51
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				21-04-2020 23:09:51								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'protra.taperturas_digitales_det'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'protra.ft_aperturas_digitales_det_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PROTRA_ADIGD_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		valvarado	
 	#FECHA:		21-04-2020 23:09:51
	***********************************/

	if(p_transaccion='PROTRA_ADIGD_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						adigd.id_apertura_digital_det,
						adigd.estado_reg,
						adigd.obs_dba,
						adigd.uid_email,
						adigd.numero_email,
						adigd.remitente_email,
						adigd.asunto_email,
						adigd.fecha_recepcion_email,
						adigd.id_apertura_digital,
						adigd.id_usuario_reg,
						adigd.fecha_reg,
						adigd.id_usuario_ai,
						adigd.usuario_ai,
						adigd.id_usuario_mod,
						adigd.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from protra.taperturas_digitales_det adigd
						inner join segu.tusuario usu1 on usu1.id_usuario = adigd.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = adigd.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_ADIGD_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		valvarado	
 	#FECHA:		21-04-2020 23:09:51
	***********************************/

	elsif(p_transaccion='PROTRA_ADIGD_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_apertura_digital_det)
					    from protra.taperturas_digitales_det adigd
					    inner join segu.tusuario usu1 on usu1.id_usuario = adigd.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = adigd.id_usuario_mod
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
ALTER FUNCTION "protra"."ft_aperturas_digitales_det_sel"(integer, integer, character varying, character varying) OWNER TO postgres;

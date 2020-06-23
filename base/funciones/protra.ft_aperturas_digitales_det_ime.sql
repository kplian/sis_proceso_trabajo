CREATE OR REPLACE FUNCTION "protra"."ft_aperturas_digitales_det_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_aperturas_digitales_det_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.taperturas_digitales_det'
 AUTOR: 		 (valvarado)
 FECHA:	        21-04-2020 23:09:51
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				21-04-2020 23:09:51								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.taperturas_digitales_det'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_apertura_digital_det	integer;
			    
BEGIN

    v_nombre_funcion = 'protra.ft_aperturas_digitales_det_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PROTRA_ADIGD_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		valvarado	
 	#FECHA:		21-04-2020 23:09:51
	***********************************/

	if(p_transaccion='PROTRA_ADIGD_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into protra.taperturas_digitales_det(
			estado_reg,
			obs_dba,
			uid_email,
			numero_email,
			remitente_email,
			asunto_email,
			fecha_recepcion_email,
			id_apertura_digital,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod,
            aceptado
          	) values(
			'activo',
			'',
			v_parametros.uid_email,
			v_parametros.numero_email,
			v_parametros.remitente_email,
			v_parametros.asunto_email,
			v_parametros.fecha_recepcion_email,
			v_parametros.id_apertura_digital,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null,
			v_parametros.aceptado
			
			
			)RETURNING id_apertura_digital_det into v_id_apertura_digital_det;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Aperturas digitales Detalle almacenado(a) con exito (id_apertura_digital_det'||v_id_apertura_digital_det||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_apertura_digital_det',v_id_apertura_digital_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_ADIGD_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		valvarado	
 	#FECHA:		21-04-2020 23:09:51
	***********************************/

	elsif(p_transaccion='PROTRA_ADIGD_MOD')then

		begin
			--Sentencia de la modificacion
			update protra.taperturas_digitales_det set
			uid_email = v_parametros.uid_email,
			numero_email = v_parametros.numero_email,
			remitente_email = v_parametros.remitente_email,
			asunto_email = v_parametros.asunto_email,
			fecha_recepcion_email = v_parametros.fecha_recepcion_email,
			id_apertura_digital = v_parametros.id_apertura_digital,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_apertura_digital_det=v_parametros.id_apertura_digital_det;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Aperturas digitales Detalle modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_apertura_digital_det',v_parametros.id_apertura_digital_det::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_ADIGD_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		valvarado	
 	#FECHA:		21-04-2020 23:09:51
	***********************************/

	elsif(p_transaccion='PROTRA_ADIGD_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from protra.taperturas_digitales_det
            where id_apertura_digital_det=v_parametros.id_apertura_digital_det;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Aperturas digitales Detalle eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_apertura_digital_det',v_parametros.id_apertura_digital_det::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "protra"."ft_aperturas_digitales_det_ime"(integer, integer, character varying, character varying) OWNER TO postgres;

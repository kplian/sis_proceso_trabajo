CREATE OR REPLACE FUNCTION "protra"."ft_cuentas_correo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_cuentas_correo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.tcuentas_correo'
 AUTOR: 		 (valvarado)
 FECHA:	        22-04-2020 23:57:33
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				22-04-2020 23:57:33								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.tcuentas_correo'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_cuenta_correo	integer;
			    
BEGIN

    v_nombre_funcion = 'protra.ft_cuentas_correo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PROTRA_CUECO_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		valvarado	
 	#FECHA:		22-04-2020 23:57:33
	***********************************/

	if(p_transaccion='PROTRA_CUECO_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into protra.tcuentas_correo(
			estado_reg,
			host,
			port,
			usuario,
			contrasena,
			encrypto,
			carpeta,
			correo,
			descripcion,
			id_usuario_reg,
			fecha_reg,
			id_usuario_ai,
			usuario_ai,
			id_usuario_mod,
			fecha_mod,
            texto_asunto_confirmacion,
            texto_mensaje_confirmacion
          	) values(
			'activo',
			v_parametros.host,
			v_parametros.port,
			v_parametros.usuario,
			v_parametros.contrasena,
			v_parametros.encrypto,
			v_parametros.carpeta,
			v_parametros.correo,
			v_parametros.descripcion,
			p_id_usuario,
			now(),
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			null,
			null,
            v_parametros.texto_asunto_confirmacion,
            v_parametros.texto_mensaje_confirmacion
			)RETURNING id_cuenta_correo into v_id_cuenta_correo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuentas de Correo almacenado(a) con exito (id_cuenta_correo'||v_id_cuenta_correo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cuenta_correo',v_id_cuenta_correo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_CUECO_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		valvarado	
 	#FECHA:		22-04-2020 23:57:33
	***********************************/

	elsif(p_transaccion='PROTRA_CUECO_MOD')then

		begin
			--Sentencia de la modificacion
			update protra.tcuentas_correo set
			host = v_parametros.host,
			port = v_parametros.port,
			usuario = v_parametros.usuario,
			contrasena = v_parametros.contrasena,
			encrypto = v_parametros.encrypto,
			carpeta = v_parametros.carpeta,
			correo = v_parametros.correo,
			descripcion = v_parametros.descripcion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            texto_asunto_confirmacion  = v_parametros.texto_asunto_confirmacion,
            texto_mensaje_confirmacion = v_parametros.texto_mensaje_confirmacion
			where id_cuenta_correo=v_parametros.id_cuenta_correo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuentas de Correo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cuenta_correo',v_parametros.id_cuenta_correo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'PROTRA_CUECO_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		valvarado	
 	#FECHA:		22-04-2020 23:57:33
	***********************************/

	elsif(p_transaccion='PROTRA_CUECO_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from protra.tcuentas_correo
            where id_cuenta_correo=v_parametros.id_cuenta_correo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuentas de Correo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cuenta_correo',v_parametros.id_cuenta_correo::varchar);
              
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
ALTER FUNCTION "protra"."ft_cuentas_correo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;

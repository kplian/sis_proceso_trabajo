CREATE OR REPLACE FUNCTION "protra"."ft_aperturas_digitales_ime"(p_administrador integer, p_id_usuario integer,
                                                                 p_tabla character varying,
                                                                 p_transaccion character varying)
    RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Procesos de Trabajo
 FUNCION: 		protra.ft_aperturas_digitales_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.taperturas_digitales'
 AUTOR: 		 (valvarado)
 FECHA:	        20-04-2020 22:13:29
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				20-04-2020 22:13:29								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'protra.taperturas_digitales'	
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento          integer;
    v_parametros                 record;
    v_id_requerimiento           integer;
    v_resp                       varchar;
    v_nombre_funcion             text;
    v_mensaje_error              text;
    v_id_apertura_digital        integer;
    v_codigo                     varchar;
    v_id_periodo                 integer;
    v_id_proceso_macro           integer;
    v_codigo_tipo_proceso        varchar;
    v_fecha                      date;
    v_id_gestion                 integer;
    v_num_tramite                varchar;
    v_id_proceso_wf              integer;
    v_id_estado_wf               integer;
    v_codigo_estado              varchar;
    v_estado                     varchar;
    va_id_tipo_estado            integer[];
    va_codigo_estado             varchar[];
    va_disparador                varchar[];
    va_regla                     varchar[];
    va_prioridad                 integer[];
    v_num_estados                integer;
    v_id_estado_actual           integer;
    v_id_tipo_estado             integer;
    v_registros_apertura_digital record;
    v_id_funcionario             integer;
    v_id_usuario_reg             integer;
    v_id_estado_wf_ant           integer;
    v_ids_funcionarios_asignados integer[];
    v_acceso_directo             varchar;
    v_clase                      varchar;
    v_parametros_ad              varchar;
    v_tipo_noti                  varchar;
    v_titulo                     varchar;
    v_desc_funcionario1          varchar;
    v_correo                     varchar;
    v_descripcion_correo         varchar;
    v_id_alarma                  integer;
    v_id                         integer;
    v_fecha_hora_desde           timestamp;
    v_fecha_hora_hasta           timestamp;
    v_fecha_hora_apertura        timestamp;
BEGIN

    v_nombre_funcion = 'protra.ft_aperturas_digitales_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'PROTRA_DIG_INS'
     #DESCRIPCION:	Insercion de registros
     #AUTOR:		valvarado
     #FECHA:		20-04-2020 22:13:29
    ***********************************/

    if (p_transaccion = 'PROTRA_DIG_INS') then

        begin
            v_fecha_hora_desde = cast(
                    concat(v_parametros.fecha_recepcion_desde, ' ', v_parametros.hora_recepcion_desde) as timestamp);
            v_fecha_hora_hasta = cast(
                    concat(v_parametros.fecha_recepcion_hasta, ' ', v_parametros.hora_recepcion_hasta) as timestamp);

            if v_fecha_hora_desde >= v_fecha_hora_hasta then
                v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                            'El campo Fecha Recepción Hasta y la Hora Recepción Hasta deben ser posterior a la Fecha Recepción Desde');
                raise exception '%', v_resp;
            end if;

            v_codigo_tipo_proceso = 'SEG-APDIG';
            select pm.id_proceso_macro
            into
                v_id_proceso_macro
            from wf.tproceso_macro pm
                     left join wf.ttipo_proceso tp on tp.id_proceso_macro = pm.id_proceso_macro
            where tp.codigo = v_codigo_tipo_proceso;

            If v_id_proceso_macro is NULL THEN
                raise exception 'El proceso macro  de codigo % no esta configurado en el sistema WF',v_codigo_tipo_proceso;
            END IF;

            --Obtencion de la gestion #4
            v_fecha = now()::date;
            select per.id_gestion
            into
                v_id_gestion
            from param.tperiodo per
            where per.fecha_ini <= v_fecha
              and per.fecha_fin >= v_fecha
            limit 1
            offset
            0;

            -- inciar el tramite en el sistema de WF   #4
            SELECT ps_num_tramite,
                   ps_id_proceso_wf,
                   ps_id_estado_wf,
                   ps_codigo_estado
            into
                v_num_tramite,
                v_id_proceso_wf,
                v_id_estado_wf,
                v_codigo_estado

            FROM wf.f_inicia_tramite(
                    p_id_usuario,
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    v_id_gestion,
                    v_codigo_tipo_proceso,
                    v_parametros.id_funcionario,
                    null,
                    'Inicio De Aperturas Digitales',
                    '');

            v_codigo = param.f_obtener_correlativo(
                    'AP',
                    null,-- par_id,
                    NULL, --id_uo
                    NULL, -- id_depto
                    1,
                    'PROTRA',
                    null
                );

            --Sentencia de la insercion
            insert into protra.taperturas_digitales(estado_reg,
                                                    fecha_recepcion_desde,
                                                    hora_recepcion_desde,
                                                    fecha_recepcion_hasta,
                                                    hora_recepcion_hasta,
                                                    id_cuenta_correo,
                                                    id_usuario_reg,
                                                    fecha_reg,
                                                    id_usuario_ai,
                                                    usuario_ai,
                                                    id_usuario_mod,
                                                    fecha_mod,
                                                    codigo,
                                                    id_proceso_wf,
                                                    id_estado_wf,
                                                    estado,
                                                    num_tramite,
                                                    id_funcionario)
            values ('activo',
                    v_parametros.fecha_recepcion_desde,
                    v_parametros.hora_recepcion_desde,
                    v_parametros.fecha_recepcion_hasta,
                    v_parametros.hora_recepcion_hasta,
                    v_parametros.id_cuenta_correo,
                    p_id_usuario,
                    now(),
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    null,
                    null,
                    v_codigo,
                    v_id_proceso_wf,
                    v_id_estado_wf,
                    v_codigo_estado,
                    v_num_tramite,
                    v_parametros.id_funcionario)
            RETURNING id_apertura_digital into v_id_apertura_digital;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                        'Aperturas Digitales almacenado(a) con exito (id_apertura_digital' ||
                                        v_id_apertura_digital || ')');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_apertura_digital', v_id_apertura_digital::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'PROTRA_DIG_MOD'
         #DESCRIPCION:	Modificacion de registros
         #AUTOR:		valvarado
         #FECHA:		20-04-2020 22:13:29
        ***********************************/

    elsif (p_transaccion = 'PROTRA_DIG_MOD') then

        begin
            --Sentencia de la modificacion
            select dig.estado
            into v_estado
            from protra.taperturas_digitales dig
            where dig.id_apertura_digital = v_parametros.id_apertura_digital;

            if (v_estado not in ('pendiente', 'borrador')) then
                v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                            'No es posible modificar una Apertura Digital en el estado ' || v_estado);
                raise exception '%', v_resp;
            end if;

            v_fecha_hora_desde = cast(
                    concat(v_parametros.fecha_recepcion_desde, ' ', v_parametros.hora_recepcion_desde) as timestamp);
            v_fecha_hora_hasta = cast(
                    concat(v_parametros.fecha_recepcion_hasta, ' ', v_parametros.hora_recepcion_hasta) as timestamp);

            if v_fecha_hora_desde >= v_fecha_hora_hasta then
                v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                            'El campo Fecha Recepción Hasta y la Hora Recepción Hasta deben ser posterior a la Fecha Recepción Desde');
                raise exception '%', v_resp;
            end if;

            update protra.taperturas_digitales
            set fecha_recepcion_desde = v_parametros.fecha_recepcion_desde,
                hora_recepcion_desde  = v_parametros.hora_recepcion_desde,
                fecha_recepcion_hasta = v_parametros.fecha_recepcion_hasta,
                hora_recepcion_hasta  = v_parametros.hora_recepcion_hasta,
                id_cuenta_correo      = v_parametros.id_cuenta_correo,
                id_usuario_mod        = p_id_usuario,
                fecha_mod             = now(),
                id_usuario_ai         = v_parametros._id_usuario_ai,
                usuario_ai            = v_parametros._nombre_usuario_ai,
                id_funcionario        = v_parametros.id_funcionario
            where id_apertura_digital = v_parametros.id_apertura_digital;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Aperturas Digitales modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_apertura_digital', v_parametros.id_apertura_digital::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;

        /*********************************
         #TRANSACCION:  'PROTRA_DIG_ELI'
         #DESCRIPCION:	Eliminacion de registros
         #AUTOR:		valvarado
         #FECHA:		20-04-2020 22:13:29
        ***********************************/

    elsif (p_transaccion = 'PROTRA_DIG_ELI') then

        begin
            --Sentencia de la eliminacion
            delete
            from protra.taperturas_digitales
            where id_apertura_digital = v_parametros.id_apertura_digital;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Aperturas Digitales eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_apertura_digital', v_parametros.id_apertura_digital::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;
        /*********************************
         #TRANSACCION:  'PROTRA_DIG_ASIGFECHA'
         #DESCRIPCION:	Asignacion de fecha de apertura digital
         #AUTOR:		valvarado
         #FECHA:		20-04-2020 22:13:29
        ***********************************/

    elsif (p_transaccion = 'PROTRA_DIG_ASIGFECHA') then

        begin
            --Sentencia de la eliminacion
            update protra.taperturas_digitales
            set fecha_apertura = now()
            where id_apertura_digital = v_parametros.id_apertura_digital;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Fecha de Apertura establecida');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_apertura_digital', v_parametros.id_apertura_digital::varchar);

            --Devuelve la respuesta
            return v_resp;

        end;
        /*********************************
         #TRANSACCION:  'PROTRA_DIG_SIGEST'
         #DESCRIPCION:	Siguiente estado del proceso
         #AUTOR:		valvarado
         #FECHA:		20-04-2020 22:13:29
        ***********************************/
    elsif (p_transaccion = 'PROTRA_DIG_SIGEST') then
        begin

            select dig.id_proceso_wf,
                   dig.id_estado_wf,
                   dig.estado,
                   dig.num_tramite,
                   dig.id_funcionario
            into
                v_id_proceso_wf,
                v_id_estado_wf,
                v_codigo_estado,
                v_num_tramite,
                v_id_funcionario
            from protra.taperturas_digitales dig
            where dig.id_apertura_digital = v_parametros.id_apertura_digital;

            SELECT *
            into
                va_id_tipo_estado,
                va_codigo_estado,
                va_disparador,
                va_regla,
                va_prioridad
            FROM wf.f_obtener_estado_wf(v_id_proceso_wf, v_id_estado_wf, NULL, 'siguiente');
            v_num_estados = array_length(va_id_tipo_estado, 1);

            v_id_estado_actual = wf.f_registra_estado_wf(va_id_tipo_estado[1],
                                                         v_id_funcionario,
                                                         v_id_estado_wf,
                                                         v_id_proceso_wf,
                                                         p_id_usuario,
                                                         v_parametros._id_usuario_ai,
                                                         v_parametros._nombre_usuario_ai,
                                                         null,
                                                         '');
            if (va_codigo_estado[1] = 'asignado') then
                v_ids_funcionarios_asignados = v_parametros.ids_funcionarios_asignados;
                --Configurar acceso directo para la alarma
                v_acceso_directo = '../../../sis_proceso_trabajo/vista/aperturas_digitales/AperturasDigitales.php';
                v_clase = 'AperturasDigitales';
                v_parametros_ad = '{filtro_directo:{campo:"dig.id_proceso_wf",valor:"' || v_id_proceso_wf::varchar ||
                                  '"}}';
                v_tipo_noti = 'notificacion';
                v_titulo = 'Asignacion';
                FOREACH v_id IN ARRAY v_ids_funcionarios_asignados
                    LOOP
                        SELECT fu.desc_funcionario1,
                               fun.email_empresa
                        INTO
                            v_desc_funcionario1,
                            v_correo
                        FROM orga.tfuncionario fun
                                 LEFT JOIN orga.vfuncionario fu on fu.id_funcionario = fun.id_funcionario
                        WHERE fun.id_funcionario = v_id;
                        v_descripcion_correo =
                                                '<font color="FF0000" size="5"><font size="4">NOTIFICACIÓN DE APERTURAS DIGITALES</font> </font><br><br><b></b>El motivo de la presente es notificarle sobre la asignación de la Apertura Digital con  número de trámite : <b>' ||
                                                v_num_tramite || '</b>.<br>' || v_parametros.obs ||
                                                '.<br>Para mas información comuníquese con los administradores. Saludos<br>';
                        v_titulo = 'Servicio de notificaciones - Aperturas Digitales: ' || v_num_tramite;
                        v_id_alarma = param.f_inserta_alarma(
                                v_id,
                                v_descripcion_correo,--par_descripcion
                                v_acceso_directo,--acceso directo
                                now()::date,--par_fecha: Indica la fecha de vencimiento de la alarma
                                v_tipo_noti, --notificacion
                                v_titulo, --asunto
                                p_id_usuario,
                                v_clase, --clase
                                v_titulo,--titulo
                                v_parametros_ad,--par_parametros varchar,   parametros a mandar a la interface de acceso directo
                                p_id_usuario, --usuario a quien va dirigida la alarma
                                v_titulo,--titulo correo
                                v_correo, --correo funcionario
                                null,--#9
                                v_id_proceso_wf,--#9
                                v_id_estado_actual--#9
                            );
                    END LOOP;
            end if;

            update protra.taperturas_digitales
            set id_estado_wf               = v_id_estado_actual,
                estado                     = va_codigo_estado[1],
                id_usuario_mod             = p_id_usuario,
                fecha_mod                  = now(),
                id_usuario_ai              = v_parametros._id_usuario_ai,
                usuario_ai                 = v_parametros._nombre_usuario_ai,
                ids_funcionarios_asignados = v_ids_funcionarios_asignados
            where id_apertura_digital = v_parametros.id_apertura_digital;

            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'La apertura digital paso al siguiente estado');
            return v_resp;
        end;
        /*********************************
          #TRANSACCION:  'PROTRA_DIG_ANTEST'
          #DESCRIPCION:	Anterior estado del proceso
          #AUTOR:		valvarado
          #FECHA:		20-04-2020 22:13:29
         ***********************************/
    elseif (p_transaccion = 'PROTRA_DIG_ANTEST') then

        begin
            select adig.id_apertura_digital,
                   adig.id_proceso_wf,
                   adig.id_estado_wf,
                   adig.estado,
                   adig.id_funcionario
            into
                v_registros_apertura_digital
            from protra.taperturas_digitales adig
                     inner join wf.testado_wf ew on ew.id_estado_wf = adig.id_estado_wf
            where adig.id_apertura_digital = v_parametros.id_apertura_digital;

            IF v_registros_apertura_digital.estado = 'borrador' or v_registros_apertura_digital.estado = 'asignado' THEN
                raise exception 'No es posible retornar a un estado anterior del actual';
            END IF;

            v_id_proceso_wf = v_registros_apertura_digital.id_proceso_wf;
            select ps_id_tipo_estado,
                   ps_id_funcionario,
                   ps_id_usuario_reg,
                   ps_codigo_estado,
                   ps_id_estado_wf_ant
            into
                v_id_tipo_estado,
                v_id_funcionario,
                v_id_usuario_reg,
                v_codigo_estado,
                v_id_estado_wf_ant
            from wf.f_obtener_estado_ant_log_wf(v_parametros.id_estado_wf);

            --Registra nuevo estado
            v_id_estado_actual = wf.f_registra_estado_wf(
                    v_id_tipo_estado,
                    v_id_funcionario,
                    v_parametros.id_estado_wf,
                    v_id_proceso_wf,
                    p_id_usuario,
                    v_parametros._id_usuario_ai,
                    v_parametros._nombre_usuario_ai,
                    null,
                    '[RETROCESO] ' || v_parametros.obs);

            update protra.taperturas_digitales
            set id_estado_wf   = v_id_estado_actual,
                estado         = v_codigo_estado,
                id_usuario_mod = p_id_usuario,
                fecha_mod      = now(),
                id_usuario_ai  = v_parametros._id_usuario_ai,
                usuario_ai     = v_parametros._nombre_usuario_ai
            where id_apertura_digital = v_parametros.id_apertura_digital;

            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Los cambios fueron realizados correctamente.');
            v_resp = pxp.f_agrega_clave(v_resp, 'operacion', 'cambio_exitoso');

            return v_resp;

        end;
    else

        raise exception 'Transaccion inexistente: %',p_transaccion;

    end if;

EXCEPTION

    WHEN OTHERS THEN
        v_resp = '';
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
        v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
        v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
        raise exception '%',v_resp;

END;
$BODY$
    LANGUAGE 'plpgsql' VOLATILE
                       COST 100;
ALTER FUNCTION "protra"."ft_aperturas_digitales_ime"(integer, integer, character varying, character varying) OWNER TO postgres;

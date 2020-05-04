<?php
/**
 * @package pXP
 * @file MODAperturasDigitales.php
 * @author  (valvarado)
 * @date 20-04-2020 22:13:29
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                20-04-2020 22:13:29                                CREACION
 */

class MODImportador extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarAperturasDigitales()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'protra.ft_aperturas_digitales_sel';
        $this->transaccion = 'PROTRA_DIG_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->tipo_conexion = 'seguridad';
        $this->setCount(false);
        $this->resetCaptura();
        $this->addConsulta();
        //Definicion de la lista del resultado del query
        $this->captura('id_apertura_digital', 'int4');
        $this->captura('id_cuenta_correo', 'int4');
        $this->captura('estado_reg', 'varchar');
        $this->captura('codigo', 'varchar');
        $this->captura('obs_dba', 'varchar');
        $this->captura('fecha_recepcion_desde', 'date');
        $this->captura('hora_recepcion_desde', 'time');
        $this->captura('fecha_recepcion_hasta', 'date');
        $this->captura('hora_recepcion_hasta', 'time');
        $this->captura('correo', 'varchar');
        $this->captura('descripcion', 'varchar');
        $this->captura('id_usuario_reg', 'int4');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('id_usuario_ai', 'int4');
        $this->captura('usuario_ai', 'varchar');
        $this->captura('id_usuario_mod', 'int4');
        $this->captura('fecha_mod', 'timestamp');
        $this->captura('usr_reg', 'varchar');
        $this->captura('usr_mod', 'varchar');
        $this->captura('id_proceso_wf', 'int4');
        $this->captura('id_estado_wf', 'int4');
        $this->captura('estado', 'varchar');
        $this->captura('num_tramite', 'varchar');
        $this->captura('desc_funcionario1', 'text');
        $this->captura('id_funcionario', 'int4');
        $this->captura('fecha_apertura', 'timestamp');
        $this->captura('ids_funcionarios_asignados', 'integer[]');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        $this->resetParametros();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarCuentasCorreo()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'protra.ft_cuentas_correo_sel';
        $this->transaccion = 'PROTRA_CUECO_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->tipo_conexion = 'seguridad';
        $this->setCount(false);
        $this->resetCaptura();
        $this->addConsulta();
        //Definicion de la lista del resultado del query
        $this->captura('id_cuenta_correo', 'int4');
        $this->captura('estado_reg', 'varchar');
        $this->captura('obs_dba', 'varchar');
        $this->captura('host', 'varchar');
        $this->captura('port', 'int4');
        $this->captura('usuario', 'varchar');
        $this->captura('contrasena', 'varchar');
        $this->captura('encrypto', 'varchar');
        $this->captura('carpeta', 'varchar');
        $this->captura('correo', 'varchar');
        $this->captura('descripcion', 'varchar');
        $this->captura('id_usuario_reg', 'int4');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('id_usuario_ai', 'int4');
        $this->captura('usuario_ai', 'varchar');
        $this->captura('id_usuario_mod', 'int4');
        $this->captura('fecha_mod', 'timestamp');
        $this->captura('usr_reg', 'varchar');
        $this->captura('usr_mod', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        $this->resetParametros();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarAperturasDigitalesDet()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'protra.ft_aperturas_digitales_det_sel';
        $this->transaccion = 'PROTRA_ADIGD_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->tipo_conexion = 'seguridad';
        $this->setCount(false);
        $this->resetCaptura();
        $this->addConsulta();
        //Definicion de la lista del resultado del query
        $this->captura('id_apertura_digital_det', 'int4');
        $this->captura('estado_reg', 'varchar');
        $this->captura('obs_dba', 'varchar');
        $this->captura('uid_email', 'int4');
        $this->captura('numero_email', 'int4');
        $this->captura('remitente_email', 'varchar');
        $this->captura('asunto_email', 'varchar');
        $this->captura('fecha_recepcion_email', 'timestamp');
        $this->captura('id_apertura_digital', 'int4');
        $this->captura('id_usuario_reg', 'int4');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('id_usuario_ai', 'int4');
        $this->captura('usuario_ai', 'varchar');
        $this->captura('id_usuario_mod', 'int4');
        $this->captura('fecha_mod', 'timestamp');
        $this->captura('usr_reg', 'varchar');
        $this->captura('usr_mod', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        $this->resetParametros();
        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarAperturasDigitalesDet()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->resetParametros();
        $this->procedimiento = 'protra.ft_aperturas_digitales_det_ime';
        $this->transaccion = 'PROTRA_ADIGD_INS';
        $this->tipo_procedimiento = 'IME';
        $this->tipo_conexion = 'seguridad';
        //Define los parametros para la funcion
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('obs_dba', 'obs_dba', 'varchar');
        $this->setParametro('uid_email', 'uid_email', 'int4');
        $this->setParametro('numero_email', 'numero_email', 'int4');
        $this->setParametro('remitente_email', 'remitente_email', 'varchar');
        $this->setParametro('asunto_email', 'asunto_email', 'varchar');
        $this->setParametro('fecha_recepcion_email', 'fecha_recepcion_email', 'timestamp');
        $this->setParametro('id_apertura_digital', 'id_apertura_digital', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function asignarFechaApertura()
    {

        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_ime';
        $this->transaccion = 'PROTRA_DIG_ASIGFECHA';
        $this->tipo_procedimiento = 'IME';
        $this->tipo_conexion = 'seguridad';
        //Define los parametros para la funcion
        $this->setParametro('id_apertura_digital', 'id_apertura_digital', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }


    function obtenerFuncionario()
    {
        $this->procedimiento = 'orga.ft_funcionario_sel';
        $this->transaccion = 'RH_FUNCIOCAR_SEL';
        $this->tipo_procedimiento = 'SEL';
        $this->tipo_conexion = 'seguridad';
        $this->setCount(false);
        $this->setParametro('estado_reg_fun', 'estado_reg_fun', 'varchar');
        $this->setParametro('estado_reg_asi', 'estado_reg_asi', 'varchar');
        $this->captura('id_uo_funcionario', 'integer');
        $this->captura('id_funcionario', 'integer');
        $this->captura('desc_funcionario1', 'text');
        $this->captura('desc_funcionario2', 'text');
        $this->captura('id_uo', 'integer');
        $this->captura('nombre_cargo', 'varchar');
        $this->captura('fecha_asignacion', 'date');
        $this->captura('fecha_finalizacion', 'date');
        $this->captura('num_doc', 'integer');
        $this->captura('ci', 'varchar');
        $this->captura('codigo', 'varchar');
        $this->captura('email_empresa', 'varchar');
        $this->captura('estado_reg_fun', 'varchar');
        $this->captura('estado_reg_asi', 'varchar');
        $this->captura('id_cargo', 'integer');
        $this->captura('descripcion_cargo', 'varchar');
        $this->captura('cargo_codigo', 'varchar');
        $this->captura('id_lugar', 'integer');
        $this->captura('id_oficina', 'integer');
        $this->captura('lugar_nombre', 'varchar');
        $this->captura('oficina_nombre', 'varchar');

        $this->setParametro('antiguedad_anterior', 'antiguedad_anterior', 'varchar');

        $this->armarConsulta();
        $this->ejecutarConsulta();
        $this->resetParametros();
        return $this->respuesta;
    }
}

?>
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

class MODAperturasDigitales extends MODbase
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
        $this->setParametro('id_funcionario', 'id_funcionario', 'int4');
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
        $this->captura('email_empresa', 'varchar');
        $this->captura('codigo_proceso', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarAperturasDigitales()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_ime';
        $this->transaccion = 'PROTRA_DIG_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_funcionario', 'id_funcionario', 'int4');
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('obs_dba', 'obs_dba', 'varchar');
        $this->setParametro('fecha_recepcion_desde', 'fecha_recepcion_desde', 'date');
        $this->setParametro('hora_recepcion_desde', 'hora_recepcion_desde', 'time');
        $this->setParametro('fecha_recepcion_hasta', 'fecha_recepcion_hasta', 'date');
        $this->setParametro('hora_recepcion_hasta', 'hora_recepcion_hasta', 'time');
        $this->setParametro('id_cuenta_correo', 'id_cuenta_correo', 'int4');
        $this->setParametro('codigo_proceso', 'codigo_proceso', 'varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function modificarAperturasDigitales()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_ime';
        $this->transaccion = 'PROTRA_DIG_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_funcionario', 'id_funcionario', 'int4');
        $this->setParametro('id_apertura_digital', 'id_apertura_digital', 'int4');
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('obs_dba', 'obs_dba', 'varchar');
        $this->setParametro('fecha_recepcion_desde', 'fecha_recepcion_desde', 'date');
        $this->setParametro('hora_recepcion_desde', 'hora_recepcion_desde', 'time');
        $this->setParametro('fecha_recepcion_hasta', 'fecha_recepcion_hasta', 'date');
        $this->setParametro('hora_recepcion_hasta', 'hora_recepcion_hasta', 'time');
        $this->setParametro('id_cuenta_correo', 'id_cuenta_correo', 'int4');
        $this->setParametro('codigo_proceso', 'codigo_proceso', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function eliminarAperturasDigitales()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_ime';
        $this->transaccion = 'PROTRA_DIG_ELI';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_apertura_digital', 'id_apertura_digital', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function siguienteEstado()
    {

        $this->procedimiento = 'protra.ft_aperturas_digitales_ime';
        $this->transaccion = 'PROTRA_DIG_SIGEST';
        $this->tipo_procedimiento = 'IME';

        $this->setParametro('id_apertura_digital', 'id_apertura_digital', 'int4');
        $this->setParametro('id_proceso_wf_act', 'id_proceso_wf_act', 'int4');
        $this->setParametro('id_estado_wf_act', 'id_estado_wf_act', 'int4');
        $this->setParametro('id_funcionario_usu', 'id_funcionario_usu', 'int4');
        $this->setParametro('id_tipo_estado', 'id_tipo_estado', 'int4');
        $this->setParametro('id_funcionario_wf', 'id_funcionario_wf', 'int4');
        $this->setParametro('id_depto_wf', 'id_depto_wf', 'int4');
        $this->setParametro('obs', 'obs', 'text');
        $this->setParametro('json_procesos', 'json_procesos', 'text');
        $this->setParametro('ids_funcionarios_asignados', 'ids_funcionarios_asignados', 'integer[]');
        $this->armarConsulta();
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function anteriorEstado()
    {

        $this->procedimiento = 'protra.ft_aperturas_digitales_ime';
        $this->transaccion = 'PROTRA_DIG_ANTEST';
        $this->tipo_procedimiento = 'IME';

        $this->setParametro('id_apertura_digital', 'id_apertura_digital', 'int4');
        $this->setParametro('id_proceso_wf_act', 'id_proceso_wf_act', 'int4');
        $this->setParametro('id_estado_wf', 'id_estado_wf', 'int4');
        $this->setParametro('id_funcionario_usu', 'id_funcionario_usu', 'int4');
        $this->setParametro('id_tipo_estado', 'id_tipo_estado', 'int4');
        $this->setParametro('id_funcionario_wf', 'id_funcionario_wf', 'int4');
        $this->setParametro('id_depto_wf', 'id_depto_wf', 'int4');
        $this->setParametro('obs', 'obs', 'text');
        $this->setParametro('json_procesos', 'json_procesos', 'text');

        $this->armarConsulta();
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

}

?>
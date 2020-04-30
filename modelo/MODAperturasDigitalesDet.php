<?php
/**
 * @package pXP
 * @file MODAperturasDigitalesDet.php
 * @author  (valvarado)
 * @date 21-04-2020 23:09:51
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                21-04-2020 23:09:51                                CREACION
 */

class MODAperturasDigitalesDet extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarAperturasDigitalesDet()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'protra.ft_aperturas_digitales_det_sel';
        $this->transaccion = 'PROTRA_ADIGD_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion

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

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarAperturasDigitalesDet()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_det_ime';
        $this->transaccion = 'PROTRA_ADIGD_INS';
        $this->tipo_procedimiento = 'IME';

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

    function modificarAperturasDigitalesDet()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_det_ime';
        $this->transaccion = 'PROTRA_ADIGD_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_apertura_digital_det', 'id_apertura_digital_det', 'int4');
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

    function eliminarAperturasDigitalesDet()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_aperturas_digitales_det_ime';
        $this->transaccion = 'PROTRA_ADIGD_ELI';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_apertura_digital_det', 'id_apertura_digital_det', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

}

?>
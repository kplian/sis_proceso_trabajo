<?php
/**
 * @package pXP
 * @file MODCuentasCorreo.php
 * @author  (valvarado)
 * @date 22-04-2020 23:57:33
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                22-04-2020 23:57:33                                CREACION
 */

class MODCuentasCorreo extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarCuentasCorreo()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'protra.ft_cuentas_correo_sel';
        $this->transaccion = 'PROTRA_CUECO_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion

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
        $this->captura('texto_asunto_confirmacion', 'text');
        $this->captura('texto_mensaje_confirmacion', 'text');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarCuentasCorreo()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_cuentas_correo_ime';
        $this->transaccion = 'PROTRA_CUECO_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('obs_dba', 'obs_dba', 'varchar');
        $this->setParametro('host', 'host', 'varchar');
        $this->setParametro('port', 'port', 'int4');
        $this->setParametro('usuario', 'usuario', 'varchar');
        $this->setParametro('contrasena', 'contrasena', 'varchar');
        $this->setParametro('encrypto', 'encrypto', 'varchar');
        $this->setParametro('carpeta', 'carpeta', 'varchar');
        $this->setParametro('correo', 'correo', 'varchar');
        $this->setParametro('descripcion', 'descripcion', 'varchar');
        $this->setParametro('texto_asunto_confirmacion', 'texto_asunto_confirmacion', 'codigo_html');
        $this->setParametro('texto_mensaje_confirmacion', 'texto_mensaje_confirmacion', 'codigo_html');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function modificarCuentasCorreo()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_cuentas_correo_ime';
        $this->transaccion = 'PROTRA_CUECO_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_cuenta_correo', 'id_cuenta_correo', 'int4');
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('obs_dba', 'obs_dba', 'varchar');
        $this->setParametro('host', 'host', 'varchar');
        $this->setParametro('port', 'port', 'int4');
        $this->setParametro('usuario', 'usuario', 'varchar');
        $this->setParametro('contrasena', 'contrasena', 'varchar');
        $this->setParametro('encrypto', 'encrypto', 'varchar');
        $this->setParametro('carpeta', 'carpeta', 'varchar');
        $this->setParametro('correo', 'correo', 'varchar');
        $this->setParametro('descripcion', 'descripcion', 'varchar');
        $this->setParametro('texto_asunto_confirmacion', 'texto_asunto_confirmacion', 'codigo_html');
        $this->setParametro('texto_mensaje_confirmacion', 'texto_mensaje_confirmacion', 'codigo_html');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function eliminarCuentasCorreo()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_cuentas_correo_ime';
        $this->transaccion = 'PROTRA_CUECO_ELI';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_cuenta_correo', 'id_cuenta_correo', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

}

?>
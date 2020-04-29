<?php
/**
*@package pXP
*@file gen-MODVpn.php
*@author  (egutierrez)
*@date 12-04-2020 17:37:52
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-04-2020 17:37:52								CREACION

*/

class MODVpn extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarVpn(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='protra.ft_vpn_sel';
		$this->transaccion='PROTRA_SOLVPN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');
        $this->setParametro('estado','estado','varchar');
        $this->setParametro('nombreVista','nombreVista','varchar');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_vpn','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('fecha_desde','date');
		$this->captura('fecha_hasta','date');
		$this->captura('descripcion','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');

        $this->captura('id_proceso_wf','int4');
        $this->captura('id_estado_wf','int4');
        $this->captura('nro_tramite','varchar');
        $this->captura('estado','varchar');
        $this->captura('desc_funcionario','varchar');
        $this->captura('desc_funcionario_responsable','varchar');
        $this->captura('obs','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarVpn(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='protra.ft_vpn_ime';
		$this->transaccion='PROTRA_SOLVPN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('fecha_desde','fecha_desde','date');
		$this->setParametro('fecha_hasta','fecha_hasta','date');
		$this->setParametro('descripcion','descripcion','varchar');
        $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
        $this->setParametro('id_estado_wf','id_estado_wf','int4');
        $this->setParametro('nro_tramite','nro_tramite','varchar');
        $this->setParametro('estado','estado','varchar');

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarVpn(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='protra.ft_vpn_ime';
		$this->transaccion='PROTRA_SOLVPN_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_vpn','id_vpn','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('fecha_desde','fecha_desde','date');
		$this->setParametro('fecha_hasta','fecha_hasta','date');
		$this->setParametro('descripcion','descripcion','varchar');

        $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
        $this->setParametro('id_estado_wf','id_estado_wf','int4');
        $this->setParametro('nro_tramite','nro_tramite','varchar');
        $this->setParametro('estado','estado','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarVpn(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='protra.ft_vpn_ime';
		$this->transaccion='PROTRA_SOLVPN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_vpn','id_vpn','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
    function siguienteEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'protra.ft_vpn_ime';
        $this->transaccion = 'PROTRA_SIGEVPN_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_vpn','id_vpn','int4');
        $this->setParametro('id_proceso_wf_act','id_proceso_wf_act','int4');
        $this->setParametro('id_estado_wf_act','id_estado_wf_act','int4');
        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');
        $this->setParametro('id_tipo_estado','id_tipo_estado','int4');
        $this->setParametro('id_funcionario_wf','id_funcionario_wf','int4');
        $this->setParametro('id_depto_wf','id_depto_wf','int4');
        $this->setParametro('obs','obs','text');
        $this->setParametro('json_procesos','json_procesos','text');

        $this->setParametro('id_depto_lb','id_depto_lb','int4');
        $this->setParametro('id_cuenta_bancaria','id_cuenta_bancaria','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function anteriorEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='protra.ft_vpn_ime';
        $this->transaccion='PRO_ANTEVPN_IME';
        $this->tipo_procedimiento='IME';
        //Define los parametros para la funcion
        $this->setParametro('id_vpn','id_vpn','int4');
        $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
        $this->setParametro('id_estado_wf','id_estado_wf','int4');
        $this->setParametro('obs','obs','varchar');
        $this->setParametro('estado_destino','estado_destino','varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarVpnCompleto(){

        //Abre conexion con PDO
        $cone = new conexion();
        $link = $cone->conectarpdo();
        $copiado = false;
        try {
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->beginTransaction();

            /////////////////////////
            //  inserta cabecera de la solicitud de compra
            ///////////////////////

            //Definicion de variables para ejecucion del procedimiento
            $this->procedimiento='protra.ft_vpn_ime';
            $this->transaccion='PROTRA_SOLVPN_INS';
            $this->tipo_procedimiento='IME';

            //Define los parametros para la funcion
            $this->setParametro('estado_reg','estado_reg','varchar');
            $this->setParametro('id_funcionario','id_funcionario','int4');
            $this->setParametro('fecha_desde','fecha_desde','date');
            $this->setParametro('fecha_hasta','fecha_hasta','date');
            $this->setParametro('descripcion','descripcion','varchar');
            $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
            $this->setParametro('id_estado_wf','id_estado_wf','int4');
            $this->setParametro('nro_tramite','nro_tramite','varchar');
            $this->setParametro('estado','estado','varchar');

            //Ejecuta la instruccion
            $this->armarConsulta();
            $stmt = $link->prepare($this->consulta);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //recupera parametros devuelto depues de insertar ... (id_solicitud)
            $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
            if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                throw new Exception("Error al ejecutar en la bd", 3);
            }

            $respuesta = $resp_procedimiento['datos'];
            $id_vpn = $respuesta['id_vpn'];

            //////////////////////////////////////////////
            //inserta detalle de la compra o venta
            /////////////////////////////////////////////

                //decodifica JSON  de detalles
                $json_detalle = $this->aParam->_json_decode($this->aParam->getParametro('json_new_records'));

                foreach($json_detalle as $f){

                    $this->resetParametros();
                    //Definicion de variables para ejecucion del procedimiento
                    $this->procedimiento='protra.ft_vpn_det_ime';
                    $this->transaccion='PROTRA_VPNDET_INS';
                    $this->tipo_procedimiento='IME';

                    //modifica los valores de las variables que mandaremos
                    $this->arreglo['estado_reg'] = $f['estado_reg'];
                    $this->arreglo['id_vpn'] = $id_vpn;
                    $this->arreglo['sistema'] = $f['sistema'];
                    $this->arreglo['justificacion'] = $f['justificacion'];


                    //throw new Exception("cantidad ...modelo...".$f['cantidad'], 1);

                    //Define los parametros para la funcion
                    //Define los parametros para la funcion
                    $this->setParametro('estado_reg','estado_reg','varchar');
                    $this->setParametro('id_vpn','id_vpn','integer');
                    $this->setParametro('sistema','sistema','varchar');
                    $this->setParametro('justificacion','justificacion','varchar');

                    //Ejecuta la instruccion
                    $this->armarConsulta();
                    $stmt = $link->prepare($this->consulta);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    //recupera parametros devuelto depues de insertar ... (id_solicitud)
                    $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
                    if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                        throw new Exception("Error al insertar detalle  en la bd", 3);
                    }
                }



            //si todo va bien confirmamos y regresamos el resultado
            $link->commit();
            $this->respuesta=new Mensaje();
            $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            $this->respuesta->setDatos($respuesta);
        }
        catch (Exception $e) {
            $link->rollBack();
            $this->respuesta=new Mensaje();
            if ($e->getCode() == 3) {//es un error de un procedimiento almacenado de pxp
                $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            } else if ($e->getCode() == 2) {//es un error en bd de una consulta
                $this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
            } else {//es un error lanzado con throw exception
                throw new Exception($e->getMessage(), 2);
            }

        }

        return $this->respuesta;
    }


    function modificarVpnCompleto(){

        //Abre conexion con PDO
        $cone = new conexion();
        $link = $cone->conectarpdo();
        $copiado = false;
        try {
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->beginTransaction();

            /////////////////////////
            //  inserta cabecera de la solicitud de compra
            ///////////////////////

            //Definicion de variables para ejecucion del procedimiento
            $this->procedimiento='protra.ft_vpn_ime';
            $this->transaccion='PROTRA_SOLVPN_MOD';
            $this->tipo_procedimiento='IME';

            //Define los parametros para la funcion
            $this->setParametro('id_vpn','id_vpn','int4');
            $this->setParametro('estado_reg','estado_reg','varchar');
            $this->setParametro('id_funcionario','id_funcionario','int4');
            $this->setParametro('fecha_desde','fecha_desde','date');
            $this->setParametro('fecha_hasta','fecha_hasta','date');
            $this->setParametro('descripcion','descripcion','varchar');

            $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
            $this->setParametro('id_estado_wf','id_estado_wf','int4');
            $this->setParametro('nro_tramite','nro_tramite','varchar');
            $this->setParametro('estado','estado','varchar');

            //Ejecuta la instruccion
            $this->armarConsulta();
            $stmt = $link->prepare($this->consulta);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //recupera parametros devuelto depues de insertar ... (id_solicitud)
            $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
            if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                throw new Exception("Error al ejecutar en la bd", 3);
            }

            $respuesta = $resp_procedimiento['datos'];

            $id_vpn = $respuesta['id_vpn'];

            //////////////////////////////////////////////
            //inserta detalle de la compra o venta
            /////////////////////////////////////////////



            //decodifica JSON  de detalles
            $json_detalle = $this->aParam->_json_decode($this->aParam->getParametro('json_new_records'));

            //var_dump($json_detalle)	;

            foreach($json_detalle as $f){

                $this->resetParametros();
                //Definicion de variables para ejecucion del procedimiento


                //modifica los valores de las variables que mandaremos

                $this->arreglo['estado_reg'] = $f['estado_reg'];
                $this->arreglo['id_vpn'] = $id_vpn;
                $this->arreglo['sistema'] = $f['sistema'];
                $this->arreglo['justificacion'] = $f['justificacion'];
                $this->arreglo['id_vpn_det'] = $f['id_vpn_det'];

                $this->procedimiento='protra.ft_vpn_det_ime';
                $this->tipo_procedimiento='IME';
                //si tiene ID modificamos

                if ( isset($this->arreglo['id_vpn_det']) && $this->arreglo['id_vpn_det'] != ''){
                    $this->transaccion='PROTRA_VPNDET_MOD';
                }
                else{
                    //si no tiene ID insertamos
                    $this->transaccion='PROTRA_VPNDET_INS';
                }
                //throw new Exception("cantidad ...modelo...".$f['cantidad'], 1);

                //Define los parametros para la funcion
                $this->setParametro('id_vpn_det','id_vpn_det','int4');
                $this->setParametro('id_vpn','id_vpn','integer');
                $this->setParametro('estado_reg','estado_reg','varchar');
                $this->setParametro('sistema','sistema','varchar');
                $this->setParametro('justificacion','justificacion','varchar');


                //Ejecuta la instruccion
                $this->armarConsulta();
                $stmt = $link->prepare($this->consulta);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                //recupera parametros devuelto depues de insertar ... (id_solicitud)
                $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
                if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                    throw new Exception("Error al insertar detalle  en la bd", 3);
                }


            }
                /////////////////////////////
                //elimia conceptos marcado
                ///////////////////////////

                $this->procedimiento='protra.ft_vpn_det_ime';
                $this->transaccion='PROTRA_VPNDET_ELI';
                $this->tipo_procedimiento='IME';

                $id_vpn_det_elis = explode(",", $this->aParam->getParametro('id_vpn_det_elis'));
                //var_dump($json_detalle)	;
                for( $i=0; $i<count($id_vpn_det_elis); $i++){

                    $this->resetParametros();
                    $this->arreglo['id_vpn_det'] = $id_vpn_det_elis[$i];
                    //Define los parametros para la funcion
                    $this->setParametro('id_vpn_det','id_vpn_det','int4');
                    //Ejecuta la instruccion
                    $this->armarConsulta();
                    $stmt = $link->prepare($this->consulta);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    //recupera parametros devuelto depues de insertar ... (id_solicitud)
                    $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
                    if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                        throw new Exception("Error al eliminar concepto  en la bd", 3);
                    }

                }



            //si todo va bien confirmamos y regresamos el resultado
            $link->commit();
            $this->respuesta=new Mensaje();
            $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            $this->respuesta->setDatos($respuesta);
        }
        catch (Exception $e) {
            $link->rollBack();
            $this->respuesta=new Mensaje();
            if ($e->getCode() == 3) {//es un error de un procedimiento almacenado de pxp
                $this->respuesta->setMensaje($resp_procedimiento['tipo_respuesta'],$this->nombre_archivo,$resp_procedimiento['mensaje'],$resp_procedimiento['mensaje_tec'],'base',$this->procedimiento,$this->transaccion,$this->tipo_procedimiento,$this->consulta);
            } else if ($e->getCode() == 2) {//es un error en bd de una consulta
                $this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
            } else {//es un error lanzado con throw exception
                throw new Exception($e->getMessage(), 2);
            }

        }

        return $this->respuesta;
    }




}
?>
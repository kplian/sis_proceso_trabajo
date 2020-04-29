<?php
/**
*@package pXP
*@file gen-ACTVpn.php
*@author  (egutierrez)
*@date 12-04-2020 17:37:52
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-04-2020 17:37:52								CREACION

*/

class ACTVpn extends ACTbase{    
			
	function listarVpn(){
        $this->objParam->addParametro('id_funcionario_usu',$_SESSION["ss_id_funcionario"]);
        $this->objParam->defecto('ordenacion','id_vpn');

       if ($this->objParam->getParametro('nombreVista') == 'VpnVoBo') {
           $this->objParam->addFiltro("solvpn.estado in (''vobo'',''voboti'',''voboseg'')");
       }


		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODVpn','listarVpn');
		} else{
			$this->objFunc=$this->create('MODVpn');
			
			$this->res=$this->objFunc->listarVpn($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarVpn(){
		$this->objFunc=$this->create('MODVpn');	
		if($this->objParam->insertar('id_vpn')){
			$this->res=$this->objFunc->insertarVpn($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarVpn($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarVpn(){
			$this->objFunc=$this->create('MODVpn');	
		$this->res=$this->objFunc->eliminarVpn($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    function siguienteEstado(){
        $this->objFunc=$this->create('MODVpn');
        $this->res=$this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function anteriorEstado(){
        $this->objFunc=$this->create('MODVpn');
        $this->res=$this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function insertarVpnCompleto(){
        $this->objFunc=$this->create('MODVpn');
        if($this->objParam->insertar('id_vpn')){
            $this->res=$this->objFunc->insertarVpnCompleto($this->objParam);
        } else{
            //TODO
            //$this->res=$this->objFunc->modificarSolicitud($this->objParam);
            //trabajar en la modificacion compelta de solicitud ....
            $this->res=$this->objFunc->modificarVpnCompleto($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>
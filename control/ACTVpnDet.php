<?php
/**
*@package pXP
*@file gen-ACTVpnDet.php
*@author  (egutierrez)
*@date 13-04-2020 18:43:37
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				13-04-2020 18:43:37								CREACION

*/

class ACTVpnDet extends ACTbase{    
			
	function listarVpnDet(){
		$this->objParam->defecto('ordenacion','id_vpn_det');
        if ($this->objParam->getParametro('id_vpn') != '') {
                 $this->objParam->addFiltro("vpndet.id_vpn = ''" . $this->objParam->getParametro('id_vpn') . "''");
        }
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODVpnDet','listarVpnDet');
		} else{
			$this->objFunc=$this->create('MODVpnDet');
			
			$this->res=$this->objFunc->listarVpnDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarVpnDet(){
		$this->objFunc=$this->create('MODVpnDet');	
		if($this->objParam->insertar('id_vpn_det')){
			$this->res=$this->objFunc->insertarVpnDet($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarVpnDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarVpnDet(){
			$this->objFunc=$this->create('MODVpnDet');	
		$this->res=$this->objFunc->eliminarVpnDet($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>
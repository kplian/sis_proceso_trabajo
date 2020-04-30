<?php
/**
 * @package pXP
 * @file ACTCuentasCorreo.php
 * @author  (valvarado)
 * @date 22-04-2020 23:57:33
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                22-04-2020 23:57:33                                CREACION
 */

class ACTCuentasCorreo extends ACTbase
{

    function listarCuentasCorreo()
    {
        $this->objParam->defecto('ordenacion', 'id_cuenta_correo');

        $this->objParam->defecto('dir_ordenacion', 'asc');
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODCuentasCorreo', 'listarCuentasCorreo');
        } else {
            $this->objFunc = $this->create('MODCuentasCorreo');

            $this->res = $this->objFunc->listarCuentasCorreo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarCuentasCorreo()
    {
        $this->objFunc = $this->create('MODCuentasCorreo');
        if ($this->objParam->insertar('id_cuenta_correo')) {
            $this->res = $this->objFunc->insertarCuentasCorreo($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarCuentasCorreo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarCuentasCorreo()
    {
        $this->objFunc = $this->create('MODCuentasCorreo');
        $this->res = $this->objFunc->eliminarCuentasCorreo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

}

?>
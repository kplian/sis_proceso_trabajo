<?php
/**
 * @package pXP
 * @file ACTAperturasDigitales.php
 * @author  (valvarado)
 * @date 20-04-2020 22:13:29
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                20-04-2020 22:13:29                                CREACION
 */

class ACTAperturasDigitales extends ACTbase
{

    function listarAperturasDigitales()
    {
        $this->objParam->defecto('ordenacion', 'id_apertura_digital');
        $this->objParam->defecto('dir_ordenacion', 'asc');

        if ($this->objParam->getParametro("id_funcionario") != "") {
            $this->objParam->addFiltro('dig.id_funcionario =' . $this->objParam->getParametro("id_funcionario"));
        }

        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODAperturasDigitales', 'listarAperturasDigitales');
        } else {
            $this->objFunc = $this->create('MODAperturasDigitales');

            $this->res = $this->objFunc->listarAperturasDigitales($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarAperturasDigitales()
    {
        $this->objFunc = $this->create('MODAperturasDigitales');
        if ($this->objParam->insertar('id_apertura_digital')) {
            $this->res = $this->objFunc->insertarAperturasDigitales($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarAperturasDigitales($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarAperturasDigitales()
    {
        $this->objFunc = $this->create('MODAperturasDigitales');
        $this->res = $this->objFunc->eliminarAperturasDigitales($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function siguienteEstado()
    {
        $this->objParam->addParametro('ids_funcionarios_asignados', $this->objParam->getParametro('ids_funcionarios_asignados'));
        $this->objFunc = $this->create('MODAperturasDigitales');

        $this->res = $this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function anteriorEstado()
    {
        $this->objFunc = $this->create('MODAperturasDigitales');

        $this->res = $this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}

?>
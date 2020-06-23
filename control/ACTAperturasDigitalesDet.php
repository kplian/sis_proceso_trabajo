<?php
/**
 * @package pXP
 * @file ACTAperturasDigitalesDet.php
 * @author  (valvarado)
 * @date 21-04-2020 23:09:51
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                21-04-2020 23:09:51                                CREACION
 */
include_once dirname(__DIR__) . '/lib/ImapLibrary.php';

class ACTAperturasDigitalesDet extends ACTbase
{

    function listarAperturasDigitalesDet()
    {
        $this->objParam->defecto('ordenacion', 'id_apertura_digital_det');
        if ($this->objParam->getParametro('id_apertura_digital') != '') {
            $this->objParam->addFiltro("adigd.id_apertura_digital = ''" . $this->objParam->getParametro('id_apertura_digital') . "''");
        }

        if ($this->objParam->getParametro('aceptado') != '') {
            $this->objParam->addFiltro("adigd.aceptado = ''" . $this->objParam->getParametro('aceptado') . "''");
        }

        $this->objParam->defecto('dir_ordenacion', 'asc');
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODAperturasDigitalesDet', 'listarAperturasDigitalesDet');
        } else {
            $this->objFunc = $this->create('MODAperturasDigitalesDet');

            $this->res = $this->objFunc->listarAperturasDigitalesDet($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarAperturasDigitalesDet()
    {
        $this->objFunc = $this->create('MODAperturasDigitalesDet');
        if ($this->objParam->insertar('id_apertura_digital_det')) {
            $this->res = $this->objFunc->insertarAperturasDigitalesDet($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarAperturasDigitalesDet($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarAperturasDigitalesDet()
    {
        $this->objFunc = $this->create('MODAperturasDigitalesDet');
        $this->res = $this->objFunc->eliminarAperturasDigitalesDet($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function importarCorreos()
    {
        $this->objParam->addParametroConsulta('ordenacion', 'id_apertura_digital');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'desc');
        $this->objParam->addParametroConsulta('cantidad', 100000);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        if ($this->objParam->getParametro('id_apertura_digital') != '') {
            $this->objParam->addFiltro(" dig.id_apertura_digital = " . $this->objParam->getParametro('id_apertura_digital') . "");
        } else {
            $this->objParam->addFiltro(" dig.estado = ''pendiente'' ");
        }

        $this->objFunc = $this->create('MODImportador');
        $rs = $this->objFunc->listarAperturasDigitales($this->objParam);

        if ($rs->getTipo() == 'EXITO') {
            $datos = $rs->getDatos();
            foreach ($datos as $apertura) {
                $this->objParam->addParametroConsulta('ordenacion', 'id_cuenta_correo');
                $this->objParam->addParametroConsulta('dir_ordenacion', 'desc');
                $this->objParam->addParametroConsulta('cantidad', 1);
                $this->objParam->addParametroConsulta('puntero', 0);
                $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
                $this->objParam->addFiltro(" cueco.id_cuenta_correo = " . $apertura['id_cuenta_correo'] . "");

                $this->objFunc1 = $this->create('MODImportador');
                $rs1 = $this->objFunc1->listarCuentasCorreo($this->objParam);
                if ($rs1->getTipo() == 'EXITO') {
                    $datos1 = $rs1->getDatos();

                    $config = array('host' => $datos1[0]['host'],
                        'username' => $datos1[0]['usuario'],
                        'password' => $datos1[0]['contrasena'],
                        'port' => $datos1[0]['port'],
                        'encrypto' => $datos1[0]['encrypto']);
                    $imapLibrary = new ImapLibrary($config);
                    $isConnected = $imapLibrary->connect();
                    if (!$isConnected) {
                        continue;
                    }
                    $imapLibrary->select_folder($datos1[0]['carpeta']);
                    $desde_fecha = new DateTime($apertura['fecha_recepcion_desde'] . ' ' . $apertura['hora_recepcion_desde']);
                    $hasta_fecha = new DateTime($apertura['fecha_recepcion_hasta'] . ' ' . $apertura['hora_recepcion_hasta']);

                    $criteria = "SUBJECT " . $apertura['num_tramite'];
                    $criteria .= " UNSEEN";

                    $mails = $imapLibrary->search($criteria);
                    $cantidad_correos = count($mails);
                    $importados = 0;
                    $mensajes = $imapLibrary->get_messages($mails);

                    foreach ($mensajes as $mensaje) {
                        $date = new DateTime($mensaje['date']);

                        if ($date >= $desde_fecha && $date <= $hasta_fecha) {
                            $this->objParam->addParametro('estado_reg', 'activo');
                            $this->objParam->addParametro('uid_email', $mensaje['id']);
                            $this->objParam->addParametro('numero_email', $mensaje['uid']);
                            $this->objParam->addParametro('remitente_email', $mensaje['from']['email']);
                            $this->objParam->addParametro('asunto_email', $mensaje['subject']);
                            $this->objParam->addParametro('fecha_recepcion_email', $date->format("Y-m-d H:i:s.u"));
                            $this->objParam->addParametro('id_apertura_digital', $apertura['id_apertura_digital']);
                            $aperturaDet = $this->create('MODImportador');
                            $rs = $aperturaDet->insertarAperturasDigitalesDet($this->objParam);
                            imap_mail('valvaradoetr@gmail.com', $mensaje['subject'], $mensaje['body']['html']);
                            if ($rs->getTipo() == 'EXITO') {
                                $importados++;
                            }

                        }
                    }
                }
            }

        }

        if ($importados > 0 && $cantidad_correos == $importados) {
            $mensajeExito = new Mensaje();
            $mensajeExito->setMensaje('EXITO', 'ACTAperturasDigitalesDet.php', 'Correos Importados Verifique su información', 'Se importaron ' . $cantidad_correos . ' correos!', '', '', '', '');
            $this->res = $mensajeExito;
            $this->res->imprimirRespuesta($this->res->generarJson());
        } else {
            $mensajeExito = new Mensaje();
            $mensajeExito->setMensaje('ERROR', 'ACTAperturasDigitalesDet.php', 'Verifique su información', 'Un fallo insperado ocurrió al importar correos!', '', '', '', '');
            $this->res = $mensajeExito;
            $this->res->imprimirRespuesta($this->res->generarJson());
        }

    }

    function obtenerFuncionario($id_funcionario)
    {
        $this->objParam->defecto('ordenacion', 'descripcion_cargo');
        $this->objParam->defecto('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 1);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro("FUNCAR.id_funcionario = " . $id_funcionario);
        $this->objFun1 = $this->create('MODHelpDeskImportar');
        return $this->objFun1->obtenerFuncionario($this->objParam);
    }
}

?>
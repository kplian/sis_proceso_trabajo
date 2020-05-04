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
include_once(dirname(__FILE__) . '/../../lib/PHPMailer/class.phpmailer.php');
include_once(dirname(__FILE__) . '/../../lib/PHPMailer/class.smtp.php');
include_once(dirname(__FILE__) . '/../../lib/lib_general/cls_correo_externo.php');
include_once dirname(__DIR__) . '/lib/ImapLibrary.php';
require_once dirname(__DIR__) . '/environment.php';

class ACTImportador extends ACTbase
{
    function importarCorreos()
    {
        $rs = $this->obtenerAperturaDigital($this->objParam->getParametro('id_apertura_digital'));

        if ($rs->getTipo() == 'EXITO') {
            $datos = $rs->getDatos();
            foreach ($datos as $apertura) {
                $rs1 = $this->obtenerCuentaCorreo($apertura['id_cuenta_correo']);
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

                    $criteria = "SUBJECT " . $apertura['codigo'];
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

    function EnviarCorreos()
    {
        $rsApertura = $this->obtenerAperturaDigital($this->objParam->getParametro('id_apertura_digital'));
        $rsAperturaDet = $this->obtenerAperturaDet($this->objParam->getParametro('id_apertura_digital'));

        if ($rsApertura->getTipo() == 'EXITO' && $rsAperturaDet->getTipo() == 'EXITO') {
            $datosApertura = $rsApertura->getDatos();
            $datosAperturaDet = $rsAperturaDet->getDatos();

            $rsCuentaCorreo = $this->obtenerCuentaCorreo($datosApertura[0]['id_cuenta_correo']);
            if ($rsCuentaCorreo->getTipo() == 'EXITO') {
                $datosCuentaCorreo = $rsCuentaCorreo->getDatos();
                $ids = $datosApertura[0]['ids_funcionarios_asignados'];
                $ids_funcionarios = explode(',', str_replace("}", '', str_replace("{", '', $ids)));

                $config = array('host' => $datosCuentaCorreo[0]['host'],
                    'username' => $datosCuentaCorreo[0]['usuario'],
                    'password' => $datosCuentaCorreo[0]['contrasena'],
                    'port' => $datosCuentaCorreo[0]['port'],
                    'encrypto' => $datosCuentaCorreo[0]['encrypto']);
                $imapLibrary = new ImapLibrary($config);
                $isConnected = $imapLibrary->connect();
                $imapLibrary->select_folder($datosCuentaCorreo[0]['carpeta']);
                $mails = array_column($datosAperturaDet, 'numero_email');
                $cantidad_correos = count($mails);
                $enviados = 0;
                $mensajes = $imapLibrary->get_messages($mails);
                foreach ($mensajes as $mensaje) {
                    foreach ($ids_funcionarios as $id) {
                        $rsFuncionario = $this->obtenerFuncionario($id);
                        if ($rsFuncionario->getTipo() == 'EXITO') {
                            $datosFuncionario = $rsFuncionario->getDatos();
                            $correo = new CorreoExterno();
                            if (array_key_exists('attachments', $mensaje)) {
                                foreach ($mensaje['attachments'] as $attach) {
                                    $filename = $attach['name'];
                                    $imapLibrary->downloadAttachment(PATH_DOWNLOADED_ATTACHMENTS, $mensaje['uid']);
                                    $correo->addAdjunto(PATH_DOWNLOADED_ATTACHMENTS . $filename, $filename);
                                }
                            }
                            $correo->addDestinatario($datosFuncionario[0]['email_empresa'], $datosFuncionario[0]['desc_funcionario1']);
                            $correo->setAsunto($mensaje['subject']);
                            $correo->setMensajeHtml($mensaje['body']['html']);
                            $status = $correo->enviarCorreo();
                            if($status == "OK"){
                                unlink(PATH_DOWNLOADED_ATTACHMENTS . $filename);
                                $enviados++;
                            }
                        }
                    }

                }
            }

        }

        if ($enviados > 0) {
            if ($this->objParam->getParametro('id_apertura_digital') != '') {
                $this->objParam->addParametro('id_apertura_digital', $this->objParam->getParametro('id_apertura_digital'));
                $apImportador = $this->create('MODImportador');
                $rs = $apImportador->asignarFechaApertura($this->objParam);
            }
            $mensajeExito = new Mensaje();
            $mensajeExito->setMensaje('EXITO', 'ACTImportador.php', 'Correos de aperturas Reenviadas', 'Se enviaron ' . $enviados . ' correos para su apertura!', '', '', '', '');
            $this->res = $mensajeExito;
            $this->res->imprimirRespuesta($this->res->generarJson());
        } else {
            $mensajeExito = new Mensaje();
            $mensajeExito->setMensaje('ERROR', 'ACTAperturasDigitalesDet.php', 'Verifique su información', 'Un fallo ocurrió al enviar los correos!', '', '', '', '');
            $this->res = $mensajeExito;
            $this->res->imprimirRespuesta($this->res->generarJson());
        }

    }

    function obtenerAperturaDigital($id_apertura_digital)
    {
        $this->objParam->parametros_consulta['ordenacion'] = '';
        $this->objParam->defecto('ordenacion', 'id_apertura_digital');
        $this->objParam->defecto('dir_ordenacion', 'desc');
        $this->objParam->defecto('cantidad', 100000);
        $this->objParam->defecto('puntero', 0);
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        if ($id_apertura_digital != '') {
            $this->objParam->addFiltro(" dig.id_apertura_digital = " . $id_apertura_digital . "");
        } else {
            $this->objParam->addFiltro(" dig.estado = ''pendiente'' ");
        }


        $this->objFunc = $this->create('MODImportador');
        return $this->objFunc->listarAperturasDigitales($this->objParam);
    }

    function obtenerCuentaCorreo($id_cuenta_correo)
    {
        $this->objParam->parametros_consulta['ordenacion'] = '';
        $this->objParam->defecto('ordenacion', 'id_cuenta_correo');
        $this->objParam->defecto('dir_ordenacion', 'desc');
        $this->objParam->defecto('cantidad', 1);
        $this->objParam->defecto('puntero', 0);
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro(" cueco.id_cuenta_correo = " . $id_cuenta_correo . "");

        $this->objFunc = $this->create('MODImportador');
        return $this->objFunc->listarCuentasCorreo($this->objParam);
    }

    function obtenerAperturaDet($id_apertura_digital)
    {
        $this->objParam->parametros_consulta['ordenacion'] = '';
        $this->objParam->defecto('ordenacion', 'id_apertura_digital_det');
        $this->objParam->defecto('dir_ordenacion', 'desc');
        $this->objParam->defecto('cantidad', 100000);
        $this->objParam->defecto('puntero', 0);
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        if ($id_apertura_digital != '') {
            $this->objParam->addFiltro(" adigd.id_apertura_digital = " . $id_apertura_digital . "");
        }

        $this->objFunc = $this->create('MODImportador');
        return $this->objFunc->listarAperturasDigitalesDet($this->objParam);
    }

    function obtenerFuncionario($id_funcionario)
    {
        $this->objParam->parametros_consulta['ordenacion'] = '';
        $this->objParam->defecto('ordenacion', 'id_funcionario');
        $this->objParam->defecto('dir_ordenacion', 'desc');
        $this->objParam->defecto('cantidad', 1);
        $this->objParam->defecto('puntero', 0);
        $this->objParam->parametros_consulta['filtro'] = ' 0 = 0 ';
        $this->objParam->addFiltro("FUNCAR.id_funcionario = " . $id_funcionario);
        $this->objParam->addFiltro("FUNCAR.fecha_finalizacion >= now() ");
        $this->objFunc = $this->create('MODImportador');
        return $this->objFunc->obtenerFuncionario($this->objParam);
    }
}

?>
<?php
/**
 * @package pXP
 * @file AperturasDigitales.php
 * @author  (valvarado)
 * @date 20-04-2020 22:13:29
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                20-04-2020                 (valvarado)                CREACION
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AperturasDigitales = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.AperturasDigitales.superclass.constructor.call(this, config);
                this.init();
                this.addBotones();
                this.load({params: {start: 0, limit: this.tam_pag}})
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_apertura_digital'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_cuenta_correo'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'num_tramite',
                        fieldLabel: 'Tramite',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dig.num_tramite', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'estado',
                        fieldLabel: 'Estado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dig.estado', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'desc_funcionario1',
                        fieldLabel: 'Funcionario',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'fun_ad.desc_funcionario1', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dig.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'obs_dba',
                        fieldLabel: 'obs_dba',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dig.obs_dba', type: 'string'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'id_funcionario',
                        hiddenName: 'id_funcionario',
                        origen: 'FUNCIONARIO',
                        fieldLabel: 'Funcionario',
                        allowBlank: false,
                        width: '100%',
                        anchor: '100%',
                        valueField: 'id_funcionario',
                        gdisplayField: 'desc_funcionario',
                        baseParams: {es_combo_solicitud: 'si'},
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_funcionario']);
                        }
                    },
                    type: 'ComboRec',
                    id_grupo: 2,
                    filters: {pfiltro: 'fun.desc_funcionario1', type: 'string'},
                    bottom_filter: true,
                    grid: false,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_recepcion_desde',
                        fieldLabel: 'Fecha Recepción Desde',
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        submitFormat: 'U',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dig.fecha_recepcion_desde', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    egrid: true
                },
                {
                    config: {
                        name: 'hora_recepcion_desde',
                        fieldLabel: 'Hora Recepción Desde',
                        increment: 5,
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        maxLength: 8,
                        format: 'H:i:s',
                    },
                    type: 'TimeField',
                    filters: {pfiltro: 'dig.hora_recepcion_desde', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    egrid: true

                },
                {
                    config: {
                        name: 'fecha_recepcion_hasta',
                        fieldLabel: 'Fecha Recepción Hasta',
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dig.fecha_recepcion_hasta', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    egrid: true
                },
                {
                    config: {
                        name: 'hora_recepcion_hasta',
                        fieldLabel: 'Hora Recepción Hasta',
                        increment: 5,
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        maxLength: 8,
                        format: 'H:i:s',
                    },
                    type: 'TimeField',
                    filters: {pfiltro: 'dig.hora_recepcion_hasta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    egrid: true

                },
                {
                    config: {
                        name: 'fecha_apertura',
                        fieldLabel: 'Fecha Apertura',
                        increment: 5,
                        allowBlank: false,
                        anchor: '50%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dig.fecha_apertura', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    egrid: true

                },
                {
                    config: {
                        name: 'id_cuenta_correo',
                        fieldLabel: 'Correo',
                        emptyText: 'Correo...',
                        typeAhead: true,
                        lazyRender: true,
                        allowBlank: false,
                        mode: 'remote',
                        gwidth: 180,
                        anchor: '100%',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_proceso_trabajo/control/CuentasCorreo/listarCuentasCorreo',
                            id: 'id_cuenta_correo',
                            root: 'datos',
                            sortInfo: {
                                field: 'id_cuenta_correo',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_cuenta_correo', 'descripcion', 'correo'],
                            // turn on remote sorting
                            remoteSort: true,
                            baseParams: {par_filtro: 'cueco.correo#cueco.descripcion'}
                        }),
                        valueField: 'id_cuenta_correo',
                        displayField: 'correo',
                        gdisplayField: 'correo',
                        hiddenName: 'id_cuenta_correo',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 10,
                        queryDelay: 1000,
                        resizable: true,
                        minChars: 1,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['correo']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 2,
                    filters: {pfiltro: 'cueco.descripcion#cueco.correo', type: 'string'},
                    grid: false,
                    form: true,
                    bottom_filter: true
                },
                {
                    config: {
                        name: 'correo',
                        fieldLabel: 'Correo Recpeción',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'cueco.correo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'descripcion',
                        fieldLabel: 'Descripción',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'cueco.descripcion', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dig.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'dig.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dig.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dig.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'Aperturas Digitales',
            nombreVista: 'AperturasDigitales',
            ActSave: '../../sis_proceso_trabajo/control/AperturasDigitales/insertarAperturasDigitales',
            ActDel: '../../sis_proceso_trabajo/control/AperturasDigitales/eliminarAperturasDigitales',
            ActList: '../../sis_proceso_trabajo/control/AperturasDigitales/listarAperturasDigitales',
            id_store: 'id_apertura_digital',
            fields: [
                {name: 'id_apertura_digital', type: 'numeric'},
                {name: 'id_cuenta_correo', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'obs_dba', type: 'string'},
                {name: 'fecha_recepcion_desde', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'hora_recepcion_desde', type: 'string'},
                {name: 'fecha_recepcion_hasta', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'hora_recepcion_hasta', type: 'string'},
                {name: 'correo', type: 'string'},
                {name: 'descripcion', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'id_proceso_wf', type: 'numeric'},
                {name: 'id_estado_wf', type: 'numeric'},
                {name: 'estado', type: 'string'},
                {name: 'num_tramite', type: 'string'},
                {name: 'desc_funcionario1', type: 'string'},
                {name: 'id_funcionario', type: 'numeric'},
                {name: 'fecha_apertura', type: 'date', dateFormat: 'Y-m-d'}
            ],
            sortInfo: {
                field: 'id_apertura_digital',
                direction: 'ASC'
            },
            bdel: true,
            bsave: true,
            tabsouth: [{
                url: '../../../sis_proceso_trabajo/vista/aperturas_digitales_det/AperturasDigitalesDet.php',
                title: 'Detalle',
                height: '40%',
                cls: 'AperturasDigitalesDet'
            }],
            liberaMenu: function () {
                var tb = Phx.vista.AperturasDigitales.superclass.liberaMenu.call(this);
                if (tb) {
                    this.getBoton('btnChequeoDocumentosWf').disable();
                    this.getBoton('diagrama_gantt').disable();
                    this.getBoton('sig_estado').disable();
                    this.getBoton('ant_estado').disable();
                    this.getBoton('importar_correos').enable();
                    this.getBoton('enviar_correos').enable();
                }
                return tb
            },
            preparaMenu: function (n) {
                var data = this.getSelectedData();
                var tb = this.tbar;
                Phx.vista.AperturasDigitales.superclass.preparaMenu.call(this, n);
                if (data) {
                    this.getBoton('btnChequeoDocumentosWf').enable();
                    this.getBoton('diagrama_gantt').enable();
                    switch (data.estado) {
                        case 'finalizado': {
                            this.getBoton('sig_estado').disable();
                            this.getBoton('edit').disable();
                            this.getBoton('del').disable();
                            this.getBoton('btnChequeoDocumentosWf').disable();
                            this.getBoton('importar_correos').disable();
                            this.getBoton('enviar_correos').disable();
                            break;
                        }
                        case 'asignado': {
                            this.getBoton('sig_estado').enable();
                            this.getBoton('importar_correos').disable();
                            this.getBoton('enviar_correos').enable();
                            this.getBoton('ant_estado').disable();
                            this.getBoton('edit').disable();
                            this.getBoton('del').disable();
                            this.getBoton('btnChequeoDocumentosWf').disable();

                            break;
                        }
                        case 'pendiente': {
                            this.getBoton('sig_estado').enable();
                            this.getBoton('ant_estado').enable();
                            this.getBoton('importar_correos').enable();
                            this.getBoton('enviar_correos').disable();
                            this.getBoton('edit').disable();
                            this.getBoton('del').disable();
                            this.getBoton('btnChequeoDocumentosWf').disable();
                            break;
                        }
                        case 'borrador': {
                            this.getBoton('sig_estado').enable();
                            this.getBoton('ant_estado').disable();
                            this.getBoton('edit').enable();
                            this.getBoton('importar_correos').disable();
                            this.getBoton('enviar_correos').disable();
                            break;
                        }
                        default: {
                            this.getBoton('btnChequeoDocumentosWf').disable();
                            this.getBoton('sig_estado').disable();
                            this.getBoton('ant_estado').disable();
                            this.getBoton('edit').disable();
                            this.getBoton('del').disable();
                            this.getBoton('btnChequeoDocumentosWf').disable();
                            this.getBoton('importar_correos').disable();
                            this.getBoton('enviar_correos').disable();
                        }
                    }

                }
                return tb
            },
            onButtonNew: function () {
                var self = this;
                Phx.vista.AperturasDigitales.superclass.onButtonNew.call(this);
                this.Cmp.id_funcionario.store.baseParams.query = '<?php echo $_SESSION['ss_id_funcionario']; ?>';
                this.Cmp.id_funcionario.store.load({
                    params: {start: 0, limit: this.tam_pag},
                    callback: function (r) {
                        if (r.length > 0) {
                            this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                            this.Cmp.id_funcionario.fireEvent('select', this.Cmp.id_funcionario, r[0].data.id_funcionario, 0)
                        }

                    }, scope: this
                });
            },
            onButtonEdit: function () {
                Phx.vista.AperturasDigitales.superclass.onButtonEdit.call(this);
                var data = this.getSelectedData();
                this.Cmp.id_cuenta_correo.store.baseParams.query = data.id_cuenta_correo;
                this.Cmp.id_cuenta_correo.store.load({
                    params: {start: 0, limit: this.tam_pag},
                    callback: function (r) {
                        if (r.length > 0) {
                            this.Cmp.id_cuenta_correo.setValue(r[0].data.id_cuenta_correo);
                            this.Cmp.id_cuenta_correo.fireEvent('select', this.Cmp.id_cuenta_correo, r[0].data.id_cuenta_correo, 0)
                        }

                    }, scope: this
                });
                this.Cmp.id_funcionario.store.baseParams.query = data.desc_funcionario1;
                this.Cmp.id_funcionario.store.load({
                    params: {start: 0, limit: this.tam_pag},
                    callback: function (r) {
                        if (r.length > 0) {
                            this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                            this.Cmp.id_funcionario.fireEvent('select', this.Cmp.id_funcionario, r[0].data.id_funcionario, 0)
                        }

                    }, scope: this
                });
            },
            addBotones: function () {
                this.addButton('btnChequeoDocumentosWf',
                    {
                        text: 'Documentos',
                        grupo: [0],
                        iconCls: 'bchecklist',
                        disabled: true,
                        handler: this.loadCheckDocumentosSolWf,
                        tooltip: '<b>Documentos de la Solicitud</b><br/>Subir los documetos requeridos en la solicitud seleccionada.'
                    }
                );
                this.addButton('ant_estado', {
                    argument: {estado: 'anterior'},
                    text: 'Anterior',
                    grupo: [0],
                    iconCls: 'batras',
                    disabled: true,
                    handler: this.antEstado,
                    tooltip: '<b>Pasar al Anterior Estado</b>'
                });
                this.addButton('sig_estado', {
                    grupo: [0],
                    text: 'Siguiente',
                    iconCls: 'badelante',
                    disabled: true,
                    handler: this.sigEstado,
                    tooltip: '<b>Pasar al Siguiente Estado</b>'
                });
                this.addButton('importar_correos',
                    {
                        text: 'Importar Correos',
                        iconCls: 'bdocuments',
                        grupo: [0, 2],
                        disabled: true,
                        handler: this.importar,
                        tooltip: '<b>Importar correos</b>'
                    });
                this.addButton('enviar_correos',
                    {
                        text: 'Enviar Correos',
                        iconCls: 'bdocuments',
                        grupo: [0, 2],
                        disabled: true,
                        handler: this.enviar,
                        tooltip: '<b>Enviar correos</b>'
                    });
                this.addBotonesGantt();
            },
            addBotonesGantt: function () {
                this.menuAdqGantt = new Ext.Toolbar.SplitButton({
                    id: 'b-diagrama_gantt-' + this.idContenedor,
                    text: 'Gantt',
                    disabled: false,
                    grupo: [0, 1, 2],
                    iconCls: 'bgantt',
                    handler: this.diagramGanttDinamico,
                    scope: this,
                    menu: {
                        items: [{
                            id: 'b-gantti-' + this.idContenedor,
                            text: 'Gantt Imagen',
                            tooltip: '<b>Mues un reporte gantt en formato de imagen</b>',
                            handler: this.diagramGantt,
                            scope: this
                        }, {
                            id: 'b-ganttd-' + this.idContenedor,
                            text: 'Gantt Dinámico',
                            tooltip: '<b>Muestra el reporte gantt facil de entender</b>',
                            handler: this.diagramGanttDinamico,
                            scope: this
                        }
                        ]
                    }
                });
                this.tbar.add(this.menuAdqGantt);
            },
            diagramGantt: function () {
                var data = this.sm.getSelected().data.id_proceso_wf;
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_workflow/control/ProcesoWf/diagramaGanttTramite',
                    params: {'id_proceso_wf': data},
                    success: this.successExport,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            },
            diagramGanttDinamico: function () {
                var data = this.sm.getSelected().data.id_proceso_wf;
                window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf=' + data)
            },
            loadCheckDocumentosSolWf: function () {
                var rec = this.sm.getSelected();
                rec.data.nombreVista = this.nombreVista;
                Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
                    'Documentos del Proceso',
                    {
                        width: '90%',
                        height: 500
                    },
                    rec.data,
                    this.idContenedor,
                    'DocumentoWf'
                )
            },
            sigEstado: function () {
                var rec = this.sm.getSelected();
                var extraControls = [];

                if (rec.data.estado == 'pendiente') {
                    extraControls = [
                        {
                            config: {
                                name: 'ids_funcionarios_asignados',
                                fieldLabel: 'Funcionario',
                                allowBlank: false,
                                emptyText: 'Elegir ...',
                                tinit: false,
                                resizable: true,
                                tasignacion: false,
                                store: new Ext.data.JsonStore({
                                    url: '../../sis_organigrama/control/Funcionario/listarFuncionario',
                                    id: 'id_funcionario',
                                    root: 'datos',
                                    sortInfo: {
                                        field: 'desc_person',
                                        direction: 'ASC'
                                    },
                                    totalProperty: 'total',
                                    fields: ['id_funcionario', 'codigo', 'desc_person', 'ci', 'documento', 'telefono', 'celular', 'correo'],
                                    remoteSort: true,
                                    baseParams: {par_filtro: 'funcio.codigo#nombre_completo1'}
                                }),
                                valueField: 'id_funcionario',
                                displayField: 'desc_person',
                                hiddenName: 'id_funcionario',
                                forceSelection: true,
                                typeAhead: false,
                                triggerAction: 'all',
                                listWidth: 500,
                                lazyRender: true,
                                mode: 'remote',
                                pageSize: 10,
                                queryDelay: 1000,
                                width: 250,
                                enableMultiSelect: true,
                                gwidth: 250,
                                minChars: 2,
                                anchor: '80%',
                                qtip: 'Seleccione funcionarios para asignar',
                                tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}"><p><b>{desc_person}</b></p></div>\
		                       <p style="padding-left: 20px;"><b>Codigo: </b>{codigo}</p>\
		                        <p style="padding-left: 20px;"><b>CI: </b>{ci}</p></div></tpl>',
                            },
                            type: 'AwesomeCombo',
                            bottom_filter: true,
                            filters: {pfiltro: 'coinga.desc_ingas', type: 'string'},
                            id_grupo: 1,
                            grid: true,
                            form: true
                        }
                    ]
                }

                this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
                    'Estado de Wf',
                    {
                        modal: true,
                        width: 700,
                        height: 450
                    }, {
                        configExtra: extraControls,
                        data: {
                            id_estado_wf: rec.data.id_estado_wf,
                            id_proceso_wf: rec.data.id_proceso_wf,
                            id_apertura_digital: rec.data.id_apertura_digital
                        }
                    }, this.idContenedor, 'FormEstadoWf',
                    {
                        config: [{
                            event: 'beforesave',
                            delegate: this.onSaveWizard
                        }],
                        scope: this
                    });
            },
            onSaveWizard: function (wizard, resp) {
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_proceso_trabajo/control/AperturasDigitales/siguienteEstado',
                    params: {
                        id_apertura_digital: wizard.data.id_apertura_digital,
                        id_proceso_wf_act: resp.id_proceso_wf_act,
                        id_estado_wf_act: resp.id_estado_wf_act,
                        id_tipo_estado: resp.id_tipo_estado,
                        id_funcionario_wf: resp.id_funcionario_wf,
                        id_depto_wf: resp.id_depto_wf,
                        obs: resp.obs,
                        json_procesos: Ext.util.JSON.encode(resp.procesos),
                        ids_funcionarios_asignados: resp.ids_funcionarios_asignados,
                    },
                    success: this.successCambioEstado,
                    failure: this.failureWizard,
                    argument: {wizard: wizard},
                    timeout: this.timeout,
                    scope: this
                });
            },
            antEstado: function (res) {
                var data = this.getSelectedData();
                Phx.CP.loadingHide();
                Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
                    'Estado de Wf',
                    {
                        modal: true,
                        width: 450,
                        height: 250
                    },
                    {
                        data: data,
                        estado_destino: res.argument.estado
                    },
                    this.idContenedor, 'AntFormEstadoWf',
                    {
                        config: [{
                            event: 'beforesave',
                            delegate: this.onAntEstado,
                        }],
                        scope: this
                    });

            },
            onAntEstado: function (wizard, resp) {
                Phx.CP.loadingShow();
                var operacion = 'cambiar';

                Ext.Ajax.request({
                    url: '../../sis_proceso_trabajo/control/AperturasDigitales/anteriorEstado',
                    params: {
                        id_apertura_digital: wizard.data.id_adenda,
                        id_proceso_wf: resp.id_proceso_wf,
                        id_estado_wf: resp.id_estado_wf,
                        obs: resp.obs,
                        operacion: operacion
                    },
                    argument: {wizard: wizard},
                    success: this.successCambioEstado,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            },
            successCambioEstado: function (resp) {
                Phx.CP.loadingHide();
                resp.argument.wizard.panel.destroy();
                this.reload();
            },
            importar: function () {
                var self = this;
                var data = self.getSelectedData();
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_proceso_trabajo/control/Importador/importarCorreos',
                    params: {id_apertura_digital: data.id_apertura_digital},
                    success: function (resp) {
                        Phx.CP.loadingHide();
                        self.reload();
                    },
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            },
            enviar: function () {
                var self = this;
                var data = self.getSelectedData();
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_proceso_trabajo/control/Importador/EnviarCorreos',
                    params: {id_apertura_digital: data.id_apertura_digital},
                    success: function (resp) {
                        Phx.CP.loadingHide();
                        self.reload();
                    },
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });
            }
        }
    )
</script>
		
		
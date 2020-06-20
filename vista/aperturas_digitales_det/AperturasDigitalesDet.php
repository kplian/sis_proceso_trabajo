<?php
/**
 * @package pXP
 * @file AperturasDigitalesDet.php
 * @author  (valvarado)
 * @date 21-04-2020 23:09:51
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 * HISTORIAL DE MODIFICACIONES:
 * #ISSUE                FECHA                AUTOR                DESCRIPCION
 * #0                21-04-2020                 (valvarado)                CREACION
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AperturasDigitalesDet = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.AperturasDigitalesDet.superclass.constructor.call(this, config);
                this.init();
            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_apertura_digital_det'
                    },
                    type: 'Field',
                    form: true
                },
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
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'adigd.estado_reg', type: 'string'},
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
                        maxLength: -5
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'adigd.obs_dba', type: 'string'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'uid_email',
                        fieldLabel: 'UID Email',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'adigd.uid_email', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'numero_email',
                        fieldLabel: 'Numero Email',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'adigd.numero_email', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'remitente_email',
                        fieldLabel: 'Enviado Por',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'adigd.remitente_email', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    bottom_filter: true,
                },
                {
                    config: {
                        name: 'asunto_email',
                        fieldLabel: 'Asunto',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: -5
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'adigd.asunto_email', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                    bottom_filter: true,
                },
                {
                    config: {
                        name: 'fecha_recepcion_email',
                        fieldLabel: 'Fecha Recepción',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y H:i',
                        renderer: function (value, p, record) {
                            return value ? new Date(value).dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'adigd.fecha_recepcion_email', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
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
                        format: 'd/m/Y g:i a',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y g:i a') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'adigd.fecha_reg', type: 'date'},
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
                    filters: {pfiltro: 'adigd.id_usuario_ai', type: 'numeric'},
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
                    filters: {pfiltro: 'adigd.usuario_ai', type: 'string'},
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
                    filters: {pfiltro: 'adigd.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            nombreVista: 'AperturasDigitalesDet',
            tam_pag: 50,
            title: 'Aperturas digitales Detalle',
            ActSave: '../../sis_proceso_trabajo/control/AperturasDigitalesDet/insertarAperturasDigitalesDet',
            ActDel: '../../sis_proceso_trabajo/control/AperturasDigitalesDet/eliminarAperturasDigitalesDet',
            ActList: '../../sis_proceso_trabajo/control/AperturasDigitalesDet/listarAperturasDigitalesDet',
            id_store: 'id_apertura_digital_det',
            fields: [
                {name: 'id_apertura_digital_det', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'obs_dba', type: 'string'},
                {name: 'uid_email', type: 'numeric'},
                {name: 'numero_email', type: 'numeric'},
                {name: 'remitente_email', type: 'string'},
                {name: 'asunto_email', type: 'string'},
                {name: 'fecha_recepcion_email', type: 'string'},
                {name: 'id_apertura_digital', type: 'numeric'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},

            ],
            sortInfo: {
                field: 'id_apertura_digital_det',
                direction: 'ASC'
            },
            bdel: false,
            bsave: false,
            bedit: false,
            bnew: false,
            preparaMenu: function (n) {
                var data = this.getSelectedData();
                var tb = this.tbar;
                console.log("AD", this.maestro.estado);
                Phx.vista.AperturasDigitalesDet.superclass.preparaMenu.call(this, n);
                return tb
            },
            liberaMenu: function () {
                var tb = Phx.vista.AperturasDigitalesDet.superclass.liberaMenu.call(this);
                return tb
            },
            onReloadPage: function (m) {
                this.maestro = m;

                this.Atributos[this.getIndAtributo('id_apertura_digital')].valorInicial = this.maestro.id_apertura_digital;

                this.store.baseParams = {
                    id_apertura_digital: this.maestro.id_apertura_digital
                };
                this.load({params: {start: 0, limit: 50}});
            }
        }
    )
</script>
		
		
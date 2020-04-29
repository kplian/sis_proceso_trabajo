<?php
/**
*@package pXP
*@file gen-Vpn.php
*@author  (egutierrez)
*@date 12-04-2020 17:37:52
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				12-04-2020				 (egutierrez)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.VpnBase=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.VpnBase.superclass.constructor.call(this,config);
        this.addBotonesGantt();
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
        this.addButton('btnChequeoDocumentosWf',
            {
                text: 'Documentos',
                grupo:[0,1,2,3,4],
                iconCls: 'bchecklist',
                disabled: true,
                handler: this.loadCheckDocumentosWf,
                tooltip: '<b>Documentos </b><br/>Permite ver los documentos asociados al NRO de trámite.'
            });
    },
    loadCheckDocumentosWf:function() {
        var rec=this.sm.getSelected();
        rec.data.nombreVista = this.nombreVista;
        Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
            'Documentos del Proceso',
            {
                width:'90%',
                height:500
            },
            rec.data,
            this.idContenedor,
            'DocumentoWf'
        )},
    addBotonesGantt: function() {
        this.menuAdqGantt = new Ext.Toolbar.SplitButton({
            id: 'b-diagrama_gantt-' + this.idContenedor,
            text: 'Gantt',
            disabled: true,
            grupo:[0,1,2,3,4],
            iconCls : 'bgantt',
            handler:this.diagramGanttDinamico,
            scope: this,
            menu:{
                items: [{
                    id:'b-gantti-' + this.idContenedor,
                    text: 'Gantt Imagen',
                    tooltip: '<b>Muestra un reporte gantt en formato de imagen</b>',
                    handler:this.diagramGantt,
                    scope: this
                }, {
                    id:'b-ganttd-' + this.idContenedor,
                    text: 'Gantt Dinámico',
                    tooltip: '<b>Muestra el reporte gantt facil de entender</b>',
                    handler:this.diagramGanttDinamico,
                    scope: this
                }]
            }
        });
        this.tbar.add(this.menuAdqGantt);
    },
    diagramGantt: function (){
        var data=this.sm.getSelected().data.id_proceso_wf;

        Phx.CP.loadingShow();
        Ext.Ajax.request({
            url:'../../sis_workflow/control/ProcesoWf/diagramaGanttTramite',
            params:{'id_proceso_wf':data},
            success: this.successExport,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
        });
    },

    diagramGanttDinamico: function (){
        var data=this.sm.getSelected().data.id_proceso_wf;

        window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf='+data)
    },
			
	Atributos:[
		{
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_vpn'
            },
            type:'Field',
            form:true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_proceso_wf'
            },
            type:'Field',
            form:true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_estado_wf'
            },
            type:'Field',
            form:true
        },
        {
            config:{
                name: 'nro_tramite',
                fieldLabel: 'Nro-Tramite',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'solvpn.nro_tramite',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },

        {
            config:{
                name:'id_funcionario',
                hiddenName: 'id_funcionario',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'Funcionario Solicitante',
                allowBlank:true,
                gwidth:200,
                valueField: 'id_funcionario',
                gdisplayField: 'desc_funcionario',
                baseParams: {par_filtro: 'id_funcionario#desc_funcionario1'},
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
            bottom_filter:false,
            grid:true,
            form:true,
            bottom_filter:true
        },
		{
			config:{
				name: 'fecha_desde',
				fieldLabel: 'fecha_desde',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'solvpn.fecha_desde',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_hasta',
				fieldLabel: 'fecha_hasta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'solvpn.fecha_hasta',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'descripcion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200,
				maxLength:100,
                renderer: function(value, metaData, record, rowIndex, colIndex, store) {
                    metaData.css = 'multilineColumn';
                    return String.format('<div class="gridmultiline">{0}</div>', value);//#4
                }
			},
				type:'TextField',
				filters:{pfiltro:'solvpn.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
        {
            config:{
                name: 'estado',
                fieldLabel: 'Estado.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'solvpn.estado',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name: 'desc_funcionario_responsable',
                fieldLabel: 'Funcionario Rep. Estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 300,
                maxLength:300
            },
            type:'TextField',
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name: 'obs',
                fieldLabel: 'obs',
                allowBlank: true,
                anchor: '80%',
                gwidth: 300,
                maxLength:300,
                renderer: function(value, metaData, record, rowIndex, colIndex, store) {
                    metaData.css = 'multilineColumn';
                    return String.format('<div class="gridmultiline">{0}</div>', value);//#4
                }
            },
            type:'TextField',
            id_grupo:1,
            grid:true,
            form:false
        },

        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'solvpn.estado_reg',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'solvpn.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'solvpn.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'solvpn.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'solvpn.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Soicitud Vpn',
	ActSave:'../../sis_proceso_trabajo/control/Vpn/insertarVpn',
	ActDel:'../../sis_proceso_trabajo/control/Vpn/eliminarVpn',
	ActList:'../../sis_proceso_trabajo/control/Vpn/listarVpn',
	id_store:'id_vpn',
	fields: [
		{name:'id_vpn', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'obs_dba', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'fecha_desde', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_hasta', type: 'date',dateFormat:'Y-m-d'},
		{name:'descripcion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},

        {name:'id_proceso_wf', type: 'numeric'},
        {name:'id_estado_wf',  type: 'numeric'},
        {name:'nro_tramite', type: 'string'},
        {name:'estado', type: 'string'},
        {name:'desc_funcionario', type: 'string'},
        {name:'desc_funcionario_responsable', type: 'string'},
        {name:'obs', type: 'string'},


    ],
	sortInfo:{
		field: 'id_vpn',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
        sigEstado:function(){
            var data = this.getSelectedData();
            this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
                'Estado de Wf',
                {
                    modal:true,
                    width:700,
                    height:450
                }, {data:{
                        id_vpn:data.id_vpn,
                        id_estado_wf:data.id_estado_wf,
                        id_proceso_wf:data.id_proceso_wf,

                    }}, this.idContenedor,'FormEstadoWf',
                {
                    config:[{
                        event:'beforesave',
                        delegate: this.onSaveWizard,

                    }],

                    scope:this
                });

        },
        onSaveWizard:function(wizard,resp){

            Ext.Ajax.request({
                url:'../../sis_proceso_trabajo/control/Vpn/siguienteEstado',
                params:{
                    id_vpn:      wizard.data.id_vpn,
                    id_proceso_wf_act:  resp.id_proceso_wf_act,
                    id_estado_wf_act:   resp.id_estado_wf_act,
                    id_tipo_estado:     resp.id_tipo_estado,
                    id_funcionario_wf:  resp.id_funcionario_wf,
                    id_depto_wf:        resp.id_depto_wf,
                    obs:                resp.obs,
                    json_procesos:      Ext.util.JSON.encode(resp.procesos)
                },
                success:this.successWizard,
                failure: this.conexionFailure,
                argument:{wizard:wizard},
                timeout:this.timeout,
                scope:this
            });

        },
        successWizard:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy()
            this.reload();
        },
        antEstado: function(res){
            var data = this.getSelectedData();
            Phx.CP.loadingHide();
            Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
                'Estado de Wf',
                {   modal: true,
                    width: 450,
                    height: 250
                },
                {    data: data,
                    estado_destino: res.argument.estado
                },
                this.idContenedor,'AntFormEstadoWf',
                {
                    config:[{
                        event:'beforesave',
                        delegate: this.onAntEstado,
                    }],
                    scope:this
                });

        },
        onAntEstado: function(wizard,resp){
            console.log('resp',wizard.data.id_vpn);
            Phx.CP.loadingShow();
            var operacion = 'cambiar';

            Ext.Ajax.request({
                url:'../../sis_proceso_trabajo/control/Vpn/anteriorEstado',
                params:{
                    id_vpn: wizard.data.id_vpn,
                    id_proceso_wf: resp.id_proceso_wf,
                    id_estado_wf:  resp.id_estado_wf,
                    obs: resp.obs,
                    operacion: operacion
                },
                argument:{wizard:wizard},
                success: this.successAntEstado,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },

        successAntEstado:function(resp){
            Phx.CP.loadingHide();
            resp.argument.wizard.panel.destroy()
            this.reload();

        },


    }
)
</script>
		
		
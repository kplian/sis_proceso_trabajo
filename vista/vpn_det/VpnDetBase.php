<?php
/**
*@package pXP
*@file gen-VpnDet.php
*@author  (egutierrez)
*@date 13-04-2020 18:43:37
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				13-04-2020				 (egutierrez)				CREACION	

*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.VpnDetBase=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.VpnDetBase.superclass.constructor.call(this,config);
		this.init();
        this.bloquearMenus();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_vpn_det'
			},
			type:'Field',
			form:true 
		},
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
			config:{
				name: 'sistema',
				fieldLabel: 'sistema',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200,
				maxLength:500,
                renderer: function(value, metaData, record, rowIndex, colIndex, store) {
                    metaData.css = 'multilineColumn';
                    return String.format('<div class="gridmultiline">{0}</div>', value);//#4
                }
			},
				type:'TextField',
				filters:{pfiltro:'vpndet.sistema',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'justificacion',
				fieldLabel: 'justificacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 400,
				maxLength:500,
                renderer: function(value, metaData, record, rowIndex, colIndex, store) {
                    metaData.css = 'multilineColumn';
                    return String.format('<div class="gridmultiline">{0}</div>', value);//#4
                }
			},
				type:'TextArea',
				filters:{pfiltro:'vpndet.justificacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
            filters:{pfiltro:'vpndet.estado_reg',type:'string'},
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
				filters:{pfiltro:'vpndet.fecha_reg',type:'date'},
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
				filters:{pfiltro:'vpndet.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'vpndet.usuario_ai',type:'string'},
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
				filters:{pfiltro:'vpndet.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Vpn detalle',
	ActSave:'../../sis_proceso_trabajo/control/VpnDet/insertarVpnDet',
	ActDel:'../../sis_proceso_trabajo/control/VpnDet/eliminarVpnDet',
	ActList:'../../sis_proceso_trabajo/control/VpnDet/listarVpnDet',
	id_store:'id_vpn_det',
	fields: [
		{name:'id_vpn_det', type: 'numeric'},
        {name:'id_vpn', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'obs_dba', type: 'string'},
		{name:'sistema', type: 'string'},
		{name:'justificacion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_vpn_det',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onReloadPage: function(m) {
        this.maestro = m;

        this.Atributos[this.getIndAtributo('id_vpn')].valorInicial = this.maestro.id_vpn;

        this.store.baseParams = {
            id_vpn: this.maestro.id_vpn
        };
        this.load({ params: {start: 0,limit: 50 }});
    },

	}
)
</script>
		
		
<?php
/**
*@package pXP
*@file gen-Licencia.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Vpn={
	require:'../../../sis_proceso_trabajo/vista/vpn/VpnBase.php',
	requireclase:'Phx.vista.VpnBase',
	title:'Vpn',
	nombreVista: 'Vpn',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.Vpn.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag , nombreVista:this.nombreVista , id_funcionario:Phx.CP.config_ini.id_funcionario}});
		
		this.addButton('ant_estado',
						{argument: {estado: 'anterior'},
						text:'Anterior',
		                grupo:[0,2],
						iconCls: 'batras',
						disabled:true,
						handler:this.antEstado,
						tooltip: '<b>Pasar al Anterior Estado</b>'
						});
		this.addButton('sig_estado',
						{ text:'Siguiente',
						grupo:[0,2], 
						iconCls: 'badelante', 
						disabled: true, 
						handler: this.sigEstado, 
						tooltip: '<b>Pasar al Siguiente Estado</b>'
						});
	},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.Vpn.superclass.preparaMenu.call(this,n);
        this.getBoton('diagrama_gantt').enable();
		this.getBoton('btnChequeoDocumentosWf').enable();
        console.log('prepara',data);
         if (data.estado == 'borrador') {
         	this.getBoton('ant_estado').disable();
             this.getBoton('sig_estado').enable();
         }else if (data.estado == 'finalizado') {
             this.getBoton('ant_estado').enable();
             this.getBoton('sig_estado').disable();
         }else{
             this.getBoton('ant_estado').disable();
             this.getBoton('sig_estado').disable();
         };
       	
         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.Vpn.superclass.liberaMenu.call(this);
        if(tb){
			this.getBoton('btnChequeoDocumentosWf').enable();
            this.getBoton('diagrama_gantt').enable();
            //this.getBoton('ant_estado').enable();
    		//this.getBoton('sig_estado').enable();

        }
       return tb
    },
    /*
    onButtonNew:function(){
        //abrir formulario de solicitud
        Phx.vista.Vpn.superclass.onButtonNew.call(this);

        this.Cmp.id_funcionario.store.baseParams.query = Phx.CP.config_ini.id_funcionario;

        Phx.CP.loadingShow();
        this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {

                    this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                    //this.obtenerNumeroReferencial(r[0].data.id_funcionario);
                }

            }, scope : this
        });
        Phx.CP.loadingHide();
       // this.abrirFormulario('new')

    },*/

    onButtonNew:function(){
        //abrir formulario de solicitud
        this.abrirFormulario('new')
    },

    onButtonEdit:function(){
        this.abrirFormulario('edit', this.sm.getSelected())
    },
    formTitulo: 'Solicitud de Vpn',
    abrirFormulario: function(tipo, record){
        var me = this;
        me.objSolForm = Phx.CP.loadWindows('../../../sis_proceso_trabajo/vista/vpn/FormVpn.php',
            me.formTitulo,
            {
                modal:true,
                width:'90%',
                height:(me.regitrarDetalle == 'si')? '100%':'60%',



            }, { data: {
                    objPadre: me ,
                    tipoDoc: me.tipoDoc,
                    //id_gestion: me.cmbGestion.getValue(),
                    //id_periodo: me.cmbPeriodo.getValue(),
                    //id_depto: me.cmbDepto.getValue(),
                    //tmpPeriodo: me.tmpPeriodo,
                    // tmpGestion: me.tmpGestion,
                    tipo_form : tipo,
                    datosOriginales: record
                },
                regitrarDetalle:'si'
            },
            this.idContenedor,
            'FormVpn',
            {
                config:[{
                    event:'successsave',
                    delegate: this.onSaveForm,

                }],

                scope:this
            });
    },
    tabsouth: [{
        url: '../../../sis_proceso_trabajo/vista/vpn_det/VpnDet.php',
        title: 'Detalle',
        height: '40%',
        cls: 'VpnDet'
    }],

	}
</script>
		
		
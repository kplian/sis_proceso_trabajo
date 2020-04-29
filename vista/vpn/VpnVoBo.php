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
    Phx.vista.VpnVoBo={
        require:'../../../sis_proceso_trabajo/vista/vpn/VpnBase.php',
        requireclase:'Phx.vista.VpnBase',
        title:'VpnVoBo',
        nombreVista: 'VpnVoBo',
        constructor:function(config){
            this.maestro=config.maestro;
            //console.log('maestro',this.maestro.id_funcionario);
            //this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
            //llama al constructor de la clase padre
            Phx.vista.VpnVoBo.superclass.constructor.call(this,config);
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
            Phx.vista.VpnVoBo.superclass.preparaMenu.call(this,n);
            this.getBoton('diagrama_gantt').enable();
            this.getBoton('btnChequeoDocumentosWf').enable();

             if (data.estado == 'finalizado') {
                 this.getBoton('ant_estado').enable();
                 this.getBoton('sig_estado').disable();

             }else{
                 this.getBoton('ant_estado').enable();
                 this.getBoton('sig_estado').enable();
             };



            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.VpnVoBo.superclass.liberaMenu.call(this);
            if(tb){
                this.getBoton('btnChequeoDocumentosWf').enable();
                this.getBoton('diagrama_gantt').enable();
                this.getBoton('ant_estado').enable();
                this.getBoton('sig_estado').enable();
            }
            return tb
        },
        bnew:false,
        bedit:false,
        bdel:false,
        bsave:false,
        tabsouth: [{
            url: '../../../sis_proceso_trabajo/vista/vpn_det/VpnDetVoBo.php',
            title: 'Detalle',
            height: '40%',
            cls: 'VpnDetVoBo'
        }],
    }
</script>


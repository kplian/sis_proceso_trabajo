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
Phx.vista.VpnDetVoBo={
	require:'../../../sis_proceso_trabajo/vista/vpn_det/VpnDetBase.php',
	requireclase:'Phx.vista.VpnDetBase',
	title:'VpnDetVoBo',
	nombreVista: 'VpnDetVoBo',
	constructor:function(config){
		this.maestro=config.maestro;

    	//llama al constructor de la clase padre
		Phx.vista.VpnDetVoBo.superclass.constructor.call(this,config);
		this.init();
        this.bloquearMenus();
        
	},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.VpnDetVoBo.superclass.preparaMenu.call(this,n);

         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.VpnDetVoBo.superclass.liberaMenu.call(this);
        if(tb){

        }
       return tb
    },
    bdel:false,
    bedit:false,
    bnew:false,
    bsave:false


	}
</script>
		
		
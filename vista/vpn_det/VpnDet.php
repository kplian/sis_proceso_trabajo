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
Phx.vista.VpnDet={
	require:'../../../sis_proceso_trabajo/vista/vpn_det/VpnDetBase.php',
	requireclase:'Phx.vista.VpnDetBase',
	title:'VpnDet',
	nombreVista: 'VpnDet',
	constructor:function(config){
		this.maestro=config.maestro;

    	//llama al constructor de la clase padre
		Phx.vista.VpnDet.superclass.constructor.call(this,config);
		this.init();
        this.bloquearMenus();
        
	},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.VpnDet.superclass.preparaMenu.call(this,n);

         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.VpnDet.superclass.liberaMenu.call(this);
        if(tb){

        }
       return tb
    },


	}
</script>
		
		
<?php
/**
 * @package pXP
 * @file AperturasDigitalesDetAceptados.php
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
    Phx.vista.AperturasDigitalesDetAceptados = {
        require: '../../../sis_proceso_trabajo/vista/aperturas_digitales_det/AperturasDigitalesDetBase.php',
        requireclase: 'Phx.vista.AperturasDigitalesDetBase',
        sortInfo: {
            field: 'id_apertura_digital_det',
            direction: 'ASC'
        },
        constructor: function (config) {
            this.maestro = config.maestro;
            //llama al constructor de la clase padre
            Phx.vista.AperturasDigitalesDetAceptados.superclass.constructor.call(this, config);
            this.init();
        },
        onReloadPage: function (m) {
            this.maestro = m;

            this.Atributos[this.getIndAtributo('id_apertura_digital')].valorInicial = this.maestro.id_apertura_digital;

            this.store.baseParams = {
                id_apertura_digital: this.maestro.id_apertura_digital,
                aceptado: 'si'
            };
            this.load({params: {start: 0, limit: 50}});
        }
    }
</script>
		
		
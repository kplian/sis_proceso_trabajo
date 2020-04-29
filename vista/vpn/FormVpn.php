<?php
/**
 *@package pXP
 *@file    FormVpn.php
 *@author  Rensi Arteaga Copari
 *@date    30-01-2014
 *@description permites subir archivos a la tabla de documento_sol
 * **    HISTORIAL DE MODIFICACIONES:
   	
 ISSUE            FECHA:		      AUTOR                 DESCRIPCION
 ***************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormVpn=Ext.extend(Phx.frmInterfaz,{
        ActSave:'../../sis_proceso_trabajo/control/Vpn/insertarVpnCompleto',
        tam_pag: 10,
        tabEnter: true,
        codigoSistema: 'ADQ',
        mostrarFormaPago : true,
        mostrarPartidas: false,
        regitrarDetalle: 'si',
        mostrarFuncionario: true,
        id_moneda_defecto: 0,  // 0 quiere decir todas las monedas
        //layoutType: 'wizard',
        layout: 'fit',
        autoScroll: false,
        breset: false,
        heightHeader: 290,
        vpn_det_eliminados: [],
        listadoConcepto: '../../sis_parametros/control/ConceptoIngas/listarConceptoIngasMasPartida',
        parFilConcepto:'desc_ingas#par.codigo',
        tipo_pres_gasto: 'gasto',
        tipo_pres_recurso: 'recurso',
        tipo_informe:'todos',  //#0999 filtro por defecto para tipo de plantilla
        excluir_tipo_informe:'ninguno',  //#0999 filtro por defecto para tipo de plantilla
        plantillaProrrateo: [], //07/12/2017 , RAc adcionar plantilal de prorrateo
        sw_nro_dui: 'no',
        constructor:function(config)
        {
            this.addEvents('beforesave');
            this.addEvents('successsave');
            if (config.data.mostrarFormaPago === false) {
                this.mostrarFormaPago = config.data.mostrarFormaPago;
            }
            Ext.apply(this,config);
            this.obtenerVariableGlobal(config);
            this.generarAtributos();

        },

        constructorEtapa2:function(config)
        {
            if(this.regitrarDetalle == 'si'){
                this.buildComponentesDetalle();
                this.buildDetailGrid();
            }

            this.buildGrupos();
            //rac, 07/12/2017 si existe plantilla se crea un formulario
            this.buildFormPlantilla()
            Phx.vista.FormVpn.superclass.constructor.call(this,config);

            if(this.mostrarFuncionario){
            	 this.mostrarComponente(this.Cmp.id_funcionario);
            }
            else{
            	 this.ocultarComponente(this.Cmp.id_funcionario);
            }
            
            this.init();
            this.iniciarEventos();
            if(this.regitrarDetalle == 'si'){
                this.iniciarEventosDetalle();
            }

            if(this.data.tipo_form == 'new'){
                this.onNew();
            }
            else{
                this.onEdit();
            }

            if(this.data.readOnly===true && this.regitrarDetalle == 'si'){
                for(var index in this.Cmp) {
                    if( this.Cmp[index].setReadOnly){
                        this.Cmp[index].setReadOnly(true);
                    }
                }
                this.megrid.getTopToolbar().disable();
            }
         },
        
        buildComponentesDetalle: function(){
            var me = this,
                bpar = (me.data.tipoDoc=='compra')?{par_filtro: me.parFilConcepto, movimiento: 'gasto', autorizacion: me.autorizacion, autorizacion_nulos: me.autorizacion_nulos }:{par_filtro: me.parFilConcepto, movimiento: 'recurso'};
                
            me.detCmp = {
                'id_concepto_ingas': new Ext.form.ComboBox({
                    name: 'id_concepto_ingas',
                    msgTarget: 'title',
                    fieldLabel: 'Concepto',
                    allowBlank: false,
                    emptyText : 'Concepto...',
                    store : new Ext.data.JsonStore({
                        url: me.listadoConcepto,
                        id : 'id_concepto_ingas',
                        root: 'datos',
                        sortInfo:{
                            field: 'desc_ingas',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_concepto_ingas','tipo','desc_ingas','movimiento','desc_partida','id_grupo_ots','filtro_ot','requiere_ot'],
                        remoteSort: true,
                        baseParams: bpar
                    }),
                    valueField: 'id_concepto_ingas',
                    displayField: 'desc_ingas',
                    hiddenName: 'id_concepto_ingas',
                    forceSelection: true,
                    typeAhead: false,
                    triggerAction: 'all',
                    listWidth: 500,
                    resizable: true,
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 10,
                    queryDelay: 1000,
                    minChars: 2,
                    qtip: 'Si el conceto de gasto que necesita no existe por favor  comuniquese con el área de presupuestos para solictar la creación',
                    tpl: '<tpl for="."><div class="x-combo-list-item"><p><b>{desc_ingas}</b></p><strong>{tipo}</strong><p>PARTIDA: {desc_partida}</p></div></tpl>',
                })
            };

            Ext.apply(me.detCmp,{
                //habilita los campos en la grilla
                'sistema': new Ext.form.TextArea({
                    name: 'sistema',
                    msgTarget: 'title',
                    fieldLabel: 'sistema',
                    allowBlank: false,
                    anchor: '80%',
                    maxLength:1200
                }),


                'justificacion': new Ext.form.TextArea({
                    name: 'justificacion',
                    msgTarget: 'title',
                    fieldLabel: 'Justificacion',
                    allowBlank: false,
                    anchor: '80%',
                    maxLength:1200
                }),
            });


        },

        iniciarEventosDetalle: function(){


        },

        onInitAdd: function(){
            if(this.data.readOnly===true){
                return false
            }

        },
        onCancelAdd: function(re,save){
            if(this.sw_init_add){
                this.mestore.remove(this.mestore.getAt(0));
            }

            this.sw_init_add = false;
            this.evaluaGrilla();

        },
        onUpdateRegister: function(){
            this.sw_init_add = false;

        },

        onAfterEdit:function(re, o, rec, num){
            //set descriptins values ...  in combos boxs
            console.log('edit ' + rec);
            /*
            var cmb_rec = this.detCmp['id_concepto_ingas'].store.getById(rec.get('id_concepto_ingas'));
            if(cmb_rec){
                rec.set('desc_concepto_ingas', cmb_rec.get('desc_ingas'));
            }

            var cmb_rec = this.detCmp['id_orden_trabajo'].store.getById(rec.get('id_orden_trabajo'));
            if(cmb_rec){
                rec.set('desc_orden_trabajo', cmb_rec.get('desc_orden'));
            }

            var cmb_rec = this.detCmp['id_centro_costo'].store.getById(rec.get('id_centro_costo'));
            if(cmb_rec){
                rec.set('desc_centro_costo', cmb_rec.get('codigo_cc'));
            }*/

        },

        evaluaRequistos: function(){
            //valida que todos los requistosprevios esten completos y habilita la adicion en el grid
            var i = 0;
            sw = true,
                me =this;
            while( i < me.Componentes.length) {

                if(me.Componentes[i] &&!me.Componentes[i].isValid()){
                    sw = false;
                    //i = this.Componentes.length;
                }
                i++;
            }
            return sw
        },

        bloqueaRequisitos: function(sw){
            this.Cmp.id_plantilla.setDisabled(sw);
            this.cargarDatosMaestro();

        },

        cargarDatosMaestro: function(){
			console.log('this.data.tipo_informe',this.data.tipo_informe);
            this.detCmp.id_orden_trabajo.store.baseParams.fecha_solicitud = this.Cmp.fecha.getValue().dateFormat('d/m/Y');
            this.detCmp.id_orden_trabajo.modificado = true;

            this.detCmp.id_centro_costo.store.baseParams.id_gestion = this.Cmp.id_gestion.getValue();
            this.detCmp.id_centro_costo.store.baseParams.codigo_subsistema = this.codigoSistema;
            this.detCmp.id_centro_costo.store.baseParams.id_depto = this.Cmp.id_depto_conta.getValue();

            if(this.data.id_uo){
                this.detCmp.id_centro_costo.store.baseParams.id_uo = this.data.id_uo;
            }
            this.detCmp.id_centro_costo.modificado = true;
            //cuando esta el la inteface de presupeustos no filtra por bienes o servicios
            //#12 EGS		
            if (this.data.tipo_informe=='ncd') {          	
              this.detCmp.id_concepto_ingas.store.baseParams.movimiento=(this.Cmp.tipo.getValue()=='compra')?'recurso':'gasto';
            } else{
              this.detCmp.id_concepto_ingas.store.baseParams.movimiento=(this.Cmp.tipo.getValue()=='compra')?'gasto':'recurso';	
            };
            //#12 EGS	
            this.detCmp.id_concepto_ingas.store.baseParams.id_gestion=this.Cmp.id_gestion.getValue();
            this.detCmp.id_concepto_ingas.modificado = true;

        },

        evaluaGrilla: function(){
            //al eliminar si no quedan registros en la grilla desbloquea los requisitos en el maestro
            var  count = this.mestore.getCount();
            if(count == 0){
                this.bloqueaRequisitos(false);
            }
        },


        buildDetailGrid: function(){
            var me = this;
            //cantidad,detalle,peso,totalo
            var Items = Ext.data.Record.create([
        ~  {
                name: 'sistema',
                type: 'string'
            },
            {
                name: 'justificacion',
                type: 'string'
            }
            
            ]);
            
            this.itemsRecordDet = Items;

            this.mestore = new Ext.data.JsonStore({
                url: '../../sis_proceso_trabajo/control/VpnDet/listarVpnDet',
                id: 'id_vpn_det',
                root: 'datos',
                totalProperty: 'total',
                fields: ['id_vpn_det','sistema','', 'justificacion',
                    'id_vpn'
                ],remoteSort: true,
                baseParams: {dir:'ASC',sort:'id_vpn_det',limit:'50',start:'0'}
            });

            this.editorDetail = new Ext.ux.grid.RowEditor({
                saveText: 'Aceptar',
                name: 'btn_editor'

            });

            this.summary = new Ext.ux.grid.GridSummary();
            // al iniciar la edicion
            this.editorDetail.on('beforeedit', this.onInitAdd , this);

            //al cancelar la edicion
            this.editorDetail.on('canceledit', this.onCancelAdd , this);

            //al cancelar la edicion
            this.editorDetail.on('validateedit', this.onUpdateRegister, this);

            this.editorDetail.on('afteredit', this.onAfterEdit, this);



            //agrega las columna
            this.columnasDet = [

                ]


            this.columnasDet = this.columnasDet.concat([
                {

                    header: 'Sistema',
                    dataIndex: 'sistema',

                    align: 'center',
                    width: 200,
                    editor: this.detCmp.sistema
                },
                {

                    header: 'Justificacion',
                    dataIndex: 'justificacion',

                    align: 'center',
                    width: 200,
                    editor: this.detCmp.justificacion
                },

                ]);


            this.megrid = new Ext.grid.GridPanel({
                layout: 'fit',
                store:  this.mestore,
                region: 'center',
                split: true,
                border: false,
                plain: true,
                //autoHeight: true,
                plugins: [ this.editorDetail, this.summary ],
                stripeRows: true,
                tbar: [{
                    /*iconCls: 'badd',*/
                    text: '<i class="fa fa-plus-circle fa-lg"></i> Agregar Detalle',
                    scope: this,
                    width: '100',
                    handler: function(){
                        if(this.evaluaRequistos() === true){

                            var e = new Items({

                                justificacion: '',
                                sistema: ''
                            });
                            this.editorDetail.stopEditing();
                            this.mestore.insert(0, e);
                            this.megrid.getView().refresh();
                            this.megrid.getSelectionModel().selectRow(0);
                            this.editorDetail.startEditing(0);
                            this.sw_init_add = true;

                           // this.bloqueaRequisitos(true);
                        }

                    }
                },{
                    ref: '../removeBtn',
                    text: '<i class="fa fa-trash fa-lg"></i> Eliminar',
                    scope:this,
                    handler: function(){
                        this.editorDetail.stopEditing();
                        var s = this.megrid.getSelectionModel().getSelections();
                        for(var i = 0, r; r = s[i]; i++){



                            // si se edita el documento y el concepto esta registrado, marcarlo para eliminar de la base
                            if(r.data.id_vpn_det > 0){
                                this.vpn_det_eliminados.push(r.data.id_vpn_det);
                            }
                            this.mestore.remove(r);
                        }


                        this.evaluaGrilla();
                    }
                }],

                columns: this.columnasDet
            });
            
          
            if(me.plantillaProrrateo.length > 0){
            	this.megrid.getTopToolbar().add({	                   
	                    text: '<i class="fa fa-plus-circle fa-lg"></i> Agregar desde Plantilla',
	                    scope: this,
	                    width: '100',
	                    handler: function(){
	                        if(this.evaluaRequistos() === true){
	                          // this.bloqueaRequisitos(true);
	                          // this.wPlantilla.show();

	                        }
	                   }
	
	           }) ;
            }
            
           
        },
        buildGrupos: function(){
            var me = this;
            if(me.regitrarDetalle == 'si'){
                me.Grupos = [{
                    layout: 'border',
                    border: false,
                    frame:  true,
                    items:[
                        {
                            xtype: 'fieldset',
                            border: false,
                            split: true,
                            layout: 'column',
                            region: 'north',
                            autoScroll: true,
                            collapseFirst : false,
                            collapsible: true,
                            collapseMode : 'mini',
                            width: '100%',
                            height: me.heightHeader,
                            padding: '0 0 0 10',
                            items:[
                                {
                                    bodyStyle: 'padding-right:5px;',
                                    width: '70%',
                                    autoHeight: true,
                                    border: true,
                                    items:[
                                        {
                                            xtype: 'fieldset',
                                            frame: true,
                                            border: false,
                                            layout: 'form',
                                            title: 'Tipo',
                                            width: '100%',

                                            //margins: '0 0 0 5',
                                            padding: '0 0 0 10',
                                            bodyStyle: 'padding-left:5px;',
                                            id_grupo: 0,
                                            items: [],
                                        }]
                                },

                            ]
                        },
                        me.megrid
                    ]
                }];
            }
        },

        loadValoresIniciales:function()
        {
            Phx.vista.FormVpn.superclass.loadValoresIniciales.call(this);
        },


        extraAtributos:[],
        generarAtributos: function(){
            var me = this;
            this.Atributos=[
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
                        fieldLabel: 'Fecha Desde',
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
                        fieldLabel: 'Fecha Hasta',
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
                        fieldLabel: 'Descripcion',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:200
                    },
                    type:'TextField',
                    filters:{pfiltro:'solvpn.descripcion',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:true
                },

            ];

            this.Atributos = this.Atributos.concat(me.extraAtributos);

        },
        title: 'Frm solicitud',
        iniciarEventos: function(){

        },


        onEdit:function(){
            this.accionFormulario = 'EDIT';
            if(this.data.datosOriginales){
                this.loadForm(this.data.datosOriginales);
            }

            console.log('datosOriginales', this.data.datosOriginales)
            //load detalle de conceptos
            if(this.regitrarDetalle == 'si'){
                this.mestore.baseParams.id_vpn = this.Cmp.id_vpn.getValue();
                this.mestore.load()
            }




        },

        onNew: function(){

            this.accionFormulario = 'NEW';

        },

        onSubmit: function(o) {

            var me = this;
            console.log('hola', me.regitrarDetalle);
            if(me.regitrarDetalle == 'si'){
                //  validar formularios
                var arra = [], total_det = 0.0, i;
                for (i = 0; i < me.megrid.store.getCount(); i++) {
                    record = me.megrid.store.getAt(i);
                    arra[i] = record.data;
                    //total_det = total_det + (record.data.precio_total)*1

                }

                //si tiene conceptos eliminados es necesari oincluirlos ...


                me.argumentExtraSubmit = { 'regitrarDetalle': me.regitrarDetalle,
                    'id_vpn_det_elis': this.vpn_det_eliminados.join(),
                    'json_new_records': JSON.stringify(arra, function replacer(key, value) {
                        if (typeof value === 'string') {
                            return String(value).replace(/&/g, "%26")
                        }
                        return value;
                    }) };

                if( i > 0 &&  !this.editorDetail.isVisible()){
                  Phx.vista.FormVpn.superclass.onSubmit.call(this, o, undefined, true);
                 }
            }
            else{
                me.argumentExtraSubmit = { 'regitrarDetalle': me.regitrarDetalle };
                Phx.vista.FormVpn.superclass.onSubmit.call(this, o, undefined, true);
            }
        },


        successSave:function(resp)
        {
            Phx.CP.loadingHide();
            Phx.CP.getPagina(this.idContenedorPadre).reload();
            this.panel.close();
        },

        obtenerVariableGlobal: function(config){
            var me = this;
            //Verifica que la fecha y la moneda hayan sido elegidos
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url:'../../sis_seguridad/control/Subsistema/obtenerVariableGlobal',
                params:{
                    codigo: 'conta_partidas'
                },
                success: function(resp){
                    Phx.CP.loadingHide();
                    var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));

                    if (reg.ROOT.error) {
                        Ext.Msg.alert('Error','Error a recuperar la variable global')
                    } else {
                        if(reg.ROOT.datos.valor != 'si'){
                            me.listadoConcepto = '../../sis_parametros/control/ConceptoIngas/listarConceptoIngas';
                            me.parFilConcepto = 'desc_ingas';
                            me.mostrarPartidas = false;
                        }


                        me.constructorEtapa2(config);

                    }
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope:this
            });

        },

        mensaje_: function (titulo, mensaje) {

            var tipo = 'ext-mb-warning';
            Ext.MessageBox.show({
                title: titulo,
                msg: mensaje,
                buttons: Ext.MessageBox.OK,
                icon: tipo
            })

        },
        //RAC 07122017, crea formulario para plantilla de prorrateo
        buildFormPlantilla: function(){
            var me = this,
                bpar = (me.data.tipoDoc=='compra')?{par_filtro: me.parFilConcepto, movimiento: 'gasto', autorizacion: me.autorizacion, autorizacion_nulos: me.autorizacion_nulos }:{par_filtro: me.parFilConcepto, movimiento: 'recurso'};
            if(me.plantillaProrrateo.length > 0){
                this.formPlantilla = new Ext.form.FormPanel({
                    baseCls: 'x-plain',
                    autoDestroy: true,
                    border: false,
                    layout: 'form',
                    autoHeight: true,
                    items: [
                        new Ext.form.TextArea({
                            name: 'sistema',
                            msgTarget: 'title',
                            fieldLabel: 'sistema',
                            allowBlank: false,
                            anchor: '80%',
                            maxLength:1200
                        }),

                        new Ext.form.TextArea({
                            name: 'justificacion',
                            msgTarget: 'title',
                            fieldLabel: 'Justificacion',
                            allowBlank: false,
                            anchor: '80%',
                            maxLength:1200
                        })

                    ]
                });



                me.wPlantilla = new Ext.Window({
                    title: 'Plantilla de Prorrateo',
                    collapsible: true,
                    maximizable: true,
                    autoDestroy: true,
                    width: 380,
                    height: 170,
                    layout: 'fit',
                    plain: true,
                    bodyStyle: 'padding:5px;',
                    buttonAlign: 'center',
                    items: this.formPlantilla,
                    modal:true,
                    closeAction: 'hide',
                    buttons: [{
                        text: 'Guardar',
                        handler: this.addPltProc,
                        scope: this

                    },
                        {
                            text: 'Cancelar',
                            handler: function(){ me.wPlantilla.hide() },
                            scope: this
                        }]
                });



            }

        },
        addPltProc: function(){
        	var acumulado = 0,
        	    aux = 0,
        	    pTot = 0

                justificacion = this.formPlantilla.getForm().findField('justificacion').getValue();
                sistema = this.formPlantilla.getForm().findField('sistema').getValue();
                
           this.plantillaProrrateo.forEach(function callback(element, index, array) {
		        this.editorDetail.stopEditing();

		        if(index == (me.plantillaProrrateo.length - 1) ){
		        	 aux = (precioDet - acumulado).toFixed(2);
		        }
		        else{
		        	aux = (precioDet * element.factor).toFixed(2);
		        }
		         
		        acumulado = aux*1 + acumulado;
		        pTot = aux - (aux * this.Cmp.porc_descuento.getValue())
		        
		        var e = new this.itemsRecordDet({

                                justificacion: justificacion,
                                sistema:sistema
                            });
              
                this.mestore.insert(0, e);
               
                
                
		    }, this);
		    
		    this.megrid.getView().refresh();
		    this.wPlantilla.hide();
        	
        	
        }

    })
</script>
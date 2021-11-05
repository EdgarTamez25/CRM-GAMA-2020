<template>
	<v-container class="pa-0 py-0">
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
          <strong> {{alerta.texto}} </strong>
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
          </template>
        </v-snackbar>
        
				<v-card-actions class="pa-0 py-0 " >
					<v-card-text class="font-weight-black text-h6">  {{ modoVista === 1? 'NUEVA ORDEN DE TRABJO':'DETALLE ORDEN DE TRABAJO' }} </v-card-text> 
					<v-spacer></v-spacer>
					<v-btn color="error" fab small  @click="$emit('modal',false)" ><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

        <v-row class="mt-1">
          <!-- SELECTOR DE CLIENTES  -->
          <v-col cols="12" sm="7">   
						<v-autocomplete
							v-model="cliente" :items="clientes"  item-text="nombre" item-value="id" label="Clientes" 
							dense filled hide-details color="celeste" append-icon="people" return-object
						></v-autocomplete>
					</v-col> 

          <v-col cols="12" sm="5">
            <v-text-field
              v-model="orden_compra" label="Orden de compra" hide-details dense filled clearable 
            ></v-text-field>
          </v-col>

          
        </v-row>
         
				<v-row>
          <v-col cols="12" class="py-0 pa-0">
            <v-card-actions>
              <v-card-text class="font-weight-black text-h6 py-0 " > 
                PRODUCTOS A SOLICITAR  
              </v-card-text>
              <v-spacer></v-spacer>
              <v-btn 
                color="celeste" dark 
                @click="FormularioProductos= true"
                v-if="cliente.id"
              > Agregar Producto
              </v-btn>
              <v-btn 
                v-else
                color="warning"
                outlined
              > SELECCIONA UN CLIENTE
              </v-btn>
            </v-card-actions>
          </v-col>

          <!-- TABLA DE PRODUCTOS POR SOLICITAR -->
          <v-col cols="12">
            <v-card outlined >
              <v-simple-table fixed-header height="auto" >
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left"> Producto  </th>
                      <th class="text-left"> Cantidad  </th>
                      <th class="text-left"> Unidad  </th>
                      <th class="text-left"> Concepto  </th>
                      <th class="text-left"> Fecha entrega  </th>
                      <th class="text-left"> Urgencia  </th>
                      <th class="text-left"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, i) in detalle" :key="i">
                      <td>{{ item.producto.codigo }}</td>
                      <td>{{ item.cantidad | currency(0) }}</td>
                      <td>PIEZAS</td>
                      <td>
                        <span v-if="item.concepto.id === 1"> PRODUCCION </span>
                        <span v-if="item.concepto.id === 2"> STOCK </span>
                      </td>
                      <td> {{  moment(item.fecha).format('LL')  }} </td>
                      <td>
                        <span v-if="item.urgencia.id === 1"> NORMAL</span>
                        <span v-if="item.urgencia.id === 2"> URGENTE</span>
                        <span v-if="item.urgencia.id === 3"> PRIORIDAD</span>
                      </td>
                      <td>
                        <v-btn color="success" class="ma-1" icon  @click="abrir_detalle_partida(item)"> <v-icon>mdi-pencil</v-icon> </v-btn>
                        <v-btn color="error"   class="ma-1" icon  @click="abrir_eliminar_partida(item)"> <v-icon>mdi-delete</v-icon> </v-btn>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card>
          </v-col>
				</v-row>
        
        <v-col cols="12" class="mt-3"/>
        
        <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
        <v-footer  absolute v-if="modoVista === 1">
          <v-spacer></v-spacer>
          <v-btn 
            color="success"  
            v-if="detalle.length" 
            @click="validaInformacion()" 
          >  Guardar información 
          </v-btn>
        </v-footer>


        <!-- FORMULARIO EDICION-->
        <v-dialog v-model="FormularioProductos" width="600px">
        	<v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
            <strong> {{alerta.texto}} </strong>
            <template v-slot:action="{ attrs }">
              <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
            </template>
          </v-snackbar>

          <v-card class="pa-4">
            <v-row>
              <v-col cols="12" class="py-0 pa-0">
                <v-card-actions class="py-0">
                  <v-card-text class="font-weight-black text-h6"> AGREGAR PRODUCTO </v-card-text>
                  <v-spacer></v-spacer>
                  <v-btn color="error" fab small  @click="cerrar_detalle()" ><v-icon>clear</v-icon></v-btn>
                </v-card-actions>
              </v-col>

              <v-col cols="12" sm="6">
                <v-select
                  v-model="editDetalle.depto" :items="deptos" item-text="nombre" item-value="id" filled color="celeste" 
                  dense hide-details  label="Departamentos" return-object placeholder ="Departamentos" 
                  
                ></v-select> 
              </v-col> 
              <v-col cols="12" sm="6">    
                <v-autocomplete
                  v-model="editDetalle.producto" :items="productos"  item-text="codigo" item-value="id" label="Productos" 
                  dense filled hide-details color="celeste"  return-object
                >
                </v-autocomplete>
              </v-col>

              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="editDetalle.cantidad" label="Cantidad" hide-details dense filled clearable type="number" color="celeste"
                ></v-text-field>
                <span class="font-weight-black mx-3" v-if="editDetalle.cantidad"> 
                  {{ editDetalle.cantidad | currency(0) }}  
                </span>
              </v-col>

              <v-col cols="12" sm="6"  >
                <v-text-field
                  v-model="editDetalle.fecha" label="Fecha entrega" 
                  dense hide-details color="celeste" filled type="date"
                ></v-text-field>
              </v-col> 

              <v-col cols="12" sm="6">
                <v-select
                  v-model="editDetalle.urgencia" :items="urgencias" item-text="nombre" item-value="id" filled color="celeste" 
                  dense hide-details  label="Urgencia" return-object 
                ></v-select> 
              </v-col>


            </v-row>
            <div class="mt-12"></div>
            <v-footer absolute fixed>
              <v-spacer></v-spacer>
              <v-btn dark color="success" @click="guardar_detalle_partida_local()" >  Guardar Información  </v-btn> 
            </v-footer>
          </v-card>
        </v-dialog>
        
        <!-- ALERTA ELIMINAR-->
        <v-dialog v-model="alertaEliminar" persistent width="400">
          <v-card>
            <v-card-title class="subtitle-1 font-weight-black " style="word-break:normal;">¿ESTÁS SEGURO DE QUERER ELIMINAR LA PARTIDA ? </v-card-title>
            <v-divider class="my-0 py-3" ></v-divider>
            <v-card-subtitle align="center" class="red--text font-weight-bold "> LA INFORMACIÓN SE PERDERÁ COMPLETAMENTE </v-card-subtitle>
            <v-divider class="my-0 py-2 " ></v-divider>
            <v-card-actions>
              <v-btn color="gris"    dark   @click="alertaEliminar=false" >  NO, Cancelar </v-btn>
              <v-spacer/>
              <v-btn color="celeste" text   @click="editarEliminarPartida()" >  SÍ, Eliminar </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
          
        <!-- MODAL PARA ALIMINAR REGISTRO -->
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card class="pa-1" dark>
            <v-card-title class="text-h6 font-weight-bold" style="word-break:normal;"  > ¿Estas seguro de querer eliminar este registro?</v-card-title>
            <v-card-text  class="subtitle-1 font-weight-bold text-center warning--text"> Una vez eliminado no se podra recuperar</v-card-text>
            <v-divider class="verde"></v-divider>
            <v-card-actions>
              <v-btn color="warning darken-1"    @click="cerrar_eliminar_partida()">Cancelar</v-btn>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text dark @click="eliminar_partida_local()">Sí, Seguro</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <overlay v-if="overlay"/>
			</v-col>
		</v-row>
	</v-container>
	
</template>

<script>
  import Vue from 'vue'
  import {mapGetters, mapActions} from 'vuex'
  import metodos from '@/mixins/metodos.js';
  import overlay from '@/components/overlay.vue';
  import loading from '@/components/loading.vue';

  var accounting = require("accounting");
  Vue.filter('currency', (val, dec) => { return accounting.formatMoney(val, '', dec) });

	export default {
		mixins:[metodos],
		// mixins:[metodos,jsPdf],
	  components: {
      overlay,
      loading
		},
		props:[
			'modoVista',
			'parametros',
	  ],
	  data () {
			return {
        // VARIABLES PRINCIPALES
        idEditar: null,
        idAEliminar: null,
        alertaEliminar: false,
        
        FormularioProductos: false,
        dialogDelete:false,
        editedIndex: -1,
        defaultDetalle:{ 
          depto   : { id:null, nombre:''},
          producto: {id:null, nombre:''},
          urgencia: { id: null, nombre:''},
          cantidad: null, 
          fecha   : new Date().toISOString().substr(0, 10),
        },
        editDetalle:{
          depto   : { id:null, nombre:''},
          producto: {id:null, nombre:''},
          urgencia: { id: null, nombre:''},
          cantidad: null, 
          fecha   : new Date().toISOString().substr(0, 10),
        },

        orden_compra:'',
        detalle: [],
        modo: 1,
        
        usuarios : [],
        cliente: { id:null, nombre:'' },
				clientes : [],
        deptos   : [],
				productos: [],
        urgencias:[{id:1, nombre:'NORMAL'},{id:2, nombre:'URGENTE'},{ id:3, nombre:'PRIORIDAD'}],
        conceptos: [{id:1, nombre:'PRODUCCION'}, {id:2, nombre:'STOCK'}],
				
				// ALERTAS
				alerta : { activo: false, texto:'', color:'error'},
        overlay: false,
			}
		},
		
		async created(){
      this.clientes = await this.consultar_Clientes();
      this.deptos   = await this.consultar_deptos_por_suc(2);
      this.usuarios = await this.consultar_Usuarios();
			// this.validarModoVista(); 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('Login'    ,['getdatosUsuario']), 
			...mapGetters('OT',['Parametros']), // IMPORTANDO USO DE VUEX - (GETTERS)

      VALIDACION_PARTIDA(){
        return this.editDetalle.depto.id != null && 
               this.editDetalle.producto.id != null &&
               this.editDetalle.cantidad > 0 &&
               this.editDetalle.urgencia.id != null;
      }
		},

		watch:{ 
      modoVista(){
        // this.validarModoVista();
      },
      parametros(){ 
        // this.validarModoVista(); 	
      },

      async 'editDetalle.depto'(){
        if(this.cliente.id && this.editDetalle.depto){
          const payload = {
            id_cliente : this.cliente.id,
            id_depto   : this.editDetalle.depto.id 
        }
          this.productos = await this.consulta_prod_por_cliente(payload);
        }else{
          return 
        }
      },
    },

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
				// ...mapActions('ProductosxCliente',['consultaPxCxD']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			...mapActions('OT'  ,['consultaOT','guardaParametrosConsulta']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

      abrir_detalle_partida(item){
        this.editedIndex = this.detalle.indexOf(item); // !OBTENGO EL INDICE DEL REGISTRO ( POSICION )
        this.editDetalle = Object.assign({}, item);    // ! ASIGNO EL VALOR DEL REGISTRO A LA EDICION DE DETALLE
        this.FormularioProductos = true;               // ! ACTIVO MODAL PARA EDITAR
      },

      guardar_detalle_partida_local() {
        if(!this.VALIDACION_PARTIDA){
          this.alerta = { activo: true, texto:'No puedes dejar campos vacios', color:'error'};
          return;
        }
        // ! SI EL INDEX ES -1 ES IGUAL A NUEVO REGISITRO SI NO ES EDICION
        if (this.editedIndex > -1) {
          // !ASIGNO EL NUEVO VALOR AL REGISTRO
          Object.assign(this.detalle[this.editedIndex], this.editDetalle)
        } else {
          // !INSERTO UN NUEVO ELEMENTO AL ARRAY
          let detalle = { concepto: {id:1, nombre:'PRODUCCION'}, ...this.editDetalle }
          this.detalle.push(detalle);
        }
        this.cerrar_detalle()
      },

      cerrar_detalle() {
        this.FormularioProductos = false; //! CIERRO MODAL DE ELIMINACION DE REGISTRO
        this.$nextTick(() => {            //! FUNCION ESPECIFICA PARA RETORNAR A LOS VALORES DEFAULTS
          this.editDetalle = Object.assign({}, this.defaultDetalle)
          this.editedIndex = -1
        })
      },

      abrir_eliminar_partida(item) {
        this.editedIndex = this.detalle.indexOf(item); // !OBTENGO EL INDICE DEL REGISTRO ( POSICION )
        this.editDetalle = Object.assign({}, item);         // ! ASIGNO EL VALOR DEL REGISTRO A LA EDICION DE DETALLE
        this.dialogDelete = true;                           // ! ACTIVO MODAL PARA ELIMINAR
      },

      eliminar_partida_local() {
        this.detalle.splice(this.editedIndex, 1)
        this.cerrar_eliminar_partida()
      },

      cerrar_eliminar_partida() {
        this.dialogDelete = false //! CIERRO MODAL DE ELIMINACION DE REGISTRO
        this.$nextTick(() => {    //! FUNCION ESPECIFICA PARA RETORNAR A LOS VALORES DEFAULTS
          this.editDetalle = Object.assign({}, this.defaultDetalle)
          this.editedIndex = -1
        })
      },

      validaInformacion(){
				if(!this.cliente.id)	    { this.alerta = { activo: true, texto:"DEBES AGREGAR EL CLIENTE QUE SOLICITA EL PRODUCTO", color:'error' }; return }
				if(!this.detalle.length)	{ this.alerta = { activo: true, texto:"DEBES AGREGAR AL MENOS 1 PRODUCTO"                , color:'error' }; return }
				this.PrepararPeticion()
			},

      PrepararPeticion(){
        this.overlay = true; 
        // FORMAR ARRAY A MANDAR
        const payload = {
          id_cliente     : this.cliente.id,
          id_solicitante : this.getdatosUsuario.id,
          id_solicitud   : null ,
          oc             : this.orden_compra ? this.orden_compra : '',
          fecha          : this.traerFechaActual(),
          hora           : this.traerHoraActual(),
          id_creador     : this.getdatosUsuario.id,
          detalle        : this.detalle,
          fecha_procesado: this.traerFechaActual() + ' ' + this.traerHoraActual(),
          sistema        : 'CRM'
        }

        this.$http.post('crear.orden.trabajo', payload).then( response =>{
            this.alerta = { activo: true, text: response.bodyText, color:'green'};
            this.TerminarProceso();
        }).catch(error =>{
            this.alerta = { activo: true, text: error.bodyText, color:'error'};
        }).finally(()=>{
          this.overlay = false
        })
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				// this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
			},
      
      TerminarProceso(mensaje){
				var that = this ;
        this.limpiarCampos()
				this.consultaOT(this.Parametros) //ACTUALIZAR CONSULTA DE CLIENTES
        setTimeout(function(){ that.$emit('modal',false)}, 2000);
				setTimeout(function(){ that.limpiarCampos()}, 2000);
			},
      
      limpiarCampos(){
        this.cerrar_detalle();
        this.detalle = [];
        this.orden_compra = '';
      }



    
      
		}
	}
</script>
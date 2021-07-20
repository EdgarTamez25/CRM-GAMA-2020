<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
          <strong> {{alerta.texto}} </strong>
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
          </template>
        </v-snackbar>
        
				<v-card-actions class="pa-0" >

					<!-- <h3> <strong> {{ modoVista === 1? 'NUEVA ORDEN DE TRABJO':'EDITAR ORDEN DE TRABAJO' }} </strong></h3>  -->
					<h3> <strong> {{ modoVista === 1? 'NUEVA ORDEN DE TRABJO':'EDITAR ORDEN DE TRABAJO' }} </strong></h3> 

					<v-spacer></v-spacer>
					<v-btn color="error" filled @click="$emit('modal',false)" ><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<!-- <v-divider class="mt-2"></v-divider> -->

				<v-row>
					<v-col cols="12" sm="6" >  <!-- VENDEDORES -->
						<v-autocomplete
							:items="usuarios" v-model="usuario" item-text="nombre" tem-value="id" label="Responsable" 
							dense filled hide-details color="celeste" append-icon="persons" return-object disabled
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6" > <!-- CLIENTE -->
						<v-autocomplete
							:items="clientes" v-model="cliente" item-text="nombre" item-value="id" label="Clientes" 
							dense filled hide-details color="celeste" append-icon="people" return-object
              :disabled="detalle.length? true: false"
						></v-autocomplete>
					</v-col>

          <v-col cols="12" sm="6">
            <v-text-field
              v-model="orden_compra" label="Orden de compra" hide-details dense filled clearable 
            ></v-text-field>
          </v-col>

          <v-col cols="12" sm="6">
            <v-text-field
              v-model="id_solicitud" label="Solicitud" hide-details dense filled clearable disabled
            ></v-text-field>
          </v-col>

          <!-- <v-col cols="12" sm="6"  >
            <v-dialog ref="fecha1" v-model="fechamodal1" :return-value.sync="fecha1" persistent width="290px">
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="fecha1" label="Fecha entrega" append-icon="event" readonly v-on="on"
                    dense hide-details color="celeste" filled
                ></v-text-field>
              </template>
              <v-date-picker v-model="fecha1" locale="es-es" color="rosa"  scrollable>
                <v-spacer></v-spacer>
                <v-btn text small color="gris" @click="fechamodal1 = false">Cancelar</v-btn>
                <v-btn dark small color="rosa" @click="$refs.fecha1.save(fecha1)">OK</v-btn>
              </v-date-picker>
            </v-dialog>
          </v-col> -->

          <v-col cols="12" class="text-right" >
            <v-btn v-if="modoVista===2 && parametros.estatus != 3 " :disabled="orden_compra? false:true" 
                   color="rosa" dark @click="PrepararPeticion()">  Actualizar Orden de trabajo 
            </v-btn>
          </v-col>

          <v-col cols="12" sm="8" class="py-0">
            <v-card-text class="font-weight-black subtitle-1 py-0" > 
              PRODUCTOS A SOLICITAR 
            </v-card-text>
          </v-col>
          <!-- <v-col cols="12" sm="4" class="py-0 text-right">
            <v-btn v-if="modoVista===2" color="gris" dark block small @click="FormularioProductos = !FormularioProductos"> 
              {{ FormularioProductos ? 'Esconder Formulario': 'Habilitar Formulario' }}  
            </v-btn>
          </v-col> -->

          <template v-if="FormularioProductos">
            <v-col cols="12" sm="6">
              <v-select
                v-model="depto" :items="deptos" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details  label="Departamentos" return-object placeholder ="Departamentos" disabled
                
              ></v-select> 
            </v-col>
            <v-col cols="12" sm="6">  <!-- PRODUCTOS -->
              <v-autocomplete
                :items="productos" v-model="producto" item-text="codigo" item-value="id" label="Productos" 
                dense outlined hide-details color="celeste" append-icon="print" return-object
                :disabled="cliente.id && modo ==1 ? false: true"
              >
              </v-autocomplete>
            </v-col>

            <v-col cols="12" sm="6">
              <v-text-field
                v-model="cantidad" label="Cantidad" hide-details dense outlined clearable
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="6">
              <v-select
                v-model="concepto" :items="conceptos" item-text="nombre" item-value="id" color="celeste" 
                dense hide-details  label="Conceptos" return-object outlined
              ></v-select> 
            </v-col>

            <v-col cols="12" sm="6">
              <v-select
                v-model="urgencia" :items="urgencias" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details  label="Urgencia" return-object 
              ></v-select> 
            </v-col>

            <v-col cols="12" sm="6" > 
              <v-textarea
                v-model ="razon" outlined label="Razon de la urgencia" rows="2" 
                hide-details dense :disabled="urgencia.id != 1 && urgencia.id ? false:true"
              ></v-textarea>
            </v-col>

            <v-col cols="12" sm="6" class="py-0 text-right" v-if="modo === 1"> 
              <v-btn color="celeste" dark  @click="validarPartida(1) "> Agregar partida</v-btn> 
            </v-col>
          </template>

          
          <v-col cols="6" class="py-0" v-if="modo === 2"> 
            <v-btn color="gris" dark block @click="limpiarCamposPartida()"> CANCELAR</v-btn>
           </v-col>
          <v-col cols="6" class="py-0" v-if="modo === 2"> 
            <v-btn color="celeste" dark block @click="validarPartida(2)"> Actualizar partida</v-btn>
          </v-col>

          <!-- TABLA DE PRODUCTOS POR SOLICITAR -->
          <v-col cols="12">
            <loading v-if="!detalle.length && modoVista != 1"/>
            <v-card outlined v-else>
              <v-simple-table fixed-header height="auto" >
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left"> #  </th>
                      <th class="text-left"> Producto  </th>
                      <th class="text-left"> Cantidad  </th>
                      <th class="text-left"> Concepto  </th>
                      <!-- <th class="text-left"> Entrega </th> -->
                      <th class="text-left"> Urgencia  </th>
                      <th class="text-left"> Estatus</th>

                      <th class="text-left"></th>


                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, i) in detalle" :key="i">
                      <td>{{ item.partida }}</td>
                      <td>{{ item.producto }}</td>
                      <td>{{ item.cantidad }}</td>
                      <td>
                        <span v-if="item.concepto === 1"> PRODUCCION </span>
                        <span v-if="item.concepto === 2"> STOCK </span>
                      </td>
                      <!-- <td>{{ item.fecha_entrega }}</td> -->
                      <td>
                        <span v-if="item.urgencia === 1"> NORMAL</span>
                        <span v-if="item.urgencia === 2"> URGENTE</span>
                        <span v-if="item.urgencia === 3"> PRIORIDAD</span>
                      </td>
                      <td>
                        <span class="error--text font-weight-black" v-if="item.estatus === 1"> PENDIENTE</span>
                        <span class="orange--text font-weight-black" v-if="item.estatus === 2"> PROGRAMADA</span>
                        <span class="success--text font-weight-black" v-if="item.estatus === 3"> FINALIZADA</span>
                      </td>
                      <td v-if="item.estatus === 1" >
                        <v-btn color="success" class="ma-1" icon v-if="parametros.estatus === 1" @click="rellenaCampos(item)"> <v-icon>mdi-pencil</v-icon> </v-btn>
                        <v-btn color="error"   class="ma-1" icon v-if="parametros.estatus === 1" @click="eliminaPartida(item.id)"> <v-icon>mdi-delete</v-icon> </v-btn>
                      </td>
                      
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card>
          </v-col>
          
				</v-row>
        <!-- <v-col cols="12" align="center" v-if="detalle.length && modoVista != 1">
          <v-btn color="success" dark rounded small @click="imprimirPDF()">Imprimir</v-btn>
        </v-col> -->
        <v-col cols="12" class="mt-3"/>
        
        
        <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
        <v-footer  absolute v-if="modoVista === 1">
          <v-spacer></v-spacer>
          <v-btn color="success" small v-if="modoVista===1" @click="validaInformacion()" >  Guardar información </v-btn>
          <v-btn color="success" small v-if="modoVista===2" @click="validaInformacion()" >  Actualizar información </v-btn>
        </v-footer>

        <v-dialog v-model="Correcto" hide-overlay persistent width="350">
          <v-card :color="colorCorrecto" dark class="pa-3">
            <v-card-text class="font-weight-black headline pa-3 white--text" align="center">
              {{ textCorrecto }}
            </v-card-text>
          </v-card>
        </v-dialog>

        <v-dialog v-model="alertaEliminar"  persistent width="350">
          <v-card class="pa-3" color="red darken-4">
            <v-card-text class="font-weight-black subtitle-1 pa-3 white--text" align="left">
              ¿ ESTAS SEGURO DE QUERER ELIMINAR LA PARTIDA ?
            </v-card-text>
            <v-card-subtitle class=" white--text" align="left">
              La información se perdera completamente.
            </v-card-subtitle>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="gris"    dark small  @click="alertaEliminar=false" >  Cancelar </v-btn>
              <v-btn color="celeste" dark small  @click="editarEliminarPartida()" >  Eliminar </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
          
        <overlay v-if="overlay"/>

			</v-col>
		</v-row>
	</v-container>
	
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import  metodos from '@/mixins/metodos.js';
	import  jsPdf   from '@/mixins/jsPdf.js';
  import overlay     from '@/components/overlay.vue';
  import loading     from '@/components/loading.vue';

	export default {
		mixins:[metodos,jsPdf],
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
        FormularioProductos: true,

        orden_compra:'',
        id_solicitud:null,
        cantidad: '',
        razon:'',
        detalle: [],
        modo: 1,
				// FECHA
        fecha1: new Date().toISOString().substr(0, 10),
        fechamodal1:false,

        deptos: [],
        depto: { id: null, nombre:''},
        concepto: { id: null, nombre:''},
        conceptos: [{id:1, nombre:'PRODUCCION'}, {id:2, nombre:'STOCK'}],

        urgencias:[{id:1, nombre:'NORMAL'},{id:2, nombre:'URGENTE'},{ id:3, nombre:'PRIORIDAD'}],
        urgencia: { id:null, nombre:''},
				// AUTOCOMPLETE
				usuarios : [],
				usuario	 : {id:null, nombre:''},
				clientes	: [],
				cliente		: {id:null, nombre:''},
				// SELECTORES
				producto    : { id:null, nombre:''},
				productos   : [],
				// ALERTAS
				alerta: { activo: false, texto:'', color:'error'},

        overlay     : false,
				textDialog  :'',
				Correcto    : false,
        textCorrecto: '',
        colorCorrecto: 'success',
			}
		},
		
		created(){
      this.consultar_Usuarios();
			// this.consultar_Vendedores();
      this.consultar_Clientes();
      this.consultaDepartamentos();
			this.validarModoVista(); 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('Login'    ,['getdatosUsuario']), 
      ...mapGetters('ProductosxCliente' ,['Loading','getPxCxD']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
			...mapGetters('OT'    ,['Parametros']), // IMPORTANDO USO DE VUEX - (GETTERS)

		},

		watch:{ 
      modoVista(){
        this.validarModoVista();
      },
      parametros(){ 
        this.validarModoVista(); 	
      } ,
      // depto(){
      //   // if(this.cliente.id){
      //   //   const payload = new Object();
      //   //   payload.id_depto   = this.depto.id 
      //   //   payload.id_cliente = this.cliente.id
      //   //   this.consultaPxCxD(payload)
          
      //   // }
      // },
      // cliente(){
      //   // if(!this.depto.id){ this.depto = { id:1, nombre:'FLEXOGRAFÍA'} }
      //   // if(this.cliente.id){ 
      //     // const payload = new Object();
      //     //   payload.id_cliente = this.cliente.id
      //     // this.consultaProdxCliente( this.cliente.id).then(response =>{
      //     //   this.producto = { id: this.detalle.id_producto }
      //     // })
      //   // }
      // }
      
    },

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
				...mapActions('ProductosxCliente',['consultaPxCxD']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			  ...mapActions('OT'  ,['consultaOT','guardaParametrosConsulta']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
    
      validarPartida(modo){
        this.modo = modo;
        // if(!this.producto.id)	{ this.alerta = { activo: true, texto:'DEBES SELECCIONAR UN PRODUCTO' , color:'error'}; return }
        if(!this.cantidad)		{ this.alerta = { activo: true, texto:'DEBES ESPECIFICAR UNA CANTIDAD', color:'error'}; return }
        if(!this.concepto.id) { this.alerta = { activo: true, texto:'DEBES SELECCIONAR UN CONCEPTO' , color:'error'}; return }
        // if(!this.fecha1)			{ this.alerta = { activo: true, texto:'DEBES SELECCIONAR UN PRODUCTO' , color:'error'}; return }
        if(!this.urgencia.id) { this.alerta = { activo: true, texto:'DEBES SELECCIONAR LA URGENCIA DE LA O.T.' , color:'error'}; return }
        if(this.urgencia.id != 1 && !this.razon) { 
            this.alerta = { activo: true, texto:'TIENES QUE ESCRIBIR LA RAZON DE LA URGENCIA.' , color:'error'}; return;
        }
        // let error = false
        // if(this.modo === 1){ for(let i=0; i<this.detalle.length; i++){ if(this.detalle[i].id_producto === this.producto.id){ error = true } } };
        // if(error){ this.alerta = { activo: true, texto:'ESTE PRODUCTO YA EXISTE EN LA LISTA' , color:'error'}; return; }
        
        this.modo === 1 ? this.agregarPartida(): this.editaPartida();
      },

      agregarPartida(){
        const partida = new Object();
              partida.id            = this.detalle.length + 1 ;
              partida.id_ot         = this.modoVista === 2 ? this.parametros.id: '';
              partida.id_producto   = this.producto.id;
              partida.producto      = this.producto.nombre;
              partida.cantidad      = this.cantidad;
              partida.concepto      = this.concepto.id;
              partida.fecha_progra  = this.traerFechaActual();
              partida.fecha_entrega = this.fecha1;
              partida.urgencia      = this.urgencia.id;
              partida.razon         = this.razon? this.razon:'';
        
        if(this.modoVista === 1){
          this.detalle.push(partida);
          this.limpiarCamposPartida();
          this.alerta = { activo: true, texto:'LA PARTIDA SE AGREGO CORRECTAMENTE' , color:'success'}; 
        }

        if(this.modoVista === 2 ){
          this.$http.post('agregar.partida.detot', partida).then(response =>{
            this.consultaDetalle(this.parametros.id)
            this.limpiarCamposPartida();
            this.alerta = { activo: true, texto:response.bodyText , color:'success'}; 
          }).catch(error =>{ console.log('error', error)})
        }

      },

      rellenaCampos(item){
        // console.log('item', item);
        this.FormularioProductos = true;
        this.idEditar = item.id;
        this.cantidad = item.cantidad;
        this.concepto = { id: item.concepto };
        this.depto    = { id: item.id_depto };
        // this.fecha1   = item.fecha_entrega;
        this.urgencia = { id: item.urgencia };
        this.razon    = item.razon;
        this.producto = { id: item.id_producto, nombre: item.producto };

        this.modo     = 2;
      },

      editaPartida(){
        if(this.modoVista === 1 ){
            this.detalle = this.detalle.map( item => { 
            if(item.id === this.idEditar){
              item.id_producto   = this.producto.id;
              item.producto      = this.producto.nombre;
              item.cantidad      = this.cantidad;
              item.concepto      = this.concepto.id
              item.fecha_entrega = this.fecha1;
              item.urgencia      = this.urgencia.id;
              item.razon         = this.razon? this.razon:'';
            }
            return item;
          })
        }

        if(this.modoVista === 2){
          const payload = new Object();
                payload.id            = this.idEditar;
                payload.id_producto   = this.producto.id;
                payload.cantidad      = this.cantidad;
                payload.concepto      = this.concepto.id;
                payload.urgencia      = this.urgencia.id;
                payload.razon         = this.razon? this.razon:'';

          this.$http.post('actualiza.partida.detot',payload).then(response =>{
            this.consultaDetalle(this.parametros.id)
            this.alerta = { activo: true, texto:response.bodyText , color:'success'}; 
            this.limpiarCamposPartida();
            this.modo = 1 ;
          }).catch(error =>{ 
            console.log('error', error)
          })
        }
        
        
      },

      limpiarCamposPartida(){
        this.FormularioProductos = false; 
        this.producto = { id:null, nombre:'' };
        this.cantidad = '';
        this.concepto = { id:null, nombre:'' };
        this.fecha    = new Date().toISOString().substr(0, 10);
        this.urgencia = { id:null, nombre:''};
        this.razon    = '';
        this.modo     = 1;
      },

      eliminaPartida(id){
        if(this.modoVista === 1){
          this.detalle = this.detalle.filter( item => { if(item.id != id){ return item; }; });  
          this.alerta = { activo: true, texto:'LA PARTIDA SE ELIMINO CORRECTAMENTE' , color:'success'}; 
        }

        if(this.modoVista === 2){
          // console.log('')
          if(this.detalle.length <= 1){
            this.alerta = { activo: true, texto:'Debe haber al menos 1 producto en la lista.' , color:'error'}; 
            return;
          }
          this.idAEliminar = id;
          this.alertaEliminar = true; 
        }
        
      },

      editarEliminarPartida(){
        this.$http.delete('elimina.partida.detot/'+ this.idAEliminar).then( response =>{
          this.consultaDetalle(this.parametros.id)
          this.alertaEliminar = false;
          this.alerta = { activo: true, texto:response.bodyText , color:'success'}; 
        }).catch( error => { console.log('error', error)})
      },

			validarModoVista(){
				if(this.modoVista === 2){
          this.FormularioProductos = false;
          // ASIGNAR VALORES AL FORMULARIO
          // this.depto        = { id: this.parametros.id_depto }
          this.usuario      = { id: this.parametros.id_solicitante , nombre: this.parametros.solicitante }
					this.cliente      = { id: this.parametros.id_cliente  , nombre: this.nomcli}
          this.orden_compra = this.parametros.oc;
          this.id_solicitud   = this.parametros.id_solicitud;
          this.consultaDetalle(this.parametros.id);
          this.consultaProdxCliente( this.cliente.id).then(response =>{
            // console.log('response', response)
            this.productos = response
          })

				}else{
				  this.limpiarCampos()
				}
      },
      
      consultaDetalle(id){
        this.$http.get('detalle.ot/'+ id).then((response)=>{
          // console.log('det', response.body)
          this.detalle = response.body
        }).catch( error =>{ console.log('error', error) })
      },

			validaInformacion(){
				if(!this.depto.id)	 	    { this.alerta = { activo: true, texto:'DEBES AGREGAR EL DEPARTAMENTO'           , color:'error'}; return }
				if(!this.usuario.id)		  { this.alerta = { activo: true, texto:'DEBES AGREGAR EL RESPONSABLE DEL PEDIDO'          , color:'error' }; return }
				if(!this.cliente.id)	    { this.alerta = { activo: true, texto:"DEBES AGREGAR EL CLIENTE QUE SOLICITA EL PRODUCTO", color:'error' }; return }
				if(!this.detalle.length)	{ this.alerta = { activo: true, texto:"DEBES AGREGAR AL MENOS 1 PRODUCTO"                , color:'error' }; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
        this.overlay = true; 
        // FORMAR ARRAY A MANDAR
        const payload = new Object();
              // payload.id_depto     = this.depto.id,
              payload.id_sucursal  = this.getdatosUsuario.id_sucursal,
              payload.id_usuario   = this.usuario.id,
              payload.id_cliente   = this.cliente.id,
              payload.oc			     = this.orden_compra? this.orden_compra: 'SIN O.C.',
              payload.referencia   = this.referencia ? this.referencia : 'SIN REFERENCIA',
              payload.fecha        = this.traerFechaActual(),
              payload.hora			   = this.traerHoraActual(),
              payload.creacion     = this.traerFechaActual() + ' '+ this.traerHoraActual(),
              payload.id_creador   = this.getdatosUsuario.id,
              payload.detalle      = this.detalle

				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
			},

			Crear(payload){
				this.$http.post('crear.orden.trabajo', payload).then((response)=>{
          // console.log('response', response)
					this.TerminarProceso(response.bodyText);					
				}).catch(error =>{
					this.mostrarError(error.bodyText)
				}).finally(() => this.overlay = false) 
			},

			Actualizar(payload){
				this.$http.put('actualiza.ot/'+ this.parametros.id, payload).then((response)=>{
          this.alerta = { activo: true, texto: response.bodyText, color:'green' }
				  this.consultaOT(this.Parametros) //ACTUALIZAR CONSULTA DE CLIENTES

				}).catch(error =>{
          this.alerta = { activo: true, texto: error.bodyText, color:'error' }
				}).finally(() => this.overlay = false)
			},
	
			TerminarProceso(mensaje){
				var that = this ;
        this.Correcto = true ; this.textCorrecto = mensaje;
				this.consultaOT(this.Parametros) //ACTUALIZAR CONSULTA DE CLIENTES
        setTimeout(function(){ that.$emit('modal',false)}, 2000);
				setTimeout(function(){ that.limpiarCampos()}, 2000);
        
			},

			limpiarCampos(){
        this.FormularioProductos = true;
        this.producto = { id:null, nombre:'' };
        this.cantidad = '';
        this.concepto = { id:null, nombre:'' };
        this.fecha    = new Date().toISOString().substr(0, 10);
        this.urgencia = { id:null, nombre:''};
        this.razon    = '';
        this.modo     = 1;
        this.usuario = { id: null, nombre:''};
        // this.depto    = { id: null, nombre:''};
        this.cliente  = { id: null, nombre:''};
        this.orden_compra = '';
        this.referencia   = '';
        this.detalle      = [];
			},

			mostrarError(mensaje){
				this.snackbar=true; this.text=mensaje; this.color = "error";
      },
      
      imprimirPDF(){
        // let deptos = this.deptos.filter(item =>{ if(this.depto.id === item.id ){ return item.nombre} })
        let info = [ { text: "Orden de trabajo", value: this.parametros.id         }, 
                    //  { text: "Departamento"    , value:deptos[0].nombre }, 
                     { text: "Responsable"     , value: this.parametros.nomusuario ?  this.parametros.nomusuario : '' }, 
                     { text: "Cliente"         , value: this.parametros.nomcli    },
                     { text: "Orden de Compra" , value: this.parametros.oc         }, 
                     { text: "Referencia"      , value: this.parametros.referencia }, 
                    ];
        let columnas = [  { title: "Producto" , dataKey: "producto"        }, 
                          { title: "Cantidad" , dataKey: "cantidad"        }, 
                          { title: "Concepto" , dataKey: "concepto"        }, 
                          { title: "Programado"   , dataKey: "fecha_progra"    },
                          { title: "Entrega"  , dataKey: "fecha_entrega"   },
                          { title: "Urgencia" , dataKey: "urgencia"        }, 
                        ];
        
        this.generatePDF(columnas, this.detalle, info);
      }
      
		}
	}
</script>
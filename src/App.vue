<template>
  <v-app id="inspire">
    <!-- <div :class="loading">Loading&#8230;</div> -->
    <v-navigation-drawer 
      v-model="drawer" 
      app
      :mini-variant.sync="mini"
      class="elevation-3 mt-2"
      style="border-radius:12px"
      dark
      >
      <v-list dense nav class="py-0">
        <v-list-item two-line  @click="mini= !mini">
          <v-list-item-avatar size="30px">
            <img src="http://producciongama.com/CRM-GAMA-2020/imagenes/person.png">
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title> {{ getdatosUsuario.nombre }} </v-list-item-title>
            <!-- <v-list-item-subtitle> {{ niveles[getdatosUsuario.nivel-1] }}</v-list-item-subtitle> -->
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
      </v-list>
    
     <v-list dense>
        <template v-for="control in AppControl">
          <v-list-item
            v-for="(child, i) in control.admin"
            :key="i"
            :to="child.path"
            color= "rosa"
            @click="mini= !mini"
          >
            <v-list-item-icon>
              <v-icon>{{ child.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content >
              <v-list-item-title >
                {{ child.text }} 
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>

        </template>
      </v-list>
      <!-- ADMINISTRACION -->
      <v-list dense >
        <template v-for="admin in AppControl">

          <v-list-group 
            v-model="admin.model" 
            v-if="admin.administracion" :key="admin.title"  
            :prepend-icon="admin.icon"
            color="rosa"
          >
            <template v-slot:activator>
              <v-list-item>
                <v-list-item-content >
                  <v-list-item-title > 
                   {{ admin.title}}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>

            <v-list-item
              v-for="(child, i) in admin.administracion"
              :key="i"
              :to="child.path"
              dense
              @click="mini= !mini"
            >
               <v-list-item-action v-if="child.icon">
                  <v-icon>{{ child.icon }}</v-icon>
                </v-list-item-action>
                
              <v-list-item-content >
                <v-list-item-title >
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>

              
            </v-list-item>
          </v-list-group>
        </template>
      </v-list>

      <!-- CATALOGOS -->
      <v-list dense >
        <template v-for="cat in AppControl">

          <v-list-group 
             v-model="cat.model"
             v-if="cat.catalogos" 
             :key="cat.title"  
             :prepend-icon="cat.icon"
             color="rosa"
          >
            <template v-slot:activator>
              <v-list-item>
                <v-list-item-content >
                  <v-list-item-title > 
                   {{ cat.title}}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>

            <v-list-item
              v-for="(child, i) in cat.catalogos"
              :key="i"
              :to="child.path"
              dense
              @click="mini= !mini"
            >
            <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              
              <v-list-item-content >
                <v-list-item-title >
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
              
              
            </v-list-item>
          </v-list-group>
        </template>
      </v-list>

      <!--<v-divider></v-divider>
      <v-card-actions>
        <v-btn color="red" outlined block small @click="cerrar_sesion=true">Cerrar Sesión
          <v-icon right>mdi-exit-to-app</v-icon>
        </v-btn>
      </v-card-actions> -->

    </v-navigation-drawer>

    <!-- <v-content class="ma-3"> -->

    <v-snackbar v-model="alerta.activo" multi-line :vertical="alerta.vertical" top right :color="alerta.color" > 
      <strong> {{alerta.texto}} </strong>
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
      </template>
    </v-snackbar>


    <!-- MODAL PARA LA MONEDA PREDETERMINADA -->
    <!-- <div class="text-center">
      <v-dialog v-model="dialogMoneda" width="400"  >
        <v-card class="">
          <v-card-title class="headline white--text rosa"  >
            Moneda 
            <v-spacer></v-spacer>
					  <v-btn color="white" small @click="dialogMoneda=false" text><v-icon>clear</v-icon></v-btn>
          </v-card-title>
          
            <div class="pa-4">
              <v-select
                :items="monedas"
                label="Moneda"
                placeholder="Moneda"
                append-icon="attach_money"
                dense
                hide-details
                v-model="Moneda"
                color="rosa"
              ></v-select>
            </div>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="celeste" text @click="MonedaPredeterminada" > Guardar </v-btn>
          </v-card-actions>

        </v-card>
      </v-dialog>
    </div> -->

       <!-- v-if="getLogeado" @click.stop="drawer = !drawer"-->
    <v-app-bar app color="rosa" dark class="elevation-4 ma-2" v-ripple  style="border-radius:10px">
       <v-img 
        src="http://producciongama.com/CRM-GAMA-2020/imagenes/logo.png" 
        width="65" 
        class="shrink mr-2 "
        @click.stop="drawer = !drawer; mini = false" 
        transition="fab-transition"
        contain
        />
      <v-spacer></v-spacer>
      
      <v-toolbar-items @click="cerrar_sesion=true">
        <v-icon right>mdi-exit-to-app</v-icon>
      </v-toolbar-items>
     <!-- <v-toolbar-items text-right> 
        <v-btn text color="white" dark @click="BuscarPredeterminado"> 
          <v-icon large>attach_money</v-icon>
        </v-btn>
      </v-toolbar-items> -->
    </v-app-bar>

    <v-dialog v-model="cerrar_sesion" width="400px">
      <v-card >
        <v-card-title class="font-weight-black text-center text-h5" style="word-break:normal;">
         ¿Estás seguro de que quiere cerrar la sesión?
        </v-card-title>
        <v-divider class="mt-3"></v-divider>
        <v-card-actions>
          <v-btn color="morado"  dark @click="cerrar_sesion=false">no, Cancelar</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="celeste" dark text  @click="salir">SÍ, Cerrar Sesión</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-overlay v-if="blocked">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>

    <v-main>
      <v-card  height="100%" style="border-radius: 0px;">
        <v-main class="elevation-0 transparent pa-0" >
          <v-slide-y-transition mode="out-in" >
            <router-view  />
          </v-slide-y-transition>
        </v-main> 
      </v-card>
    </v-main>
   
  </v-app>
</template>

<script>
import  SelectMixin from '@/mixins/SelectMixin.js';
import store from '@/store'
import { mapGetters,mapActions } from 'vuex';

export default {
  mixins:[SelectMixin],
  components: {
  },
  data: () => ({
    syster_number: 1,
    urlSistemaPrincipal: 'http://producciongama.com/',

    cerrar_sesion:false,

    drawer: null,
    contador: 0 ,
    color: '',
    colores: ['#272727','#f4e200','#0096cb','#bf1c7f','#894975','#6f7170'], //NGRO,celeste,AZUL,ROSA,celeste,GRIS
     AppControl: [
        {
          admin: [ 
            // { text: 'Inicio'      ,icon: 'home'                       ,path: '/inicio'},
            { text: 'Compromisos' ,icon: 'chrome_reader_mode'         ,path: '/compromisos'},
            { text: 'Solicitudes' ,icon: 'ballot'                     ,path: '/solicitudes'},
            { text: 'Desarrollo de proyectos' ,icon: 'mdi-monitor-screenshot' ,path: '/desarrollo/proyectos'},
            ],
        },

        {
          icon: 'menu_book',
          title :' Administración',
          model: false,
          administracion: [ 
            // { text: 'Productos'            ,icon: 'print',path: '/productos'},
            { text: 'Productos por cliente',icon: 'mdi-printer-3d'    ,path: '/productos-por-cliente'},
            { text: 'Ordenes de Trabajo'   ,icon: 'mdi-text-box-check',path: '/ordenes-de-trabajo'},
            // { text: 'Monitor '             ,icon: 'mdi-monitor-eye'   ,path: '/monitor-master'},
          ],
        },

       

        {
          icon: 'account_box',
          title :' Catálogos',
          model: false,
          catalogos: [ 
            { text: 'Usuarios'          ,icon: 'person'       ,path: '/usuarios'},
            { text: 'Clientes'          ,icon: 'people'       ,path: '/clientes'},
            { text: 'Prospectos'  ,icon: 'person_pin_circle'  ,path: '/prospectos'},
            { text: 'Proveedores'       ,icon: 'how_to_reg'       ,path: '/proveedores'},
            // { text: 'Zonas'             ,icon: 'pin_drop'     ,path: '/zonas-subzonas'},
            // { text: 'Carteras'          ,icon: 'folder_shared',path: '/carteras'},
            // { text: 'Monedas'           ,icon: 'euro'         ,path: '/monedas'},
          ],
        },
      ],
      // DIALOGO
        dialogMoneda: false,

      // SELECTORES
        id_moneda  : 0,
				moneda     : [],
				monedas    : [],
        Moneda     : '',
        // SNACKBAR
        alerta: { activo: false, texto:'', color:'error', vertical:true },
        loading: true,
        blocked: true,

        mini: true,
  }),

  created(){
     this.overlay = true;
    if (typeof(Storage) !== "undefined") {
        // VERIFICO SI EXISTE UN USUARIO ACTIVO 
        if(localStorage.getItem("KeyLogger") != null){
          this.validaSession().then( response =>{ // VERIFICO SI LA SESSION DEL KEYLOGGER ESTA ACTIVA
            const payload = new Object();
                  payload.id       = response.id_usuario
                  payload.sistema  = this.syster_number

            this.ObtenerDatosUsuario(payload).then(response =>{
              this.alerta = { activo: true, texto: `HOLA DE NUEVO ${ response.nombre }`, color :'success', vertical:true  };
              this.blocked = false;  // DESACTIVO BLOCKEO
            }).catch( error=>{       // OBTENGO LA INFORMACION DEL USUARIO
              this.alerta = { activo: true, texto: error.bodyText, color:'error', vertical:true }
              window.location.href = this.urlSistemaPrincipal;
            });  
          }).catch( error =>{
            window.location.href = this.urlSistemaPrincipal;
          })
          if(this.$router.currentRoute.name != 'Inicio'){  // COMPARO LA RUTA EN LA QUE ME ENCUENTRO 
            this.$router.push({ name: 'Inicio' });         // SI ES DIFERENTE ENRUTO A PAGINA ARRANQUE
          }
        }else{ 
         window.location.href = this.urlSistemaPrincipal;
        }
    } else {
      window.location.href = this.urlSistemaPrincipal;
    }
    // this.colorBar();     // MANDO A LLAMAR LA FUNCION DEL BANNER DE COLORES
    // this.consultarMonedas()	// LLENAR SELECTOR DE MONEDAS
    // this.consultaMonedas()  // CONSULTAR MONEDAS VUEX
    // this.ActualizaMoneda()  // CONSULTO LA MONEDA PREDETERMINADA
  },

  computed:{
    // IMPORTANDO USO DE VUEX - ZONAS (GETTERS)
    // ...mapGetters('Monedas' ,['getMonedas']), 
    ...mapGetters('Login' ,['getLogeado','getdatosUsuario']), 

  },

  mounted(){
    setTimeout(()=>{ this.loading = false; }, 5000);
  },

  methods:{
    // ...mapActions('Monedas',['consultaMonedas','guardarMonedaPredeterminada','ActualizaMoneda']),
    ...mapActions('Login' ,['salirLogin','ObtenerDatosUsuario','validaSession']), 

    salir(){
      this.alerta = { activo: true, texto: `HASTA PRONTO ${ this.getdatosUsuario.nombre }`, color :'success' , vertical:true  };
      this.cerrar_sesion= false;
      this.salirLogin()
      this.$store.dispatch("salir")
    },

    // BuscarPredeterminado(){
    //   for(var i=0; i<this.getMonedas.length; i++){
    //     if(this.getMonedas[i].predeterminado === 1){
    //       this.id_moneda = this.getMonedas[i].id
    //       this.Moneda    = this.getMonedas[i].codigo
    //     }
    //   } 
    //   this.dialogMoneda = true; 
    // },

    // MonedaPredeterminada(){
    //   this.guardarMonedaPredeterminada(this.id_moneda).then(response =>{
    //     if(response){
    //       this.dialogMoneda = false; 
    //       this.alerta = { activo: true, texto: "MONEDA ACTUALIZADA CORRECTAMENTE", color:'error', vertical:true }
    //     }
    //   })
    // },

    // colorBar(){
    //   this.color = this.colores[this.contador]  
    //   this.contador++
    //   if(this.contador <= 5){
    //     setTimeout(this.colorBar,10000);
    //   }
    //   if(this.contador == 5){
    //     this.contador = 0
    //   }
    // },

    


  }
};
</script>

<style>
  
  /* .fondo{
    background: #ee9ca7;  
    background: -webkit-linear-gradient(to right, #f3b8bf, #ee9ca7);  
    background: linear-gradient(to right, hsla(353, 22%, 63%, 0.449), #ee9ca7),url('http://producciongama.com/CRM-GAMA-2020/imagenes/fondo2.jpg'); 
    background-attachment: fixed;
    background-size: cover;
    padding: 0px;
    margin: 0px;
    width: auto;
    height: 100%;
  } */

   /* width */
  ::-webkit-scrollbar {
    width: 5px;
    height : 5px;

  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: rgb(255, 255, 255);
    /* background: transparent; */
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #bf1c7f;
  }
 
</style>
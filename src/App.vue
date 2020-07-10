<template>
  <v-app id="inspire">
    <!-- <div :class="loading">Loading&#8230;</div> -->

    <v-navigation-drawer app v-model="drawer" temporary  >

        <v-list dense nav class="py-0">
          <v-list-item two-line>
            <v-list-item-avatar>
              <img src="person.png">
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title> {{ getdatosUsuario.nombre }} </v-list-item-title>
              <v-list-item-subtitle> {{ niveles[getdatosUsuario.nivel-1] }}</v-list-item-subtitle>
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
      <v-list dense>
        <template v-for="admin in AppControl">

          <v-list-group  v-if="admin.administracion" :key="admin.title" v-model="admin.model" :prepend-icon="admin.model ? admin.icon : admin['icon-alt']"
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
            >
              <v-list-item-content >
                <v-list-item-title >
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
               <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
            </v-list-item>
          </v-list-group>
        </template>
      </v-list>

      <!-- CATALOGOS -->
      <v-list dense>
        <template v-for="cat in AppControl">

          <v-list-group  v-if="cat.catalogos" :key="cat.title" v-model="cat.model" :prepend-icon="cat.model ? cat.icon : cat['icon-alt']"
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
            >
              
              <v-list-item-content >
                <v-list-item-title >
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
              
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
            </v-list-item>
          </v-list-group>
        </template>
      </v-list>

      <v-divider></v-divider>
  
      <v-card-actions>
        <v-btn color="red" outlined block small @click="cerrar_sesion=true">Cerrar Sesión
          <v-icon right>mdi-exit-to-app</v-icon>
        </v-btn>
      </v-card-actions>

    </v-navigation-drawer>

    <!-- <v-content class="ma-3"> -->
    <v-content >
      <router-view/>
    </v-content>

    <v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
      <v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
    </v-snackbar>

    <!-- MODAL PARA LA MONEDA PREDETERMINADA -->
    <div class="text-center">
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
    </div>

    <v-app-bar app color="rosa" dark class="elevation-0" v-ripple dense v-if="getLogeado">
       <img src="logo.png" height="40" @click.stop="drawer = !drawer">
      <v-spacer></v-spacer>

      <v-toolbar-items text-right> 
        <v-btn text color="white" dark @click="BuscarPredeterminado"> 
          <v-icon large>attach_money</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>

    <v-dialog v-model="cerrar_sesion" width="400px">
      <v-card color="grey darken-4" >
        <v-card-title class=" white--text font-weight-medium my-5">
         ¿Quiere cerrar la sesión?
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="celeste" outlined small @click="cerrar_sesion=false">Cancelar</v-btn>
          <v-btn color="rosa" dark small @click="salir">Cerrar Sesión</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
   
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
    cerrar_sesion:false,
    niveles:['Administrador','Supervisor','Vendedor','Chofer'],
    drawer: null,
    contador: 0 ,
    color: '',
    colores: ['#272727','#f4e200','#0096cb','#bf1c7f','#894975','#6f7170'], //NGRO,celeste,AZUL,ROSA,celeste,GRIS
     AppControl: [
        {
          admin: [ 
            { text: 'Inicio'      ,icon: 'home'               ,path: '/home'},
            { text: 'Compromisos' ,icon: 'chrome_reader_mode' ,path: '/compromisos'},
            { text: 'Pendientes'  ,icon: 'ballot'             ,path: '/Pendientes'},
            // { text: 'prueba'  ,icon: 'ballot'             ,path: '/prueba'},


            ],
        },

        {
          icon: 'menu_book',
          title :' Administración',
          model: false,
          administracion: [ 
            { text: 'Productos'         ,icon: 'print'        ,path: '/productos'},
            { text: 'Analisis de Fases' ,icon: 'assessment'        ,path: '/analisis-fases'},

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
            { text: 'Zonas'             ,icon: 'pin_drop'     ,path: '/zonas-subzonas'},
            { text: 'Carteras'          ,icon: 'folder_shared',path: '/carteras'},
            { text: 'Monedas'           ,icon: 'euro'         ,path: '/monedas'},
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
        snackbar: false,
				text		: '',
        color		: 'green',
        loading: true,
  }),

  created(){
    // this.colorBar();     // MANDO A LLAMAR LA FUNCION DEL BANNER DE COLORES
    this.consultarMonedas()	// LLENAR SELECTOR DE MONEDAS
    this.consultaMonedas()  // CONSULTAR MONEDAS VUEX
    this.ActualizaMoneda()  // CONSULTO LA MONEDA PREDETERMINADA
  },

  computed:{
    // IMPORTANDO USO DE VUEX - ZONAS (GETTERS)
    ...mapGetters('Monedas' ,['getMonedas']), 
    ...mapGetters('Login' ,['getLogeado','getdatosUsuario']), 
  },

  mounted(){
    setTimeout(()=>{ this.loading = false; }, 5000);
  },

  methods:{
    ...mapActions('Monedas',['consultaMonedas','guardarMonedaPredeterminada','ActualizaMoneda']),
    ...mapActions('Login' ,['salirLogin']), 

    salir(){
      this.cerrar_sesion= false;
      this.salirLogin()
      this.$store.dispatch("salir")
    },

    BuscarPredeterminado(){
      for(var i=0; i<this.getMonedas.length; i++){
        if(this.getMonedas[i].predeterminado === 1){
          this.id_moneda = this.getMonedas[i].id
          this.Moneda    = this.getMonedas[i].codigo
        }
      } 
      this.dialogMoneda = true; 
    },

    MonedaPredeterminada(){
      this.guardarMonedaPredeterminada(this.id_moneda).then(response =>{
        if(response){
          this.dialogMoneda = false; 
          this.snackbar = true ; this.text = "MONEDA ACTUALIZADA CORRECTAMENTE";
        }
      })
    },

    colorBar(){
      this.color = this.colores[this.contador]  
      this.contador++
      if(this.contador <= 5){
        setTimeout(this.colorBar,10000);
      }
      if(this.contador == 5){
        this.contador = 0
      }
    },


  }
};
</script>

<style scoped>
/* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>

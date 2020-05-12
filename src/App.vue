<template>
  <v-app id="inspire">
    <v-navigation-drawer app v-model="drawer" temporary  >

      <v-list dense nav class="py-0">
        <v-list-item two-line>
          <v-list-item-avatar>
            <img src="person.png">
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title> Edgar Tamez </v-list-item-title>
            <v-list-item-subtitle>Administrador</v-list-item-subtitle>
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
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content >
                <v-list-item-title >
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
                {{ child.acceso }}

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
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content >
                <v-list-item-title >
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
                {{ child.acceso }}

            </v-list-item>
          </v-list-group>
        </template>
      </v-list>

      <v-divider></v-divider>
      <v-list-item>
        <v-list-item-action>
          <v-icon>mdi-exit-to-app</v-icon>
        </v-list-item-action>
        <v-list-item-content >
          <v-list-item-title >
            <h5>Salir </h5>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

    </v-navigation-drawer>

    <v-content class="ma-3">
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

    <v-app-bar app color="rosa" dark class="elevation-0" v-ripple >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" ></v-app-bar-nav-icon>
      <v-spacer></v-spacer>

      <v-toolbar-items text-right> 
        <v-btn text color="white" dark @click="BuscarPredeterminado"> 
          <v-icon large>attach_money</v-icon>
        </v-btn>
      </v-toolbar-items>
      <img src="@/assets/logoCRM.png" width="50px">
    </v-app-bar>
   
  </v-app>
</template>

<script>
import  SelectMixin from '@/mixins/SelectMixin.js';
import { mapGetters,mapActions } from 'vuex';

export default {
  mixins:[SelectMixin],
  components: {
  },
  data: () => ({
    
    drawer: null,
    contador: 0 ,
    color: '',
    colores: ['#272727','#f4e200','#0096cb','#bf1c7f','#894975','#6f7170'], //NGRO,celeste,AZUL,ROSA,celeste,GRIS
     AppControl: [
        {
          admin: [ 
            { text: 'Inicio'      ,icon: 'home'               ,path: '/'},
            { text: 'Compromisos' ,icon: 'chrome_reader_mode' ,path: '/compromisos'},
            { text: 'Pendientes'  ,icon: 'ballot'             ,path: '/Pendientes'},
            // { text: 'Pruebas'  ,icon: 'ballot'             ,path: '/calendario'},

            ],
        },

        {
          icon: 'menu_book',
          title :' Administración',
          model: false,
          administracion: [ 
            { text: 'Productos'         ,icon: 'print'        ,path: '/productos'},
          ],
        },

        {
          icon: 'account_box',
          title :' Catálogos',
          model: false,
          catalogos: [ 
            { text: 'Usuarios'          ,icon: 'person'       ,path: '/usuarios'},
            { text: 'Clientes'          ,icon: 'people'       ,path: '/clientes'},
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

  },

  methods:{
    ...mapActions('Monedas',['consultaMonedas','guardarMonedaPredeterminada','ActualizaMoneda']),
    
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



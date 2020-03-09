<template>
  <v-app id="inspire">
    <v-navigation-drawer app v-model="drawer"  temporary>

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
            color= "cyan darken-4"
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

       <v-list dense>
        <template v-for="cat in AppControl">

          <v-list-group  v-if="cat.catalogos" :key="cat.title" v-model="cat.model" :prepend-icon="cat.model ? cat.icon : cat['icon-alt']"
            color= "cyan darken-4"
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
          <v-list-item-title @click="">
            <h5>Salir </h5>
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

    </v-navigation-drawer>

    <v-content class="ma-3">
      <router-view/>
    </v-content>

    <v-app-bar app color="cyan darken-4" dark class="elevation-0" v-ripple >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" ></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <img src="logo.png" width="50px">
      <!-- <v-toolbar-items text-right> -->
       <!-- <v-btn text class="hidden-sm-and-down" dark :to="{name: 'myperfil'}">{{ getdatosUsuario.Nomuser }}</v-btn> -->
       <!-- <v-btn text class="hidden-md-and-up"  dark :to="{name: 'myperfil'}"> <v-icon >person</v-icon></v-btn> -->
     <!-- </v-toolbar-items> -->
    </v-app-bar>

   
  </v-app>
</template>

<script>

export default {
  components: {
  },
  data: () => ({
    drawer: null,
     AppControl: [
        
        {
          admin: [ 
            { text: 'Inicio'      ,icon: 'home'               ,path: '/'},
            { text: 'Compromisos' ,icon: 'chrome_reader_mode' ,path: '/compromisos'},
            { text: 'Pendientes'  ,icon: 'ballot'             ,path: '/Pendientes'},
            ],
        },

        {
          icon: 'account_box',
          title :' Catálogos',
          model: false,
          catalogos: [ 
            { text: 'Usuarios'          ,icon: 'person'       ,path: '/usuarios'},
            { text: 'Clientes'          ,icon: 'people'       ,path: '/clientes'},
            { text: 'Productos'         ,icon: 'print'        ,path: '/productos'},
            { text: 'Precios'           ,icon: 'attach_money' ,path: '/precios'},
            { text: 'Zonas'             ,icon: 'pin_drop'     ,path: '/zonas-subzonas'},
            { text: 'Carteras'          ,icon: 'folder_shared',path: '/carteras'},
            { text: 'Monedas'           ,icon: 'euro'         ,path: '/monedas'},
            { text: 'Costos Indirectos' ,icon: 'monetization_on',path: '/costos-indirectos'},
            { text: 'Manos de Obra'     ,icon: 'pan_tool'     ,path: '/manos-de-obra'},
          ],
        },
      ]
  }),
};
</script>



<template>
  <v-content class="pa-0">
    <v-row no-gutters >
      <v-col cols="12">

        <v-btn color="rosa" style="display: none" class="ir-arriba white--text" fab fixed bottom right>
          <v-icon top>keyboard_arrow_up</v-icon>
        </v-btn>

        <v-row justify="center">
          <v-col cols="9" sm="10" md="7" lg="6" xl="4">
            <v-text-field
                label="Buscar Producto"
                dense
                outlined
                hide-details
                v-model="search"
                append-icon="search"
                color="rosa"
            ></v-text-field>
          </v-col>
          <v-col cols="1" >
             <v-btn class="gris" icon dark @click="consultaProductos" ><v-icon>refresh</v-icon> </v-btn>
          </v-col>
        </v-row>

        <v-row justify="space-around" >
          <v-col cols="10" class="text-center" v-if="Loading" >  <!-- PROGRES -->
            <v-progress-linear :size="100" :width="7" color="celeste" indeterminate ></v-progress-linear>
          </v-col>
          <v-col cols="12" sm="9" v-if="!filterArticulos.length && !Loading">
           <v-alert color="error" dark icon="sentiment_very_dissatisfied" border="right" prominent >
              No hay articulos o proveedores con la descripción solicitada.
            </v-alert>
        </v-col>	
        </v-row>

        <v-row>
          <v-col cols="12" sm="6" md="4" lg="3"  v-for="(item , i) in filterArticulos" :key="i" v-if="item">
            <v-hover v-slot:default="{ hover }" >
              <v-card class="mx-auto" max-width="350" v-ripple height="100%">
                
                <v-img aspect-ratio="1" contain :src="item.foto"  max-height="250px" min-height="250px" v-if="item.foto != null">
                  <v-expand-transition>
                      <div
                        v-if="hover"
                        class="d-flex transition-fast-in-fast-out celeste v-card--reveal display-3 white--text"
                        style="height: 100%;"
                      >
                        ${{ item.precio == 0.00 ? 'Indefinido': item.precio + ' '+ item.codmoneda }}
                      </div>
                    </v-expand-transition>
                </v-img>

                <v-img aspect-ratio="1" contain src="@/assets/sinfoto2.jpg"  max-height="250px" min-height="250px" v-else>
                  <v-expand-transition>
                      <div
                        v-if="hover"
                        class="d-flex transition-fast-in-fast-out celeste v-card--reveal display-3 white--text"
                        style="height: 100%;"
                      >
                        ${{ item.precio == 0.00 ? ' Indefinido': item.precio + ' '+ item.codmoneda }}
                      </div>
                    </v-expand-transition>
                </v-img>

                <v-card-text > <strong> {{ item.nombre }}</strong> </v-card-text>
                <v-divider></v-divider>
                <v-card-text align="left"> 
                    <tr> <th > Proveedor: {{ item.nomprov }}</th> </tr>
                    <tr> <th > Codigo: {{ item.codigo }}    </th> </tr>
                    <tr> <th > Unidad: {{ item.nomunidad }}  </th> </tr>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-text>
                  {{ item.descripcion ? item.descripcion: 'No hay descripción.'}}
                </v-card-text>
              </v-card>
              
            </v-hover>
          </v-col>
        </v-row>
    </v-col>
    </v-row>
  </v-content>
</template>


<script>
  import $ from 'jquery'
  import {mapGetters, mapActions} from 'vuex'
export default {
  components: {
  },

  data: () => ({
      show: false,
      articulos: [],
      search: '',
      skeletons:['1','2','3','4']
  }),

  methods:{
    ...mapActions('Productos',['consultaProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
	},

  computed:{
    ...mapGetters('Productos',['Loading','getProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)

    filterArticulos: function(){
      return this.getProductos.filter((art)=>{
        var cod  = art.codigo                  // BUSCAR POR CODIGO
        var nom  = art.nombre.toLowerCase();  // BUSCAR POR NOMBRE
        var prov = art.nomprov.toLowerCase(); // BUSCAR POR PROVEDOR
        
        if(cod.match(this.search)){ // SI ENCUENTRO EL CODIGO LO RETORNO
          return cod.match(this.search)
        }else if(nom.match(this.search.toLowerCase())){ // SI NO - RETONO POR NOMBRE
          return nom.match(this.search.toLowerCase()) // SI NO - RETORNO POR PROVEEDOR
        }else{
          return prov.match(this.search.toLowerCase())
        }
      })
    },

  },

  filters:{
    toUppercase(value){
      return value.toUpperCase();
    }
  },

  created(){
    this.consultaProductos()// CONSULTAR PRODUCTOS A VUEX
  },

  mounted(){
    // Jquey para activar la animacion del boton hacia arriba
    $(document).ready(function(){

      $('.ir-arriba').click(function(){
        $('body, html').animate({
          scrollTop: '0px'
        }, 300);
      });
      
      $(window).scroll(function(){
        if( $(this).scrollTop() > 0 ){
          $('.ir-arriba').slideDown(300);
        } else {
          $('.ir-arriba').slideUp(300);
        }
      });
      
    });

  },


}
</script>
<style>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: .5;
  position: absolute;
  width: 100%;
}
</style>

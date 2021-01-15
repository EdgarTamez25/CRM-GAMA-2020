<template>
  <v-content class="pa-0 ma-1" fluid >
    <v-card flat >
      
    <v-row no-gutters justify="center">
      <v-col cols="12" sm="12" md="9" xl="10">
        
        <video  controls width="100%" autoplay muted>
          <source src="http://producciongama.com:8080/CRM-GAMA-2020/VIDEOS/gama_etiquetas.mp4" type="video/mp4">
        </video>
        <!-- <v-btn color="rosa" style="display: none" class="ir-arriba white--text mt-12" small fab fixed bottom top right >
          <v-icon top>keyboard_arrow_up</v-icon>
        </v-btn>
        <v-row justify="space-around" >
          <v-col cols="10" class="text-center" v-if="Loading" >  
            <v-progress-linear :size="100" :width="7" color="celeste" indeterminate ></v-progress-linear>
          </v-col>
          <v-col cols="12" sm="9" v-if="!filterArticulos.length && !Loading">
           <v-alert color="error" dark icon="sentiment_very_dissatisfied" border="right" prominent >
              No hay articulos o proveedores con la descripción solicitada.
            </v-alert>
        </v-col>	
        </v-row> -->

        <!-- <v-row v-if="!Loading" dense> -->
          <!-- <v-col cols="12" sm="6" md="4" lg="4" xl="3" v-for="(item , i) in filterArticulos" :key="i" >
              <v-card height="100%" class="mx-auto elevation-10" v-ripple>

                <v-card-title class="headline" style="word-break:normal;" >{{ item.nombre }}</v-card-title>
                <v-divider></v-divider>

                <v-simple-table dense>
                  <template v-slot:default>
                    <tbody>
                      <tr>
                        <td class="font-weight-black">CODIGO</td>
                        <td>{{ item.codigo }}</td>
                      </tr>
                      <tr>
                        <td class="font-weight-black"> LINEA</td>
                        <td>{{ item.nomlin }}</td>
                      </tr>
                       <tr>
                        <td class="font-weight-black"> UNIDAD</td>
                        <td>{{ item.nomunidad ? item.nomunidad:'No se ha asignado unidad' }}</td>
                      </tr>
                      <tr>
                        <td class="font-weight-black"> PROVEEDOR</td>
                        <td>{{ item.nomprov }}</td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <v-divider></v-divider>
                <v-card-actions v-if="getdatosUsuario.nivel != 8 ">
                  <v-spacer></v-spacer>
                    <span class="font-weight-black celeste--text" > 
                      $ {{ item.precio == 0.00 ? 'Indefinido': item.precio + ' '+ item.codmoneda }} 
                    </span>
                </v-card-actions>
                <v-divider></v-divider>

                <v-card-subtitle>
                  {{ item.descripcion ? item.descripcion: 'Sin descripción.'}}
                </v-card-subtitle>

              </v-card>
          </v-col> -->
          <!-- <v-col cols="12" sm="6" md="4" lg="3"  v-for="(item , i) in filterArticulos" :key="i" v-if="item">
            <v-hover v-slot:default="{ hover }" >
              <v-card class="mx-auto elevation-10" max-width="350" v-ripple height="100%" >
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

                <v-img aspect-ratio="1" contain src="sinfoto2.jpg"  max-height="250px" min-height="250px" v-else>
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

                <v-card-text > <strong > {{ item.nombre }}</strong> </v-card-text>
                <v-divider></v-divider>
                <v-card-text align="left"> 
                    <tr > <th > Proveedor: {{ item.nomprov }}</th> </tr>
                    <tr > <th > Codigo: {{ item.codigo }}    </th> </tr>
                    <tr > <th > Unidad: {{ item.nomunidad }}  </th> </tr>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-text>
                  {{ item.descripcion ? item.descripcion: 'No hay descripción.'}}
                </v-card-text>
              </v-card>
              
            </v-hover>
          </v-col> -->
        <!-- </v-row> -->
      <!-- </v-col> -->
     <!-- <v-col cols="12">
        <v-footer small padless top fixed class="pb-2 pt-2 footer">
          <v-row justify="center" class="mx-1">

            <v-col cols="8" sm="7" md="4" lg="3" xl="2">
              <v-autocomplete
                v-model="linea"
                :items="lineas"
                item-text="nombre"
                item-value="id"
                label="Lineas de producción"
                placeholder="Lineas de producción"
                return-object
                color="white"
                dark
                outlined
                hide-details
                dense
              ></v-autocomplete>
            </v-col>
            <v-col cols="4" md="2" >
              <v-btn class="rosa ma-1"  icon dark @click="init()" ><v-icon>search</v-icon> </v-btn>
            <v-btn class="rosa ma-1"  icon dark @click="init()" ><v-icon>refresh</v-icon> </v-btn>
          </v-col>

            <v-col cols="12" sm="11" md="6" xl="5">
            <v-text-field
                label="Buscar Producto"
                dense
                outlined
                hide-details
                v-model="search"
                append-icon="search"
                dark
                color="white"
            ></v-text-field>
          </v-col>
        
          </v-row>
        </v-footer>
      </v-col> -->

      <!-- <v-col cols="12" align="center" class="mt-5" v-if="masProductos === true && search==='' && !Loading ">
        <span class="font-weight-bold"> CARGAR MAS PRODUCTOS </span><br>
        <v-btn color="rosa" outlined dark small fab @click="VerMasProductos()"> 
          <v-icon>expand_more</v-icon>
        </v-btn>
    
    
    
      </v-col>   
      <v-col cols="12">
        <v-footer color="white" height="180px"></v-footer>
      </v-col> -->
      </v-col>
    </v-row>
    </v-card>
  </v-content>
</template>


<script>
  import $ from 'jquery'
  import {mapGetters, mapActions} from 'vuex'
  import  SelectMixin from '@/mixins/SelectMixin.js';
  export default {
    mixins:[SelectMixin],
    components: {
    },

    data: () => ({
        show: false,
        articulos: [],
        search: '',
        linea:{  id:0 , nombre:'TODOS'},
        lineas:[ {id:0, nombre:'TODOS'}],
    }), 

    methods:{
      ...mapActions('Productos',['consultaProductos','consultaProductosxId','VerMasProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
      
      init(){
        this.linea.id === 0 ? this.consultaProductos(): this.consultaProductosxId(this.linea.id) 
      }
    },

    computed:{
      ...mapGetters('Productos',['Loading','getProductos','masProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('Login' ,['getdatosUsuario']), 


      pantalla () {
          switch (this.$vuetify.breakpoint.name) {
            case 'xs': return 'xs'
            case 'sm': return 'sm'
            case 'md': return 'md'
            case 'lg': return 'lg'
            case 'xl': return 'xl'
          }
        },

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
      // this.consultarLineas();
      // this.init();
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

  .footer{
    /* background: #ee9ca7;  
    background: -webkit-linear-gradient(to right, hsl(353, 83%, 82%), #ee9ca7);  
    background: linear-gradient(to right, hsla(353, 100%, 93%, 0.891), #ee9ca7);  */

    background: #1b7890;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #59aec1, #2193b0);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #4e9aab, #2193b0); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

  }

</style>

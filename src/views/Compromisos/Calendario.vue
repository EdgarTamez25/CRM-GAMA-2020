<template>
  <v-main class="pa-0 ma-3">
    <v-row class="fill-height">
      <v-col >

        <v-row class="py-0">
          <v-col cols="12" sm="8" class="font-weight-black text-h6 spacer-around">
              CALENDARIO DE COMPROMISOS POR VENDEDOR
          </v-col>
          <v-col cols="12" sm="4">
              <v-autocomplete
              v-model="vendedor" :items="vendedores" item-text="nombre" item-value="id" label="Vendedores" 
              dense filled hide-details return-object color="celeste" append-icon="folder_shared"
            ></v-autocomplete>
          </v-col>
        </v-row>

        <v-divider class="mt-1" ></v-divider>
        <v-sheet height="60">
          <!-- CONTROL DE MES Y AÑO **ADELANTE**ATRAS** -->
          <v-toolbar flat  >
            <v-menu
              bottom
              right
            >
              <template v-slot:activator="{ on, attrs }">
                <v-btn outlined color="grey darken-2" v-bind="attrs" v-on="on">
                  <span>{{ typeToLabel[type] }}</span>
                  <v-icon right>  mdi-menu-down</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item @click="type = 'day'">
                  <v-list-item-title>Día</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = 'month'">
                  <v-list-item-title>Mes</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
            
            <v-spacer></v-spacer>
            <v-btn text small color="rosa" dark class="ma-1" @click="prev"> 
              <v-icon >mdi-chevron-left</v-icon>
            </v-btn>
            <v-toolbar-title class="ma-1 text-h6 font-weight-black celeste--text" v-if="$refs.calendar">
              {{ ($refs.calendar.title).toUpperCase()}}
            </v-toolbar-title>  
            <v-btn text small color="rosa" dark class="ma-1" @click="next"> 
              <v-icon >mdi-chevron-right</v-icon>
            </v-btn>
          </v-toolbar>
        </v-sheet>
        <!--  VISTA PRINCIPAL DEL CALENDARIO -->
        <v-sheet :height="tamanioPantalla" elevation="12">
          <v-calendar
            ref="calendar"
            v-model="focus"
            color="primary"
            :events="events"
            :event-color="getEventColor"
            :type="type"
            @click:event="showEvent"
            @click:date="viewDay"
            @click:more="viewDay" 
            @change="updateRange"
          ></v-calendar>
          
          <!-- MENU DESPLEGABLE DE INFORMACION -->
          <v-menu
            v-model="selectedOpen" 
            :close-on-content-click="false"
            :activator="selectedElement"
            offset-y
          >
            <v-card color="grey lighten-4" min-y width="100%" flat >
              <v-toolbar :color="selectedEvent.color" dark >
                <v-toolbar-title >
                  {{ selectedEvent.name }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon  @click="selectedOpen = false">
                  <v-icon>mdi-close</v-icon>
                </v-btn>
              </v-toolbar>
              <v-card-text>
                <div 
                  :class="`${selectedEvent.cumplimiento?'success':'error'}--text 
                          font-weight-black
                          subtitle-1`" 
                  align="center"
                > 
                  {{ selectedEvent.cumplimiento? 'CUMPLIDO':'PENDIENTE' }} 
                </div>
                <ul>
                  <li> <span class="font-weight-black subtitle-2"> CLIENTE:</span> 
                    <span :class="`${selectedEvent.color}--text`"> {{ selectedEvent.cliente  }} </span> 
                  </li>
                  <li> <span class="font-weight-black subtitle-2"> HORA DE INICIO: </span> 
                    <span :class="`${selectedEvent.color}--text`"  > 
                      {{ selectedEvent.hora1 >='12:00'? selectedEvent.hora1 +' '+'p.m.': selectedEvent.hora1+ ' '+'a.m.' }}
                    </span> 
                  </li>
                  <li> <span class="font-weight-black subtitle-2"> HORA FIN:</span> 
                    <span :class="`${selectedEvent.color}--text`"  > 
                      {{ selectedEvent.hora2 >='12:00'? selectedEvent.hora2 +' '+'p.m.': selectedEvent.hora2+ ' '+'a.m.' }}
                    </span> 
                  </li> 
                  <li> <span class="font-weight-black subtitle-2"> COMENTARIOS:</span> 
                    <p :class="`${selectedEvent.color}--text`"> {{ selectedEvent.obs}} </p> 
                  </li>
                  
                  <li> <span class="font-weight-black subtitle-2" v-if="selectedEvent.obs_usuario"> RESULTADOS:</span> 
                    <p :class="`${selectedEvent.color}--text`"> {{ selectedEvent.obs_usuario}} </p> 
                  </li>
                  
                </ul>
              </v-card-text>
            </v-card>
            
          </v-menu>
        </v-sheet>
      </v-col>
    </v-row>
  </v-main>
</template>

<script>
  import  metodos from '@/mixins/metodos.js';
	import {mapGetters, mapActions} from 'vuex';

  export default {
		mixins:[metodos],

    data: () => ({
      sucursal: { id: null, nombre:''},
      sucursales:[],
      focus: '',
      type: 'month',
      typeToLabel: {
        month: 'Mes',
        day: 'Día',
      },
      fecha1Estatica: {},
      fecha2Estatica: {},
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [],
      colors: ['rosa','pink','gris', 'morado','purple', 'celeste','blue'],
      
      // categorias: [], 
      vendedores: [],
      vendedor: { id:null, nombre:''},
    }),

    async created(){
      if(!this.getLogeado){
        this.AuthenticarTemporal();
      }
      this.vendedores = await this.consultar_Vendedores();
			// this.categorias = await this.consultar_Categorias();
      
    },
    computed:{
      ...mapGetters('Login'    ,['getdatosUsuario','getLogeado']),       // IMPORTANDO USO DE VUEX  (GETTERS)

      tamanioPantalla () {
				switch (this.$vuetify.breakpoint.name) {
					case 'xs':
						return this.$vuetify.breakpoint.height -260
            
					break;
					case 'sm': 
						return this.$vuetify.breakpoint.height -260
            
					break;
					case 'md':
						return this.$vuetify.breakpoint.height -260
            
					break;
					case 'lg':
						return this.$vuetify.breakpoint.height -260
            
					break;
					case 'xl':
						return this.$vuetify.breakpoint.height -260
            
					break;
				}
			},
    },

    watch:{
      vendedor(){ 
        this.consulta_calendario_compromisos(this.fecha1Estatica.date, this.fecha2Estatica.date);
      }
		},
      
    mounted () { this.$refs.calendar.checkChange()  },

    methods: {
      ...mapActions('Login',['AuthenticarTemporal']),

      viewDay ({ date }) {
          this.focus = date
          this.type = 'day'
        // console.log('vuelvo a formar viewDay', date)
      },
      getEventColor (event) {
        return event.color
      },
      // setToday () {
      //   this.focus = ''
      // },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      //ASIGNA EL OBJETO A MOSTRAR EN EL MENU ALTERNO ****
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          // DEFINE EL EVENTO SELECCIONADO
          this.selectedEvent = event;
          // SELECCIONAR EL ELEMENTO SELECCIONADO
          this.selectedElement = nativeEvent.target;
          //TIEMPO QUE TARDA EN ABRIL EL MENÚ
          setTimeout(() => { this.selectedOpen = true  }, 10);
        }

        if (this.selectedOpen) {
          this.selectedOpen = false; 
          setTimeout(open, 10)
        } else {
          open()
        }
        nativeEvent.stopPropagation()
      },
      updateRange ({ start, end }) {
        if(this.type === 'day'){ return }  // SI SE VE EN MODO DÍA NO ACTUALIZO INFORMACION
        this.fecha1Estatica  = start; this.fecha2Estatica = end;
        // *******************************************
        // *    START.DATE = PRIMER DIA DEL MES;     *
        // *    END.DATE   = ULTIMO DIA DEL MES;     * 
        // *******************************************
        this.consulta_calendario_compromisos(start.date, end.date)
      },

      consulta_calendario_compromisos(start, end){
        let events = []; 
        const min = new Date(`${start}T00:00:00`) // PRIMERO DIA DEL MES 
        const max = new Date(`${end}T23:59:59`) // ULTIMO DIA DEL MES 
        const days = (max.getTime() - min.getTime()) / 86400000 // CANTIDAD DE DIAS QUE TIENE EL MES
        // GENERO CONSULTA DE SALA RESERVADA
        const payload = { 
          id_vendedor: this.vendedor.id,
          fecha1: min, 
          fecha2: max
        }
        this.$http.post('calendario.compromisos.vendedor', payload).then(response =>{
          // console.log('response calendario 1', response.body);
          for (const i in response.body) {
            events.push({
              name: response.body[i].categoria,
              cliente: response.body[i].nomcli,
              start: response.body[i].fecha + " " + response.body[i].hora, // INICIO DEL COMPROMISO
              end: response.body[i].fecha_cierre   + " " + response.body[i].hora_cierre,// FIN DEL COMPROMISO
              color: this.colors[this.rnd(0, this.colors.length - 1)], // COLOR ASIGNADO AL EVENTO
              hora1: response.body[i].hora,
              hora2:response.body[i].hora_cierre,
              obs:response.body[i].obs,
              obs_usuario:response.body[i].obs_usuario,
              cumplimiento: response.body[i].cumplimiento,
              tipo: response.body[i].tipo == 1? 'CLIENTE':'PROSPECTO',
              timed: !this.rnd(0, 3) === 0,
            });
          }
          this.events =  events;
        }).catch(error => {
          console.log('error', error)
        })
      },

      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
  }
</script>
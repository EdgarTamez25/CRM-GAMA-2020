<template>
  <v-container fluid>
    <v-row >
      <v-col cols="12" sm="10" md="6">
        <v-card outlined>
          <v-list dense>

            <v-list-item>
              <v-list-item-content>ORDEN DE TRABAJO:</v-list-item-content>
              <v-list-item-content class="align-left">  {{ detalle }}  </v-list-item-content>
            </v-list-item>
            <!-- <v-divider></v-divider> -->
            <v-list-item>
              <v-list-item-content>CLIENTE:</v-list-item-content>
              <v-list-item-content class="align-left"> PROVEDORA DE LIMPIEZA S.A DE C.V. </v-list-item-content>
            </v-list-item>
            <!-- <!-- <v-divider></v-divider> --> -->
            <v-list-item>
              <v-list-item-content>FECHA:</v-list-item-content>
              <v-list-item-content class="align-left"> 24 de diciembre del 2020 </v-list-item-content>
            </v-list-item>
            <!-- <v-divider></v-divider> -->
            <v-list-item>
              <v-list-item-content>HORA:</v-list-item-content>
              <v-list-item-content class="align-left"> 12:26 p.m. </v-list-item-content>
            </v-list-item>

          </v-list>
        </v-card>
        
      </v-col>
    </v-row>
     
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      titulo: 'DETALLE ORDEN DE TRABAJO',
      detalle: {},
      itemsPerPage: 4,
      items: [
        {
          name: 'DETALLE ORDEN DE TRABAJO',
          id: 159,
          nomcli: 'PROVEDORA DE LIMPIEZA S.A DE C.V.',
          fecha : '24 de diciembre del 2020',
          hora: '12:26 p.m.',
        },
       
      ],
    }),

     created(){
      if(!this.$route.params.detalle){  window.history.go(-1); } // SI NO OBTENGO LA INFORMACION RETORNO VISTA.
      this.detalle = this.$route.params.detalle;
      // this.init()
    },

  }
</script>
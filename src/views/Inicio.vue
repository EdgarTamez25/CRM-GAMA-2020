<template>
  <v-container fluid class="pa-5">
     <v-row class="py-0">
      <v-carousel cycle :height="tamanioPantalla" hide-delimiter-background  show-arrows-on-hover  >
          <template v-slot:prev="{ on, attrs }">
            <v-btn icon large color="white" v-bind="attrs" v-on="on" >  <v-icon> mdi-chevron-left </v-icon> </v-btn>  
            </template>
          <template v-slot:next="{ on, attrs }">
            <v-btn icon large color="white" v-bind="attrs" v-on="on"> <v-icon> mdi-chevron-right </v-icon> </v-btn>
          </template>
          <v-carousel-item  v-for="(item, i) in anuncios" :key="i" :src="item.foto" >
          </v-carousel-item>
        </v-carousel>
    </v-row>
  </v-container>
</template>

<script>
  export default {
    components: {},
    data () {
      return {
        anuncios:[{
          id: 1, 
          nombre: 'Desarrollo Digital',
          foto: require('@/assets/gama1.png')
        },
        {
          id: 2, 
          nombre: 'Collage',
          foto: require('@/assets/gama2.png')
        },
        // {
        //   id: 3, 
        //   nombre: 'Facebook',
        //   foto: require('@/assets/gama3.jpg')
        // },
      ],
     
      }
    },

    created(){
      console.log('TAMAÑO', this.$vuetify.breakpoint.width)
      console.log('TAMAÑO', this.$vuetify.breakpoint.width)

    },

    computed:{
      tamanioPantalla () {
        switch (this.$vuetify.breakpoint.name) {
          case 'xs':
            return this.$vuetify.breakpoint.height -105
          break;
          case 'sm': 
            return this.$vuetify.breakpoint.height -105
          break;
          case 'md':
            return this.$vuetify.breakpoint.height -105
          break;
          case 'lg':
            return this.$vuetify.breakpoint.height -105
          break;
          case 'xl':
            return this.$vuetify.breakpoint.height -105
          break;
        }
      },
    },
  }
</script>


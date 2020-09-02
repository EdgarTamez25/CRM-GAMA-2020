<template>
  <v-container fluid class="fondo">
    <v-row justify="space-around" align="center" class="mx-2 ">
    
      <v-snackbar v-model="snackbar" :timeout="8000" top color="orange" dark  > {{text}}
        <v-btn color="white" text @click="snackbar = false"> Cerrar </v-btn>
      </v-snackbar>

      <v-col cols="12"  sm="7" md="6" lg="4" xl="3" style="margin-top: 125px">
        <v-card class="elevation-20 pa-2" id="contenedor" v-ripple>
          <v-card-text class="mt-2 text-center" >
            <img
              :src="`http://producciongama.com:8080/CRM-GAMA-2020/imagenes/logo2020.png`"
              :lazy-src="`https://picsum.photos/10/6?image=${1 * 5 + 10}`"
              aspect-ratio="1.5"
              class=" pa-2 mb-5"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              width="50%" 
              transparent
              id="logo"
            >
              <template v-slot:placeholder>
                <v-row
                  class="fill-height ma-0"
                  align="center"
                  justify="center"
                >
                  <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-row>
              </template>
            </img>
           

            <v-form>
              <v-text-field
                autofocus
                v-model="correo" 
                prepend-icon="email" 
                label="Correo" 
                required
                type="text"
                outlined
                dense 
                color="white"
                dark
                >
              </v-text-field>

              <v-text-field
                v-model="contrasenia"
                prepend-icon="lock"
                :append-icon="show1 ? 'visibility' : 'visibility_off'"
                :rules="[rules.required, rules.min]"
                :type="show1 ? 'text' : 'password'"
                label="contraseña"
                hint="At least 8 characters"
                counter
                @click:append="show1 = !show1"
                @keyup.enter="ingresar"
                outlined
                dense
                hide-details
                color="celeste"
                clearable
                dark
              ></v-text-field>

              <v-col xs12>
                <v-card v-if="error" color="red lighten-1" class=" px-2 py-2">
                  <div class="white--text">
                    {{ error }}
                  </div>
                </v-card>
              </v-col>

            </v-form>
          </v-card-text>
            
              <!-- BOTONES -->
          <v-card-actions class="mx-3">
            <!-- <v-spacer></v-spacer> -->
            <!-- <v-btn  color="white" outlined small dark :to="{name:'registro'}" >Registrarse</v-btn> -->
            <v-btn :loading="iniciar"
                   :disabled="iniciar" 
                   color="primary" 
                   block 
                   rounded 
                   dark 
                   @click="ingresar" 
                   class="elevation-5">
              Iniciar Sesión
            </v-btn>
          </v-card-actions>
          
          <!-- <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="terciario" text dark x-small :to="{name: 'olvidacontra'}">Olvide mi contraseña.</v-btn>
          </v-card-actions> -->
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import router from '@/router'
import {mapActions , mapGetters} from 'vuex'
  export default {
    data(){
      return{
        contrasenia: '',
        correo:'',
        iniciar: false,
        snackbar: false,
        y: 'top',
        x: null,
        mode: '',
        timeout: 8000,
        text: '',

        show1: false,
        error: '',


        rules: {
          required: value => !!value || 'Requerido.',
          min: v => v.length >= 1 || 'Minimo 1 caracteres',
          emailMatch: () => ('El correo y/o la contraseña no son correctos')
        },

        NombreAsig: '',
        Nomuser: '',
      }
    },

    created(){
      this.iniciar = false,
      this.salirLogin();

      // if(typeof(Storage) !== "undefined"){
      //   console.log('LocalStorage Disponible');
      //   localStorage.setItem("KeyId",response.body[0].id)
      // }else{
      //   console.log('LocalStorage NO Disponible');
      // }
          
    },

    computed:{
      ...mapGetters('Login',['getdatosUsuario']),
    },

    methods:{
      ...mapActions('Login',['Login','salirLogin']),

      ingresar (){
        this.iniciar = true;
        var md5     = require('md5')
        var usuario = { correo: this.correo, 
                        usuario : this.correo.toUpperCase(),
                        contrasenia: md5(this.contrasenia) 
                      }

        this.Login(usuario).then(response => {
          if(response){
            this.$router.push({ name: 'compromisos' })  
          }else{
            this.text  = "Lo siento amiguit@ algo salio mal. Verifica tus datos";this.snackbar = true 
            return
          }
        }).catch(error =>{
          console.log(error)
        }).finally(() => this.iniciar = false) 

        
      }
    }
  };


</script>

<style scoped>
  
  #logo{
   border-radius:25px;
  }

  #contenedor{
    background: #eeacb5;  
    background: -webkit-linear-gradient(to right, hsla(353, 75%, 78%, 0.095), #9b646d45);  
    background: linear-gradient(to right, #9b646d8b, #9b646d8b); 
    border-radius:25px;
  }
  
  .fondo{
    background: #ee9ca7;  
    background: -webkit-linear-gradient(to right, #f3b8bf, #ee9ca7);  
    background: linear-gradient(to right, hsla(353, 22%, 63%, 0.449), #ee9ca7),url('http://producciongama.com:8080/CRM-GAMA-2020/imagenes/fondo2.jpg'); 
    background-attachment: fixed;
    background-size: cover;
    padding: 0px;
    margin: 0px;
    width: auto;
    height: 100%;
  }

 
</style>



  
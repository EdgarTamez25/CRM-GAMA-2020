<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >

				<v-snackbar v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nueva Costo Indirecto':'Editar Costo Indirecto' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" >
						<v-text-field
								append-icon="person"
								label="Nombre"
								placeholder="Nombre del usuario"
								hide-details
								dense
								clearable
							></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
								append-icon="email"
								label="Correo"
								placeholder="Correo electronico"
								hide-details
								dense
								clearable
							></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="['Administrador','Supervisor','Vendedor']"
							label="Nivel"
							placeholder="Nivel de acceso"
							append-icon="show_chart"
							dense
							hide-details
							clearable
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
							v-model="password"
							:append-icon="show1 ? 'visibility_off' : 'visibility'"
							:type="show1 ? 'text' : 'password'"
							placeholder="Contraseña de usuario"
							label="Contraseña"
							dense
							clearable
							hide-details
							@click:append="show1 = !show1"
						></v-text-field>
					</v-col>

					<template v-if="param === 1">
						<v-col cols="12" lg="6">
							<v-text-field
								v-model="password2"
								:append-icon="show2 ? 'visibility_off' : 'visibility'"
								:type="show2 ? 'text' : 'password'"
								label=" Confirmar Contraseña"
								clearable
								dense
								hide-details
								@click:append="show2 = !show2"
							></v-text-field>
						</v-col>

						<v-col cols="12" lg="6">
							<v-select
								:items="['Gama Mitras','Gama Talleres','Gama Fresnillo']"
								label="Sucursal"
								placeholder="Sucursal"
								append-icon="store"
								dense
								hide-details
								clearable
							></v-select>
						</v-col>
					</template>
					<v-card-actions class="mx-3" v-if="param === 2">
						<v-spacer></v-spacer>
						<v-btn small rounded color="success"  @click="cambiaPassword = !cambiaPassword" v-if="cambiaPassword"> Cambiar Contraseña	</v-btn>
						<v-btn small rounded color="error" dark @click="cambiaPassword = !cambiaPassword" v-else > Cancelar </v-btn>
					</v-card-actions>

					<template v-if="!cambiaPassword">
						<v-col cols="12" lg="6">
							<v-text-field
								v-model="password2"
								:append-icon="show2 ? 'visibility_off' : 'visibility'"
								:type="show2 ? 'text' : 'password'"
								label=" Confirmar Contraseña"
								clearable
								dense
								hide-details
								@click:append="show2 = !show2"
							></v-text-field>
						</v-col>

						<v-col cols="12" lg="6">
							<v-select
								:items="['Gama Mitras','Gama Talleres','Gama Fresnillo']"
								label="Sucursal"
								placeholder="Sucursal"
								append-icon="store"
								dense
								hide-details
								clearable
							></v-select>
						</v-col>
					</template>
				</v-row>
				<!-- <v-divider class="my-2"></v-divider>  -->
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn small class="success" @click="validaInfo">Guardar</v-btn>
					</v-card-actions>
			</v-col>
		</v-row>
	</v-container>
	
</template>

<script>
	export default {
	  components: {
		},
		props:[
			'param',
			'edit',
	  ],
	  data () {
			return {
				titleModal: 'Carteras',
				// VARIABLES PARA CONTRASEÑA
				cambiaPassword: true,
				password			:'',
				password2			:'',
				PasswordAEdit	:'',
				PasswordActual: '',
				show1					: true,
				show2					: true,
				// VARIABLES PRINCIPALES
				name		: '',
				email		: '',
				newschool:'',
				// ALERTAS
				snackbar: false,
				text		: '',
				color		: 'success',
			}
		},

	    methods:{
				validaInfo(){
					console.log('edit', this.edit)
				}
	    }
	}
</script>
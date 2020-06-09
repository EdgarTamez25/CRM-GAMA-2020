<template>
	<v-content class="pa-0">
		<v-row class="justify-left" no-gutters >
			 <v-btn color="rosa" style="display: none" class="ir-arriba white--text" fab fixed bottom right>
				<v-icon top>keyboard_arrow_up</v-icon>
			</v-btn>
			<v-col cols="12">
				<v-card-title class="font-weight-bold headline celeste white--text">ANÁLISIS DE FASES</v-card-title>
			</v-col>

			<v-col cols="5" sm="2" xl="2" class="mt-5 mx-1" > <!-- FECHA DE COMPROMISO -->
				<v-dialog ref="fecha1" v-model="fechamodal1" :return-value.sync="fecha1" persistent width="290px">
					<template v-slot:activator="{ on }">
						<v-text-field
							 v-model="fecha1" label="Fecha Inicio" append-icon="event" readonly v-on="on"
								outlined dense hide-details color="celeste"
						></v-text-field>
					</template>
					<v-date-picker v-model="fecha1" locale="es-es" color="rosa"  scrollable>
						<v-spacer></v-spacer>
						<v-btn text small color="gris" @click="fechamodal1 = false">Cancelar</v-btn>
						<v-btn dark small color="rosa" @click="$refs.fecha1.save(fecha1)">OK</v-btn>
					</v-date-picker>
				</v-dialog>
			</v-col>

			<v-col cols="5" sm="2" xl="2" class="mt-5 mx-1" > <!-- FECHA DE COMPROMISO -->
				<v-dialog ref="fecha2" v-model="fechamodal2" :return-value.sync="fecha2" persistent width="290px">
					<template v-slot:activator="{ on }">
						<v-text-field
							 v-model="fecha2" label="Fecha fin" append-icon="event" readonly v-on="on"
								outlined dense hide-details color="celeste"
						></v-text-field>
					</template>
					<v-date-picker v-model="fecha2" locale="es-es" color="rosa"  scrollable>
						<v-spacer></v-spacer>
						<v-btn text small color="gris" @click="fechamodal2 = false">Cancelar</v-btn>
						<v-btn dark small color="rosa" @click="$refs.fecha2.save(fecha2)">OK</v-btn>
					</v-date-picker>
				</v-dialog>
			</v-col>

			<v-col cols="1" class="mt-5 mx-1">
				<v-btn color="rosa" fab small dark @click="consultar()"><v-icon>search</v-icon> </v-btn>
			</v-col>

			<v-col cols="12" class="text-center" v-if="Loading">  <!-- PROGRES -->
				<v-progress-circular :size="100" :width="7" color="celeste" indeterminate ></v-progress-circular>
			</v-col>
			
			<v-col cols="12" md="8" lg="9" class="mt-1" >
      	<div class="chartdiv "> </div>
			</v-col>

			<v-col cols="12" md="4" lg="3" class="mt-1 pa-1" v-if="!Loading">
				<v-card class="pa-0">
					<v-simple-table class="elevation-10">
						<template v-slot:default >
							<tbody >
								<tr v-for="(item,i) in Historial" :key="i" :class="['']">
									<td> <v-btn fab :color="colores[i]" x-small></v-btn> </td>
									<td class="font-weight-bold text-left " > {{ item.nombre}} </td>
									<td class="font-weight-bold text-left"> {{ item.cantidad }} </td>
								</tr>
							</tbody>
						</template>
					</v-simple-table>
				</v-card>
			</v-col>

			<v-col cols="12" class="mt-5">
				<v-card-title class="font-weight-bold headline morado white--text">ANÁLISIS POR VENDEDOR</v-card-title>
			</v-col>

			<v-col cols="12" sm="4" md="3" lg="2"  class="mt-5 mx-1">
				<v-select 
					label="Fases de venta" 
					v-model="fase" 
					:items="fases" 
					item-text="nombre" 
					item-value="id" 
					return-object
					hide-details 
					outlined
					dense>
				</v-select>
			</v-col>

			<v-col cols="12" class="mt-1 text-center" >
      	<div class="chartdiv2"> </div>
			</v-col>
		</v-row>
	</v-content>
</template>

<script>
import  SelectMixin from '@/mixins/SelectMixin.js';
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
am4core.useTheme(am4themes_animated);
import $ from 'jquery'

export default {
	mixins:[SelectMixin],
	data:()=>({
		Historial:[],
		HistorialxVend:[],
		fecha1: '',
		fechamodal1:false,
		fecha2: '',
		fechamodal2:false,

		primerDia:'',
		ultimoDia:'',
		fecha:'',
		Loading:true,
		colores:['#69b3d6','#6993d6','#6972d6','#8069d6','#a169d6','#c269d6','#d669c9','#d669a9','#d66988','#d66b69'],
		fases:[{id:1,nombre:'Prospecto'},
						{id:2,nombre:'Por Cotizar'},
						{id:3,nombre:'Cotizado'},
						{id:4,nombre:'Recotizado'},
						{id:5,nombre:'Producción'},
						{id:6,nombre:'Por Entregar'},
						{id:7,nombre:'Entregas Rechazadas'},
						{id:8,nombre:'Proyectos cerrrados'}
					],
		fase: { id:2 , nombre:'Por Cotizar'},
		img: ['https://www.amcharts.com/lib/images/faces/A04.png',
					'https://www.amcharts.com/lib/images/faces/C02.png',
					'https://www.amcharts.com/lib/images/faces/D02.png',
					'https://www.amcharts.com/lib/images/faces/E01.png'],
		colores2:['#0096cb', '#bf1c7f','#272727','#894975','#6f7170' ]
	

	}),

	created(){
		this.fecha1 = this.traerMesActual().fechaInicial;
		this.fecha2 = this.traerMesActual().fechaFinal;
		this.consultar()
		this.consultarxFase()
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

	watch:{
		fase:function(){
			console.log('fase', this.fase)
			this.consultarxFase()
		},
	},

	methods:{
		consultar(){
			const payload = { fecha1: this.fecha1 , fecha2: this.fecha2 }
			this.Historial = []; this.Loading = true;
			this.$http.post('historial',payload).then(response =>{
					this.Historial.push( {nombre:'Prospecto', cantidad: response.body[0]},
																{nombre:'Por Cotizar', cantidad: response.body[1]},
																{nombre:'Cotizado', cantidad: response.body[2]},
																{nombre:'Recotizar', cantidad: response.body[3]},
																{nombre:'Producción', cantidad: response.body[4]},
																{nombre:'Por Entregar', cantidad: response.body[5]},
																{nombre:'Entrega Rechazada', cantidad: response.body[6]},
																{nombre:'Proyecto Cerrado', cantidad: response.body[7]},
																{nombre:'Cerrados correctos', cantidad: response.body[8]},
																{nombre:'Cerrados incorrectos', cantidad: response.body[9]},
															)
					this.grafica();
					this.consultarxFase();
			}).catch(err =>{
				console.log('err', err)
			}).finally(() => this.Loading= false) 

		},

		consultarxFase(){
			const payload = { fecha1: this.fecha1 , fecha2: this.fecha2, fase: this.fase.id}
			this.HistorialxVend = []; this.Loading2 = true;

			this.$http.post('historialxvend',payload).then(response =>{
				// this.HistorialxVend = response.body
				console.log('response', response.body)
				for(let i=0; i< response.body.length;i++){

					// this.HistorialxVend = response.body
					this.HistorialxVend.push({  nombre: this.LimitaString(response.body[i].nomvend),
																			cantidad: response.body[i].cantidad,
																			color: this.colores2[i],
																			bullet: this.img[i]})
					console.log('array', this.HistorialxVend)
				}
				this.grafica2();

			}).catch(err =>{
				console.log('err', err)
			}).finally(() => this.Loading= false) 
		},

		LimitaString(nomvend){
			var max = 20, nombre = '';
			if(nomvend.length > max){
				nombre = nomvend.substring(0,max) + '...'
			}else{
				nombre = nomvend
			}
			return nombre;
		},


		grafica(){
			let chart = am4core.create("chartdiv", am4charts.XYChart3D);

			// Add data
			chart.data = this.Historial

			// Create axes
			let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "nombre";
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.hideOversized = false;
			categoryAxis.renderer.minGridDistance = 20;
			categoryAxis.renderer.labels.template.horizontalCenter = "right";
			categoryAxis.renderer.labels.template.verticalCenter = "middle";
			categoryAxis.tooltip.label.rotation = 270;
			categoryAxis.tooltip.label.horizontalCenter = "right";
			categoryAxis.tooltip.label.verticalCenter = "middle";

			let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.title.text = "Cantidades";
			valueAxis.title.fontWeight = "bold";

			// Create series
			let series = chart.series.push(new am4charts.ColumnSeries3D());
			series.dataFields.valueY = "cantidad";
			series.dataFields.categoryX = "nombre";
			series.name = "Cantidad";
			series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;

			let columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
			columnTemplate.stroke = am4core.color("#FFFFFF");

			columnTemplate.adapter.add("fill", function(fill, target) {
				return chart.colors.getIndex(target.dataItem.index);
			})

			columnTemplate.adapter.add("stroke", function(stroke, target) {
				return chart.colors.getIndex(target.dataItem.index);
			})

			chart.cursor = new am4charts.XYCursor();
			chart.cursor.lineX.strokeOpacity = 0;
			chart.cursor.lineY.strokeOpacity = 0;
		},

		grafica2(){
			let chart = am4core.create("chartdiv2", am4charts.XYChart);
			// chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

			// chart.paddingRight =800;
			console.log('historiaxvend', this.HistorialxVend)
			chart.data = this.HistorialxVend

			// Create axes
			let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());

			categoryAxis.dataFields.category = "nombre";
			categoryAxis.renderer.labels.template.rotation = 270;
			categoryAxis.renderer.labels.template.hideOversized = false;
			categoryAxis.renderer.minGridDistance = 80;
			categoryAxis.tooltip.label.rotation = 270;
			categoryAxis.tooltip.label.horizontalCenter = "right";
			categoryAxis.tooltip.label.verticalCenter = "middle";
			categoryAxis.renderer.labels.template.fontSize = 15;

			let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.renderer.grid.template.strokeDasharray = "4,4";
			valueAxis.renderer.labels.template.disabled = true;
			valueAxis.min = 0;

			// Do not crop bullets
			chart.maskBullets = false;
			// Remove padding
			chart.paddingBottom = 0;

			// Create series
			let series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "cantidad";
			series.dataFields.categoryX = "nombre";
			series.columns.template.propertyFields.fill = "color";
			series.columns.template.propertyFields.stroke = "color";
			series.columns.template.column.cornerRadiusTopLeft = 15;
			series.columns.template.column.cornerRadiusTopRight = 15;
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/b]";

			// Add bullets
			let bullet = series.bullets.push(new am4charts.Bullet());
			let image = bullet.createChild(am4core.Image);
			image.horizontalCenter = "middle";
			image.verticalCenter = "bottom";
			image.dy = 20;
			image.y = am4core.percent(100);
			image.propertyFields.href = "bullet";
			image.tooltipText = series.columns.template.tooltipText;
			image.propertyFields.fill = "color";
			image.filters.push(new am4core.DropShadowFilter());
			
		}
	}
}
</script>

<style>
.chartdiv {
  width: 100%;
	height: 600px ;
}

.chartdiv2 {
  width: 100%;
  height: 500px;
}
</style>
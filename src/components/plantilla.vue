<template>
  <v-main >
    <v-btn color="black" dark left absolute fixed bottom @click="generar_pdf()">
      IMPRIMIR PDF
    </v-btn>

    <div ref="content" style="margin: 5px 5px; width:100%; min-height: 100%;position: relative;" >
        <header style="display:flex;justify-content: space-between ;">
          <div style="display:flex">
            <img
              alt="Logotipo GAMA"
              src="@/assets/logotipo.png" 
              width="140"
              height="35"
            />
          </div>

          <div style="display:flex">
            <ol>
              <ul style="font-size: 6px;  text-align: right">IT-7-PRO-02-R01</ul> 
              <ul style="font-size: 9px;  text-align: center;"> <strong> ORDEN DE <br> TRABAJO</strong> </ul> 
              <ul style="font-size: 9px;  text-align: center"> 426</ul> 
            </ol>
          </div>
        </header>

        <div style="display: flex ">
          <div style="font-size:8px;margin-top: 10px">
            <ol>
              <ul><b>Cliente:</b> GAMA ETIQUETAS S.A. DE C.V. </ul>
              <ul><b>Vendedor:</b> TAMEZ GARCIA EDGAR GEOVANI   </ul>
            </ol>
          </div>
          </t>
          <div style="font-size:8px;margin-top:10px; margin-left: 50px">
            <ol>
              <ul><b>Orden de compra:</b> 390 </ul>
              <ul><b>Fecha de programación:</b> 22 de abril del 2022  </ul>
            </ol>
          </div>
        </div>

        <div style="margin-top:10px;"></div>

        <div style="margin: 0; " >
          <table style="font-size:7px; padding: 5px;" class="tabla-principal" >
            <thead>
              <tr>
                <th class="th-principal text-left"> ID</th>
                <th class="th-principal text-left">Producto </th>
                <th class="th-principal text-left">Cantidad </th>
                <th class="th-principal text-center">Digital </th>
                <th class="th-principal text-center">Offset </th>
                <th class="th-principal text-center">Acabados </th>
                <th class="th-principal text-left">Comentarios </th>
                <th class="th-principal text-center">Fecha </th>
                <th class="th-principal text-center">Proceso </th>
                <th class="th-principal text-center">Fecha limite </th>
              </tr>
            </thead>
            
            <tbody>
              <tr v-for="item in desserts" :key="item.name" >
                <td class="td-principal" style="max-width:11px; text-align: left">{{ item.id }}</td>
                <td class="td-principal" style="max-width:px;   text-align: left">{{ item.producto }}</td>
                <td class="td-principal" style="max-width:3px;  text-align: left">{{ item.cantidad }}</td>
                <td class="td-principal" style="max-width:8px;  text-align: center">{{ item.digital }}</td>
                <td class="td-principal" style="max-width:8px;  text-align: center">{{ item.offset }}</td>
                <td class="td-principal" style="max-width:8px;  text-align: center">{{ item.acabados }}</td>
                <td class="td-principal" style="max-width:45px; text-align: left">{{ item.comentarios }}</td>
                <td class="td-principal" style="max-width:35px; text-align: center">{{ item.fecha }} {{ item.hora }}</td>
                <td class="td-principal" style="max-width:10px; text-align: center">{{ item.proceso }} </td>
                <td class="td-principal" style="max-width:10px; text-align: center">{{ item.fecha_entrega }} </td>
              </tr>
            </tbody>
          </table>
        </div> 

        <br>

        <footer >
          <!--style="display:flex;"
          <div style="display:flex; font-size:8px; margin-right: 5px" >
            <ol>
              <ul>REV.0 </ul>
              <ul>Vigencia del 04 de Marzo del 2013 </ul>
            </ol>
          </div>

          <div style="display:flex;font-size:8px; margin-left:5px" v-for="(i, item) in 2" :key="i">
            <table style="font-size:7px; padding: 5px; border:solid ;border-width: 0.5px" class="tabla-2"  >
              <thead >
                <tr>
                  <th class="text-left"> TRABAJO</th>
                  <th class="text-left"> </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="td-2" style="min-width:100px; "> </td>
                  <td class="td-2" style="min-width:100px; "> </td>
                </tr>
                <tr>
                  <td class="td-2" style="min-width:100px; "> </td>
                  <td class="td-2" style="min-width:100px; "> </td>
                </tr>
              </tbody>
            </table>
          </div>
          -->
        </footer>

     </div>
    </v-main>
</template>

<script>
  import jsPDF from 'jspdf';
  import autoTable from 'jspdf-autotable'
  // import html2canvas from "html2canvas"

  export default {
    data: () => ({
      desserts: [
          {
            id: 159,
            producto: '12341434',
            cantidad: 150000,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
            
          },
          {
            id: 237,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 262,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 305,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 356,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 375,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 375,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 375,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 375,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 375,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },

          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },

          {
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },{
            id: 392,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal pinguinita que tal si tu y yo derretimos esta nieve',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
          {
            id: 408,
            producto: '12341434',
            cantidad: 15,
            digital: '',
            offset: '',
            acabados:'',
            comentarios: 'hola que tal',
            fecha: '2022-04-22',
            hora: '10:30',
            proceso: 'DIGITAL',
            fecha_entrega: '2022-05-22'
          },
        ],
    }),

    methods:{
      generar_pdf(){
        const doc = new jsPDF({ 
            orientation: "landscape", 
            format: "letter", 
            unit: 'px' 
          });
        const contentHtml = this.$refs.content;
       
        doc.html(contentHtml, {
          margin: [6,6],
          autoPaging: 'text',
          callback: doc => {
            doc.save("Test.pdf");
          },
        });

      }
    }

  }

</script>

<style>
  .tabla-principal {
   width: 100%;
   max-height: 200px !important;
   text-align: left;
   caption-side: top;
      border-collapse: collapse;
  }
    
  .th-principal, .td-principal {
    border-bottom: 0.5px solid #757575;
    margin:3px;
  }

  .th-principal{
      background-color: #8F9AA5;
      color: #ffff;
      font-size: 8px;
      border-width: 1px;
  }

  .tabla-2,.td-2 {
      border: 0.2px solid black;
      border-collapse: collapse;
      border-width: 0.1px;
  }

  footer {
     /* background-color: black; 
      color: white;*/
      position: fixed;
      bottom: 0;
      /*width: 100%;
      height: 40px; */
    }
   
</style>


import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable'

export default {
  data:()=>({
    heading: "ORDEN DE TRABAJO",
    conceptos: [{id:1, nombre:'PRODUCCION'}, {id:2, nombre:'STOCK'}],
    urgencias:[{id:1, nombre:'NORMAL'},{id:2, nombre:'URGENTE'},{ id:3, nombre:'PRIORIDAD'}],
  }),

  methods: {
    traerFechaActual(){
			var f = new Date(); 
			return f.getFullYear() +'-'+ (f.getMonth() + 1 < 10? '0' + (f.getMonth() + 1): f.getMonth() + 1 ) +'-'+ (f.getDate()<10?'0'+f.getDate():f.getDate());
		},
    generatePDF(columns, detalle, informacion) {

      const doc = new jsPDF({
        orientation: "portrait",  // ORIENTACION-RETRATO
        unit: "in",               // UNIDAD
        format: "letter"          // FORMATO - CARTA
      });

      // console.log('doc', doc)

      // EL TEXTO SE COLOCANDO USANDO CORDENADAS X & Y 
      doc.setFontSize(16)
        //  .setFontStyle("italic")
        // .setFontStyle("black")
        .text(this.heading, 0.5, 1.0);
      doc.setFontSize(12).text(this.traerFechaActual(), 7, 1.0);
      // CREAR UNA LINEA DEBAJO DEL ENCABEZADO
      doc.setLineWidth(0.01).line(0.5, 1.1, 8.0, 1.1);
      // USO DEL PLUGIN AUTOTABLE
      let tdetalle = [];
      for(let x =0; x<detalle.length; x++){
        tdetalle.push({id            : detalle[x].id,
                       producto      : detalle[x].producto,
                       cantidad      : detalle[x].cantidad,
                       concepto      : this.conceptos[ detalle[x].concepto-1].nombre,
                       fecha_progra  : detalle[x].fecha_progra,
                       fecha_entrega : detalle[x].fecha_entrega,
                       urgencia      : this.urgencias[detalle[x].urgencia -1].nombre 
                     })
      }

      doc.autoTable({
        columns,                          // HEADERS
        body: tdetalle,                 // ARRAY A MOSTRAR O CONSULTA
        margin: { left: 0.5, top: 3.0 }  // MARGENES DE LAS COLUMNAS 1.25
      });
      
      // console.log('informacion', informacion);
      // USO DE UN CONJUNTO DE ORACIONES
      let x = 0.5, y = 1.25;
      for(const i in informacion){
        y = y + .25;  // aumento la posicion del texto
        doc
        .setFont("helvetica")  // TIPO DE LETRA
        .setFontSize(12)       // TAMAÑO DE LA LETRA
        .text(informacion[i].text +': '+ ' '+ informacion[i].value.toString()
              ,x,y, { align: "left", maxWidth: "7.5" }); //  (TEXTO A AGREGAR, POS EN X, POS EN Y , PARAMETROS DE ALIENACION Y MARGEN)
      }
      
      doc
        .setFont("times")
        .setFontSize(11)
        // .setFontStyle("italic")
        // .setFontType("italic")
        .setTextColor(191,28,127)
        .text("Todos los derechos reservador por Gama Etiquetas S.A. DE C.V.", 0.5, doc.internal.pageSize.height - 0.5 )
        .save(`${this.heading}.pdf`);
    }
  }
}
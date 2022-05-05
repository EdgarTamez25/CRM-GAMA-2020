
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable'

export default {
  data:()=>({
    heading: `ORDEN DE TRABAJO` ,
    conceptos: [{id:1, nombre:'PRODUCCION'}, {id:2, nombre:'STOCK'}],
    urgencias:[{id:1, nombre:'NORMAL'},{id:2, nombre:'URGENTE'},{ id:3, nombre:'PRIORIDAD'}],
  }),

  methods: {
    traerFechaActual(){
			var f = new Date(); 
			return f.getFullYear() +'-'+ (f.getMonth() + 1 < 10? '0' + (f.getMonth() + 1): f.getMonth() + 1 ) +'-'+ (f.getDate()<10?'0'+f.getDate():f.getDate());
		},
    generatePDF(columns, detalle, informacion, OT) {
      // https://www.npmjs.com/package/jspdf-autotable
      const doc = new jsPDF({
        orientation: "landscape",  // ORIENTACION-RETRATO
        unit: "pt",               // UNIDAD
        format: "a4",         // FORMATO - CARTA
        // format: "letter"          // FORMATO - CARTA
      });
      
      // const header = 'Report 2014';
      // doc.text(header, 40, 15, { baseline: 'top' });
      const pageSize = doc.internal.pageSize;
      const pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
      const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
      console.log('pageHeight', pageHeight)
      // doc.addImage(imgLogo,'PNG',0.4,0.4, 2.4 ,0.8)
      // doc.setFontSize(12).text("ORDEN DE TRABAJO", 9.0, 0.5);
      // doc.setFontSize(14).text(`${OT}`, 10, 0.8);
      
      // USO DE UN CONJUNTO DE ORACIONES
      
      // USO DEL PLUGIN AUTOTABLE
      let tdetalle = [];
      for(let x =0; x<detalle.length; x++){
        tdetalle.push({ id            : detalle[x].id,
                        producto      : detalle[x].producto,
                        cantidad      : detalle[x].cantidad,
                        concepto      : this.conceptos[ detalle[x].concepto-1].nombre,
                        fecha_entrega : detalle[x].fecha_entrega,
                        urgencia      : this.urgencias[detalle[x].urgencia -1].nombre,
                        comentarios   : detalle[x].comentarios,
                        digital   : "",
                        offset   : "",
                        acabados   : "",
                        finalizacion   : "",
                      })
      }

      
      doc.autoTable({
        columns,   
        headStyles:{ cellPadding:2 },                      // HEADERS
        body: tdetalle,                 // ARRAY A MOSTRAR O CONSULTA
        margin: { left: 30, top: 135 },  // MARGENES DE LAS COLUMNAS 1.25
        columnStyles: { 
          cantidad: { halign: 'center'},
          comentarios: { cellWidth: 150, cellHeight:5 }},
        rowPageBreak:'avoid', 
        tableWidth:'auto',
        tableHeight:'10',
        styles: { fontSize: 7 },
      });
      
      // doc
      //   .setFont("times")
      //   .setFontSize(10)
      //   .text("IT-7-PRO-02-R01 - REV. 0", 0.5, doc.internal.pageSize.height - 0.7 );
        // .autoPrint();
      const pageCount = doc.internal.getNumberOfPages();
      const logotipo = require("@/assets/logotipo.png");
      var imgLogo = new Image();
      imgLogo.src = logotipo;
      for(let i = 1; i <= pageCount; i++){
        // console.log('i', i)

        doc.setPage(i);
        doc.addImage(imgLogo,'PNG',20,15, 180 ,60, );
        doc.setFontSize(8).text("IT-7-PRO-02-R01", 700 , 25, );
        doc.setFontSize(12).text("ORDEN DE TRABAJO", 700 , 40, );
        doc.setFontSize(14).text(`${OT}`, 700 , 55, ); 
        doc.setFont("helvetica").setFontSize(8) 
        doc.text(informacion[0][0].text +': '+ ' '+ informacion[0][0].value,30,100, { align: "left", maxWidth: "250" }); 
        doc.text(informacion[0][1].text +': '+ ' '+ informacion[0][1].value,30,120, { align: "left", maxWidth: "250" }); 
        doc.text(informacion[1][0].text +': '+ ' '+ informacion[1][0].value,300,100, { align: "left", maxWidth: "250" }); 
        doc.text(informacion[1][1].text +': '+ ' '+ informacion[1][1].value,300,120, { align: "left", maxWidth: "250" }); 

      //   doc.autoTable({
      //   head : [['TRABAJARON','','','' ]] ,// HEADERS
      //   body : [ 
      //     ['',''], 
      //     ['',''], 
      //     ['',''], 
      //     ['','']
      //   ] ,
      //   // margin: { left: 30, top: 560},
      //   styles: { fontSize: 8},
      //   tableWidth: 250,
      //   showFoot:'lastPage',
      //   x:30 , y:560
        
      // });
        
        const footer = `Página ${i} de ${pageCount}`;
        doc.text("REV-0", 30, pageHeight - 25);
        doc.text("Vigencia del 04 de Marzo del 2013", 30, pageHeight - 15);
        doc.text(footer, pageWidth / 2 - (doc.getTextWidth(footer) / 2), pageHeight - 15);
      }

      // doc.autoTable({
      //   head : [['TRABAJARON','','','' ]] ,// HEADERS
      //   body : [ 
      //     ['',''], 
      //     ['',''], 
      //     ['',''], 
      //     ['','']
      //   ] ,
      //   margin: { left: 0.3, top: 8.0},
      //   styles: { fontSize: 8},
      //   tableWidth: 100,
      //   showFoot:'lastPage',
      //   x:30 , y:100
        
      // }, { baseline: 'bottom' });
      doc
      // .text("Vigencia del 04 de Marzo del 2013", 1, doc.internal.pageSize.height - 1 )
      .save(`${this.heading}-${this.traerFechaActual()}.pdf`);
    }
  }
}
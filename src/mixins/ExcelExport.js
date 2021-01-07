  require('script-loader!file-saver');
  import XLSX from 'xlsx'

  export default {
    data(){
      return{
        Contenido: [],
        headers: [],
      }
    },

    methods: {
      formarEncabezados(titulo,headers,datosVista){
        let tHeaders = [], tValores = [];
        for(let i =0;i< headers.length; i++){
          tHeaders.push(headers[i].text);
          tValores.push(headers[i].value);
        }
        console.log('tHeaders', tHeaders)
        console.log('tValores', tValores)
        
        this.manejarDescarga(titulo,tHeaders,tValores,datosVista)
      },

      manejarDescarga(titulo,tHeaders,tValores,datosVista) {
        import('@/components/Export2Excel').then(excel => {
          
          const tHeader   = tHeaders; // ENCABEZADOS DEL DOCUEMENTO
          const filterVal = tValores; // CAMPOS DE EXCEL
          const list = datosVista // ARRAY DE DATOS
          const data = this.formatJson(filterVal, list) // FORMAR JSON 
          
          
          excel.export_json_to_excel({ // FUNCION PARA EXPORTAR EXCEL
            header: tHeader,           // COLOCAR ENCABEZADOS
            data,                      // COLOCAR CONTENIDO 
            filename: titulo,       // NOMBRE DEL ARCHIVO
            autoWidth: true,           // ANCHO AUTOMATICO DE LAS COLUMNAS
            bookType: 'xls'            // FORMATO
          })
          this.downloadLoading = false
        })
      },

      formatJson(filterVal, jsonData) {
        return jsonData.map(v => filterVal.map(j => {
          if (j === 'timestamp') {
            return parseTime(v[j])
          } else {
            return v[j]
          }
        }))
      }
      
    }
  }

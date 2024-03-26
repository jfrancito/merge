<template>
  <!-- 
  <div class="be-content"   >-->
  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            Documentos pendientes
      
          </div>
           <div class='row md-pt-15 md-pb-20 xs-pt-15 xs-pb-20'>
                    <div class="col-xs-12">

                       <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                            <div class="form-group xs-mb-0">
                               <label class="col-sm-12 control-label"> Empresa</label>
                            </div>
                              <div class="col-sm-12 xs-pb-25">
                                     <select class="form-control input-sm" v-model="Empresa">
                                          
                                          <option v-for="e in oEmpresa"  :key="e.COD_EMPR" v-bind:value="e.COD_EMPR" >
                                                {{ e.NOM_EMPR }}
                                          </option>
                                    </select>
                              </div>
                             
                      </div>
                      <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                            <div class="form-group xs-mb-0">
                               <label class="col-sm-12 control-label"> Centro </label>
                            </div>
                              <div class="col-sm-12 xs-pb-25">
                                     <select class="form-control input-sm" v-model="Centro">
                                       
                                          <option v-for="c in oCentro"  :key="c.COD_CENTRO" v-bind:value="c.COD_CENTRO" >
                                                {{ c.NOM_CENTRO }}
                                          </option>
                                    </select>
                              </div>
                             
                      </div>
                      <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                          <div class="form-group xs-mb-0">
                            <label class="col-sm-12 control-label">
                              Desde
                            </label>
                            <div class="col-sm-12  xs-pb-25">
                            <datepicker :language="es" v-model="FecIni" :format="customFormatter" input-class="form-control input-sm"></datepicker>
                            </div>
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                          <div class="form-group xs-mb-0">
                            <label class="col-sm-12 control-label">
                              Hasta
                            </label>
                            <div class="col-sm-12 xs-pb-25">
                             <datepicker :language="es" v-model="FecFin"  :format="customFormatter" input-class="form-control input-sm"></datepicker>
                            </div>
                          </div>
                      </div>

                       <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                          <div class="form-group xs-mb-0">
                            <label class="col-sm-12 control-label">
                              Estado
                            </label>
                            <div class="col-sm-12 xs-pb-25">
                              <input type="checkbox" id="checkbox" v-model="checkestado">
                                <label for="checkbox"> <span :class="[checkestado==true? 'label label-success' : 'label label-danger']" >{{ checkestado ? "Pagado" : "Pendiente" }}</span></label>
                            </div>
                          </div>
                      </div>

                    </div>
                    <div class="col-xs-12 md-pt-10 xs-pt-10">
               
                      <div class="email-search text-center md-pt-20 xs-pt-10" >
                        <button @click="listarData(1)" class="btn btn-rounded btn-space btn-primary" :disabled="validarBusqueda">
                          <i class="icon icon-left mdi mdi-search"></i> Buscar
                        </button>
                      </div>
                    </div>
           </div>
           
         
         
        </div>
      </div>
    </div>

    <div class="row" :class="[loading==true? 'hide' : ''] ">
        <div class="col-sm-12">
          <div class="panel panel-default panel-table">

            <div class="panel-heading panel-heading-divider">
              <div class="tools"><span class="icon mdi mdi-money-box" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pagar Detracción"  @click="ProcesarDetraccion()"></span><span class="icon mdi mdi-more-vert"></span></div>
              <span class="panel-subtitle" style="color: #4285f4;"><span class="badge badge-primary" v-text="count(oObj.rows)" style="color: #ffffff;background-color: #5f99f5;" ></span> &nbsp; Registros encontrados.</span>
             
            </div>
               
              <br />
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 form-inline">
                    <div class="form-group pull-center">

                       <span class="md-ml-10 badge badge-success" > {{selected_rows.length}} </span> <span class="text-success"> registros seleccionados. </span> 
                      
                    </div>
                    <div class="form-group pull-right">
                      <label for="filter" class="sr-only">Filtrar</label>
                      <input type="text" class="form-control input-sm" v-model="buscar" placeholder="Búsqueda interna" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div id="table" class="col-xs-12 table-responsive">
                    <!-- <datatable :columns="oObj.columns" :data="oObj.rows" :filter-by="buscar"></datatable> -->

                                  <datatable :columns="oObj.columns" :data="oObj.rows" :filter-by="buscar">
                                      <template slot-scope="{ row, columns }">
                                          <tr :class="{success: selected_rows.indexOf(row) !== -1}" @click="selectRow(row)">
                                              <template>
                                                  <datatable-cell v-for="(column, j) in columns" :key="j" :column="column" :row="row"></datatable-cell>
                                              </template>
                                          </tr>
                                      </template>
                                  </datatable>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 form-inline">
                    <datatable-pager v-model="oObj.page " type="abbreviated" :per-page="oObj.per_page"></datatable-pager>
                  </div>
                </div>
              </div>
          </div>
          
        </div>
    </div>
    <div class="row"  :class="[loading==true? 'text-center' : 'hide'] ">
      <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

      <div
      tabindex="-1"
      role="dialog"
      :class="{'mostrar' : preconciliacionview}"
      class="modal fade colored-header colored-header-primary"
       >
        <div class="modal-dialog custom-width"     :class="{'mostrarsub' : preconciliacionview}">
             <div class="row"  :class="[pagodetraccionview==true? 'text-center' : 'hide'] ">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
              </div>
            <div class="modal-content" :class="[pagodetraccionview==false? '' : 'hide'] ">
              <div class="modal-header" style="padding: 30px 20px !important;">
                <button type="button" aria-hidden="true" class="close md-close">
                  <span class="mdi mdi-close"></span>
                </button>
                <h3 class="modal-title">Generación Automática de Guias Remisión</h3>
              </div>
              <div class="modal-body">
                <div class="well well-sm text-info">Está apunto de procesar <span class="md-ml-10 badge badge-success" > {{selected_rows.length}}</span>&nbsp; Boletas</div>
                <div class="form-group col-sm-12">
                      <label class="control-label col-sm-3 text-center">Serie</label>
                        <div class="col-sm-5">
                                    <select class="form-control input-sm" v-model="Serie">
                                            <option value="">Seleccione Serie</option>
                                             <option v-for="c in oSerie"  :key="c.COD_DOC_SERIE" v-bind:value="c.COD_DOC_SERIE" >
                                                {{ c.NRO_SERIE }}
                                          </option>
                                      </select>
                        </div>
                </div>
               
                     
               <div class="form-group col-sm-12">
                  <label class="control-label col-sm-3 text-center">Emisor</label>
                   <div class="col-sm-6">
                                    <select class="form-control input-sm" v-model="Empresa" disabled>
                                          
                                          <option v-for="e in oEmpresa"  :key="e.COD_EMPR" v-bind:value="e.COD_EMPR" >
                                                {{ e.NOM_EMPR }}
                                          </option>
                                    </select>
                    </div>
                </div>
                 <div class="form-group col-sm-12">
                  <label class="control-label col-sm-3 text-center">Dirección Partida</label>
                   <div class="col-sm-9">
                                         <select class="form-control input-sm" v-model="DireccionPartida">
                                          
                                          <option v-for="e in oDireccion"  :key="e.COD_DIRECCION" v-bind:value="e.COD_DIRECCION" >
                                                {{ e.NOM_DIRECCION }}
                                          </option>
                                    </select>
                    </div>
                </div>

                           
               <div class="form-group col-sm-12">
                  <label class="control-label col-sm-3 text-center">Receptor</label>
                   <div class="col-sm-7">
                                    <select class="form-control input-sm" v-model="Empresa" disabled >
                                          
                                          <option v-for="e in oEmpresa"  :key="e.COD_EMPR" v-bind:value="e.COD_EMPR" >
                                                {{ e.NOM_EMPR }}
                                          </option>
                                    </select>
                    </div>
                </div>
                 <div class="form-group col-sm-12">
                  <label class="control-label col-sm-3 text-center">Dirección Llegada</label>
                   <div class="col-sm-9">
                                    <select class="form-control input-sm" v-model="DireccionLlegada">
                                          
                                          <option v-for="e in oDireccion"  :key="e.COD_DIRECCION" v-bind:value="e.COD_DIRECCION" >
                                                {{ e.NOM_DIRECCION }}
                                          </option>
                                    </select>
                    </div>
                </div>
                  <div class="form-group col-sm-12">
                      <label class="control-label col-sm-3 text-center">Motivo</label>
                        <div class="col-sm-5">
                                    <select class="form-control input-sm" v-model="Motivo">
                                            <option value="">Seleccione Motivo</option>
                                             <option v-for="c in oMotivo"  :key="c.COD_CATEGORIA" v-bind:value="c.COD_CATEGORIA" >
                                                {{ c.NOM_CATEGORIA}}
                                          </option>
                                      </select>
                        </div>
                </div>
               
               
                
              </div>
              <div class="modal-footer">
                <button type="button" @click="cerrarModal()" class="btn btn-default md-close">Cancelar</button>
                <button type="button"  @click="GeneraccionGrr()" class="btn btn-primary md-close" :disabled="validarEnvio">Procesar</button>
          
              </div>
            </div>
          </div>
      
      
      
      
      </div>


      
      <div
      tabindex="-1"
      role="dialog"
      :class="{'mostrar' : resultdogrrview}"
      class="modal fade colored-header colored-header-primary "
       >
        <div class="modal-dialog custom-width"     :class="{'mostrarsub' : resultdogrrview}">
         
            <div class="modal-content" >
              <div class="modal-header" style="padding: 30px 20px !important;">
                <button type="button" aria-hidden="true" class="close md-close">
                  <span class="mdi mdi-close"></span>
                </button>
                <h3 class="modal-title">Generación Automática de Guias Remisión</h3>
              </div>
              <div class="modal-body">
                <div class="well well-sm text-info">Se procesaron correctamente<span class="md-ml-10 badge badge-warning" > {{selected_rows.length}}</span>&nbsp; Boletas</div>

                  <table class="table table-condensed table-hover table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>BOLETA</th>
                        <th >GRR</th>
                        <th class="number">Monto</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sc in oResultadoGrr" :key="sc.COD_BOLETA" >           
                             <td>{{sc.BOLETA}}</td>
                             <td>{{sc.GRR}}</td>
                             <td class="number">{{sc.CAN_TOTAL_GRR}}</td>
                
                         </tr>
                     
                    </tbody>
                  </table>
               
                
              </div>
              <div class="modal-footer">
                <button type="button" @click="cerrarModal()" class="btn btn-default md-close">Cancelar</button>
                <button type="button"  @click="finalizarGrr()" class="btn btn-primary md-close" >Ok</button>
          
              </div>
            </div>
          </div>
      
      
      
      
      </div>
  
  
  
  </div>

  <!-- </div> -->
</template>
 

<script>
import DatatableFactory from "vuejs-datatable";
import { es } from 'vuejs-datepicker/dist/locale';
import moment from 'moment';
import XLSX from 'xlsx'

var eventBus = new Vue();

Vue.component('select-row', {
        template: `<input type="checkbox" v-model="selected" @change="emitSelected">`,
    props: ['row'],
    data: function(){ return {
        selected: false
    }},
    methods: {
        emitSelected: function () {
            if(this.selected){
                eventBus.$emit('selected', this.row);
            }else{
                eventBus.$emit('deselected', this.row);
            }
        }
    },
    created: function () {
        eventBus.$on('select-all', function (selected) {
            this.selected = true;
        }.bind(this));

        eventBus.$on('deselect-all', function (selected) {
            this.selected = false;
        }.bind(this));
    }
});

Vue.component('select-all', {
    template: `<input type="checkbox" v-model="selected" @change="emitSelection">`,
    data: function () {
        return {
            selected: false
        }
    },
    methods: {
        emitSelection: function(){
            eventBus.$emit(this.selected ? 'select-all' : 'deselect-all');
        }
    },
    created: function(){
        eventBus.$on('deselected', function (row) {
            this.selected = false;
        }.bind(this));

        eventBus.$on('all-selected', function (row) {
            this.selected = true;
        }.bind(this));
    }
});
Vue.component('edit-button', {
  template: `<button class= "btn btn-xs btn-primary" disabled > <span class="icon-dropdown mdi mdi-settings"></span> </button>`,
  props: ['row'],
  methods: {
    goToUpdatePage: function(){
      window.location = '/contact/' + this.row.CODIGO+ '/update';
    }
  }
});

export default {
  components: { DatatableFactory },
  props: ["ruta"],
  data() {
    return {
      oObj: {
        columns: [
          //  { label: '', component: 'select-row', headerComponent: 'select-all' },
          { label: "código", field: "CODIGO" },
          { label: "serie", field: "SERIE" },
          { label: "doc", field: "DOC" },
          { label: "cliente", field: "CLIENTE" },
          { label: "total", field: "CAN_TOTAL" },
          { label: '', component: 'edit-button' }
        ],
        rows: [],
        page:1,
        per_page: 50
        
      },
      es: es,
      selected_rows: [],
      FecIni:  new Date(),
      FecFin :  new Date(),
      Empresa:"",
      DireccionPartida:"",
      DireccionLlegada:"",
      Centro:"",
      Motivo:"",
      Serie:"",
      buscar: "",
      loading: false,
      preconciliacionview: 0,
      oEmpresa:[],
      oCentro:[],
      oSerie:[],
      oMotivo:[],
      oDireccion:[],
      pagodetraccionview:0,
      resultdogrrview:0,
      oResultadoGrr: {
        BOLETA:'',
        CAN_TOTAL_GRR: 0,
        COD_BOLETA: '',
        COD_GRR: '',
        GRR: ''
      },
      checkestado: false
    };
  },
    watch: {
        selected_rows: function(){
            for(var row of this.oObj.rows){
                if(this.selected_rows.indexOf(row) === -1){
                    return;
                }
            }

            eventBus.$emit('all-selected');
        }
    },
    created: function(){
        eventBus.$on('selected', function(row){
            if(this.selected_rows.indexOf(row) === -1){
                this.selected_rows.push(row);
            }
        }.bind(this));

        eventBus.$on('deselected', function (row) {
            if (this.selected_rows.indexOf(row) !== -1) {
                let index = this.selected_rows.indexOf(row);

                this.selected_rows.splice(index, 1);
            }
        }.bind(this));

        eventBus.$on('select-all', function (selected) {
            Vue.set(this, 'selected_rows', this.oObj.rows.slice(0));
        }.bind(this));

        eventBus.$on('deselect-all', function (selected) {
            Vue.set(this, 'selected_rows', []);
        }.bind(this));
    },
  computed: {
    validarEnvio: function() {
        if (this.Motivo!="" & this.serie!="" & this.DireccionPartida!="" & this.DireccionLlegada!="" ){
          
          return false;
        } else {  
          return true;
        }

    },
    validarBusqueda: function(){
      if (this.Centro!="" & this.Empresa!=""){
        return false;
      }else {
        return true;
      }
    }
    // //Calcula los elementos de la paginación
    // pagesNumber: function() {
    //   if (!this.pagination.to) {
    //     return [];
    //   }

    //   var from = this.pagination.current_page - this.offset;
    //   if (from < 1) {
    //     from = 1;
    //   }

    //   var to = from + this.offset * 2;
    //   if (to >= this.pagination.last_page) {
    //     to = this.pagination.last_page;
    //   }

    //   var pagesArray = [];
    //   while (from <= to) {
    //     pagesArray.push(from);
    //     from++;
    //   }
    //   return pagesArray;
    // }
  },
  methods: {
     selectRow(row){
            if(this.selected_rows.indexOf(row) !== -1){
                let index = this.selected_rows.indexOf(row);
                this.selected_rows.splice(index, 1);

                return;
            }

            this.selected_rows.push(row);
        },
    listarData(page) {
      let me = this;
       me.loading = true;
      var url = this.ruta + "/detraccion/orden?page=" + page +
      "&fecini=" + this.customFormatter(this.FecIni) +
      "&fecfin=" + this.customFormatter(this.FecFin) +
      "&empresa=" + this.Empresa +
      "&centro=" + this.Centro +
      "&estado=" +  (this.checkestado ? 1: 0)
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.oObj.rows = respuesta.obj;
                     me.loading = false;
                    me.selected_rows=[];
          // me.pagination = respuesta.pagination;
          //  console.log(formatfecha())
        })
        .catch(function(error) {
           alert(error);
        });
    },
     GeneraccionGrr(){
        let me = this;
         
      try {
        if (this.selected_rows.length==0) {
            throw "Ningun Documento Seleccionado.";
        }else
        {
              var url = this.ruta + "/detraccion/procesar?"+
              "&empresa=" + this.Empresa +
              "&centro=" + this.Centro+
              "&codigo=" + this.parseArray(this.selected_rows)+
              "&codempr_emisor=" + this.Empresa +
              "&codempr_receptor=" + this.Empresa +
              "&cod_doc_serie=" + this.Serie +
              "&cod_direccion_origen=" + this.DireccionPartida +
              "&cod_direccion_destino=" + this.DireccionLlegada;
              me.pagodetraccionview=1;
                  axios
                     .get(url)
                        .then(function(response) {
                          me.pagodetraccionview=0;
                          me.preconciliacionview=0;
                              me.resultdogrrview=1;
                              var respuesta = response.data;
                              me.oResultadoGrr=respuesta.obj;
                                  
                        })
                      .catch(function(error) {
                             console.log(error);
                    });
              
        }
      
      } catch (error) {
         this.$swal({
              type : 'error',
              title: 'Oops...',
              text: error
              });
      }
     },
     ProcesarDetraccion() {
      let me = this;
      try {

        if (this.selected_rows.length==0 || this.checkestado) {
          if (this.selected_rows.length==0) {
             throw "Ningun Documento seleccionado"
          }else{
             throw "Ya se pagó detracción de los documentos listados."
          }
            
        }
        let tipodoc="TDO0000000000009";
        var urlserie = this.ruta + "/detraccion/getserie?tipodocumento=" +tipodoc;
       
        this.listarCategoria("MOTIVO_TRASLADO");
        this.listarCategoria("EMPRESA_DIRECCION");

              axios
                .get(urlserie)
                .then(function(response) {
                  me.preconciliacionview=1 ;
                  var respuesta = response.data;
                  me.oSerie=respuesta.serie
                      
                })
                .catch(function(error) {
                    console.log(error)
                });
        
      } catch (error) {
         this.$swal({
              type : 'error',
              title: 'Oops...',
              text: error
              });
      }

    },
    listarCategoria(buscar) {
      let me = this;
      var url = this.ruta + "/categoria/listarCategoria?buscar=" + buscar;
      axios
        .get(url ,{ crossdomain: true })
        .then(function(response) {
          var res = response.data;

          switch (buscar) {
            case "EMPRESA":
                me.oEmpresa = res.categoria;
              break;
            case "CENTRO":
               me.oCentro = res.categoria;
              break;
            case "MOTIVO_TRASLADO":
               me.oMotivo=res.categoria
               break;
            case "EMPRESA_DIRECCION":
              me.oDireccion=res.categoria
          }
        
        })
        .catch(function(error) {
             alert(error);
        });
    },
    cerrarModal() {
      this.preconciliacionview = 0;
    },

    finalizarGrr() {
      this.resultdogrrview = 0;
      this.exportExcel();
    },
    exportExcel: function () {
      let data = XLSX.utils.json_to_sheet(this.oResultadoGrr)
      const workbook = XLSX.utils.book_new()
      const filename = 'pagodetracciones'+this.oSerie[0].NRO_DOC_ULTIMO
      XLSX.utils.book_append_sheet(workbook, data, filename)
      XLSX.writeFile(workbook, `${filename}.xlsx`)
    },
    AbrilModal() {
     
              this.preconciliacionview = 1;
     },

   customFormatter(date) {
     
      let d = moment(date);
      // console.log(d.format('YYYY-MM-DD'));

      return d.format('YYYY-MM-DD');
    },
    count(data=[]){
        return data.length;
    },
    parseArray(data=[]){

    let codigo=""

    try {
      if (data.length>0) {
          for (var i=0; i<data.length; i++) { 
                  if (i==0) {
                    // codigo="'"+data[i].CODIGO+"'";
                    codigo=data[i].CODIGO;
                  } else {
                      // codigo=codigo+",'"+data[i].CODIGO+"'";
                      codigo=codigo+","+data[i].CODIGO;
                  }
                  

          }
         return codigo;
      }else{
          throw "Ningún documento seleccionado."; //Arroja la palabra "InvalidMonthNo" al ocurrir una excepción
      }
    } catch (error) {
       this.$swal({
              type : 'error',
              title: 'Oops...',
              text: error
              });
    }
 
    }
  },

  mounted() {
    this.listarCategoria("EMPRESA");
    this.listarCategoria("CENTRO");
    // this.listarJV('JEFE_VENTA');
    //  this.createChart();
    //  console.log("MONTERICO");
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });

  }
};
</script>
<style>
.mostrarsub{
    -webkit-transform: translate(0, 0) !important;
    
     transform: translate(0, 0) !important;
    }
    .mostrar {
 
  background-color: #3c29297a !important;

  display: block;
  padding-right: 16px;
  opacity: 1 !important;
  overflow-x: hidden;
  overflow-y: auto;
}
.lds-roller {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-roller div {
  animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  transform-origin: 32px 32px;
}
.lds-roller div:after {
  content: " ";
  display: block;
  position: absolute;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #1266f1;
  margin: -3px 0 0 -3px;
}
.lds-roller div:nth-child(1) {
  animation-delay: -0.036s;
}
.lds-roller div:nth-child(1):after {
  top: 50px;
  left: 50px;
}
.lds-roller div:nth-child(2) {
  animation-delay: -0.072s;
}
.lds-roller div:nth-child(2):after {
  top: 54px;
  left: 45px;
}
.lds-roller div:nth-child(3) {
  animation-delay: -0.108s;
}
.lds-roller div:nth-child(3):after {
  top: 57px;
  left: 39px;
}
.lds-roller div:nth-child(4) {
  animation-delay: -0.144s;
}
.lds-roller div:nth-child(4):after {
  top: 58px;
  left: 32px;
}
.lds-roller div:nth-child(5) {
  animation-delay: -0.18s;
}
.lds-roller div:nth-child(5):after {
  top: 57px;
  left: 25px;
}
.lds-roller div:nth-child(6) {
  animation-delay: -0.216s;
}
.lds-roller div:nth-child(6):after {
  top: 54px;
  left: 19px;
}
.lds-roller div:nth-child(7) {
  animation-delay: -0.252s;
}
.lds-roller div:nth-child(7):after {
  top: 50px;
  left: 14px;
}
.lds-roller div:nth-child(8) {
  animation-delay: -0.288s;
}
.lds-roller div:nth-child(8):after {
  top: 45px;
  left: 10px;
}
@keyframes lds-roller {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>

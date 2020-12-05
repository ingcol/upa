<template>
	<div class="main-content">
		<div class="contenedor">
			<div class="container-fluid">
				<div class="page-header">
					<div class="row align-items-end">
						<div class="col-lg-8">
							<div class="page-header-title">

								<div class="d-inline">
									<h5> Módulo de empresas</h5>

								</div>
							</div>
						</div>
						<div class="col-lg-4">
						</div>
					</div>
				</div>
				<hr>
        <div class="row">
          <div class="col-md-3">
            <label>Plan</label>

            <select  class="form-control input-custom" v-model="filtrarPlan">
              <option value="-1">Todos</option>
              <option value="gratis">Gratis</option>
              <option value="">Pago</option>
            </select>

          </div>

          <div class="col-md-3"><div class="form-group">
            <label>Ciudad</label>
            <select class="form-control" v-model="filtrarCiudad">
              <option value="-1">Todos</option>
              <option :value="ciudad.id" v-for="ciudad in ciudades" >{{ciudad.nombre}}</option>

            </select>
          </div> </div>
          <div class="col-md-3"><div class="form-group">
            <label>Estado</label>
            <select class="form-control"  v-model="filtrarEstado">
              <option value="-1">Todos</option>
              <option value="1">Activo</option>
              <option value="">Inactivo</option>

            </select>
          </div> </div>
          <div class="col-md-3">
            <label>Búsqueda</label>

            <input type="text" v-model="search" placeholder="" @input="resetPagination()" class="form-control input-custom">
          </div>
        </div>
        <div class="text-center bg-light pt-2 pb-3">
          <a  @click="obtenerEmpresas"  class="btn btn-info  font-weight-bold text-white mt-1  "><i class="ik search ik-search"></i>
          Filtrar datos</a>
        </div>
        <hr>
        <div class="table-responsive" >
         <table class="table  jambo_table bulk_action  " id="table_grupo" >
          <thead>
            <tr class=" tabla-fondo">
              <th>Ciudad</th>
              <th>Empresa</th>
              <th>Cliente</th>
              <th>Estado</th>
              <th>Plan</th>
              <th>Celular</th>
              <th>Dirección</th>
              
              <th>Editar</th>
            </tr>
          </thead>
          <tbody>

            <tr v-for="item in paginatedEmpresas">
              <td >{{item.nombre_ciudad}}</td>
              <td>{{item.nombre}}</td>
              <td>{{item.user_name}}</td>
              <td><span v-if='item.estado=="1"'>Activo</span> <span v-else>Inactivo</span></td>
              <td><span v-if='item.plan=="gratis"'>Gratis</span>
                <span v-else>Pago</span></td>
              <td>{{item.celular}}</td>
              <td>{{item.direccion}}</td>
              
              <td > <a  :href="'/empresas/'+item.id+'/edit'"  target="_blank" class="btn-editar"><i class="ik refresh-ccw ik-refresh-ccw
                "></i> </a>
              </td>

            </tr>
          </tbody>

        </table>
      </div>
      <hr>
      <div  class="paginator">
        <nav class="pagination" v-if="!tableShow.showdata" >
          <span class="page-stats cantidad-registro" >{{pagination.from}} - {{pagination.to}} de {{pagination.total}}</span>
          <a v-if="pagination.prevPageUrl"  class=" margin-button" @click="--pagination.currentPage">
            <i class="fa fa-arrow-circle-left"></i>
          </a>
          <a class="margin-button" v-else disabled >
            <i class="fa fa-arrow-circle-left"></i>
          </a>
          <a v-if="pagination.nextPageUrl" class=" margin-button"  @click="++pagination.currentPage">
            <i class="fa fa-arrow-circle-right"></i>
          </a>
          <a class="margin-button"  v-else disabled>
            <i class="fa fa-arrow-circle-right"></i>
          </a>
        </nav>
        <nav class="pagination" v-else>
          <span class="page-stats cantidad-registro" >Mostrando
            {{pagination.from}} - {{pagination.to}} de un total {{filteredEmpresas.length}}
            <span v-if="`filteredEmpresas.length < pagination.total`"></span>
          </span>
          <a v-if="pagination.prevPage" class=" margin-button" @click="--pagination.currentPage" ><i class="fa fa-arrow-circle-left"></i>

          </a>
          <a class="margin-button" v-else disabled >
            <i class="fa fa-arrow-circle-left"></i>
          </a>
          <a v-if="pagination.nextPage" class="margin-button" @click="++pagination.currentPage" ><i class="fa fa-arrow-circle-right"></i>

          </a>
          <a class="margin-button"  v-else disabled ><i class="fa fa-arrow-circle-right"></i>
          </a>
        </nav>
      </div>
    </div>
    <!--modal-->

    <loading :active.sync="isLoading"
    :can-cancel="false"></loading>
  </div>

</div>
</template>

<script>
  import PulseLoader from 'vue-spinner/src/ClipLoader.vue'
  import DatePick from 'vue-date-pick';
  import 'vue-date-pick/dist/vueDatePick.css';
  import Vue from 'vue';
  import VueToast from 'vue-toast-notification';
  import 'vue-toast-notification/dist/theme-sugar.css';
  import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
      mounted() {
        this.obtenerEmpresas();
        this.getCiudad();

      },
      components: {DatePick,'PulseLoader': PulseLoader,Loading},
      data() {
        let sortOrders = {};
        let columns = [
        {label: 'Nombre', name: 'nombre' },
        {label: 'Descripcion', name: 'descripcion'},


        ];
        columns.forEach((column) => {
         sortOrders[column.nombre] = -1;
       });

        return {

          checkAll:false,
          isLoading:false,
          disabled:false,
          empresas:[],
          filtrarCiudad:'-1',
          filtrarEstado:'-1',
          filtrarPlan:'-1',

          ModoEditar: false,
          isLoading:false,
          
          columns: columns,
          ciudades:[],
          

          sortOrders: sortOrders,
          length: 50,
          search: '',
          tableShow: {
            showdata: true,
          },

          pagination: {
            currentPage: 1,
            total: '',
            nextPage: '',
            prevPage: '',
            from: '',
            to: ''
          },
          


//date
nextMonthCaption:  'Sig mes',
prevMonthCaption:'Ant mes',
weekdays: [
'lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab', 'Dom'
],
months: [
'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
],


}
},

methods: {
 getCiudad: function(){
  axios.get('/api/ciudadPublicidad').then(response=>{
    this.ciudades = response.data;})
},
obtenerEmpresas() {
  this.isLoading=true

  axios.get('/api/empresas',{
   params: {
     filtrarEstado: this.filtrarEstado,filtrarCiudad: this.filtrarCiudad,filtrarPlan: this.filtrarPlan,  showdata:true
   }
 }).then(response => {
  this.isLoading=false
  this.empresas=response.data;
  this.pagination.total = this.empresas.length;
})
 .catch(errors => {
  this.isLoading=false
});
},
paginate(array, length, pageNumber) {
  this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
  this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
  this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
  this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
  return array.slice((pageNumber - 1) * length, pageNumber * length);
},
resetPagination() {
  this.pagination.currentPage = 1;
  this.pagination.prevPage = '';
  this.pagination.nextPage = '';
},
sortBy(key) {
  this.resetPagination();
  this.sortKey = key;
  this.sortOrders[key] = this.sortOrders[key] * -1;
},
getIndex(array, key, value) {
  return array.findIndex(i => i[key] == value)
},
},
computed: {


  filteredEmpresas() {
    let empresas = this.empresas;
    if (this.search) {
      empresas = empresas.filter((row) => {
        return Object.keys(row).some((key) => {
          return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        })
      });
    }
    let sortKey = this.sortKey;
    let order = this.sortOrders[sortKey] || 1;
    if (sortKey) {
      empresas = empresas.slice().sort((a, b) => {
        let index = this.getIndex(this.columns, 'name', sortKey);
        a = String(a[sortKey]).toLowerCase();
        b = String(b[sortKey]).toLowerCase();
        if (this.columns[index].type && this.columns[index].type === 'date') {
          return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
        } else if (this.columns[index].type && this.columns[index].type === 'number') {
          return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
        } else {
          return (a === b ? 0 : a > b ? 1 : -1) * order;
        }
      });
    }
    return empresas;
  },
  paginatedEmpresas() {
    return this.paginate(this.filteredEmpresas, this.length, this.pagination.currentPage);
  }
}
};
</script>

<style>

.img-promocion{
  max-width: 400px;
  max-height: 150px;
  width: 100%;
  height: 100%;
  padding: 6px;
}

.vdpArrowPrev:after {
  border-right-color: #cc99cd;
  font-size: 16px;
}

.vdpArrowNext:after {
  border-left-color: #cc99cd;font-size: 16px;

}


.vdpCell.selectable:hover .vdpCellContent,
.vdpCell.selected .vdpCellContent {
  background: #cc99cd;
}

.vdpCell.today {
  color: white;
  border-radius: 5px;
  background: orange;
}

.vdpTimeUnit > input:hover,
.vdpTimeUnit > input:focus {
  border-bottom-color: #cc99cd;

}
.vdpComponent{
  /* position: relative; */
  display: block;
  font-size: 10px;
  color: #303030;
}
.vdpWithInput>input{

  position: none;
  width: 100% !important;
  height: 35px;
  padding: .375rem .75rem;
  font-size: 13px;

  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #eaeaea;
  border-radius: .25rem;
}
.calendar-desing > input{

  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;

}

.file {
  position: relative;
  cursor: pointer;
}
.file label {
  padding: 4px 18px !important;
  background:orange;
  cursor: pointer;
  border: 0;
  border-radius: 5px;
  color: white
}
.file input {
  position: absolute;
  width: 100%;
  left: 0;
  top: 0;
  opacity: 0.01;
  cursor: pointer;
}
.file input:hover + label,
.file input:focus + label {
  background: #34495E;
  color: #39D2B4;
}

</style>


<template>
  <div class="main-content">
    <div  class="contenedor">
      <div class="container-fluid">
        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <div class="page-header-title">
               <div class="d-inline">
                <h5>Módulo de categorías</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <button type="button" class="btn-guardar float-right"  @click="modalNuevo()"><i class="ik ik-check-circle"></i> Registrar</button>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-4">
          <label>Filtrar</label>

          <select v-model="length" @change="resetPagination()" class="form-control input-custom">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
          </select>

        </div>

        <div class="col-md-4"> </div>
        <div class="col-md-4">
          <label>Búsqueda</label>

          <input type="text" v-model="search" placeholder="" @input="resetPagination()" class="form-control input-custom">
        </div>
      </div>

      <br>

      <div class="table-responsive" >

       <table class="table  jambo_table bulk_action">
        <thead>
          <tr class=" tabla-fondo">
            <th>Nombre</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="item in paginatedCategorias" :key="item.id">
            <td>{{item.nombre}}</td>
            
            <td><a @click="modalEditar(item)" class="btn-editar"><i class="ik refresh-ccw ik-refresh-ccw
              "></i> </a></td>

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
            {{pagination.from}} - {{pagination.to}} de un total {{filteredCategorias.length}}
            <span v-if="`filteredCategorias.length < pagination.total`"></span>
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
    <div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static">
     <div class="modal-dialog " role="document">
      <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="demoModalLabel" v-text="tituloModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
          ik-x-square" style=""></span></button>
        </div>
        <form @submit.prevent="modoEditar ? actualizaCategoria(categoria) : registrarCategoria()">
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control"   placeholder="" v-model="categoria.nombre">
            </div>
            
          </div>
          <div class="modal-footer">
           <button  class="btn-cerrar" data-dismiss="modal" ><i class=" ik x-circle
            ik-x-circle"></i> Cerrar</button>


            <button type="submit" v-bind:class="{'btn-guardar':!modoEditar,'btn-editar':modoEditar}" ><i  v-bind:class="{'ik ik-check-circle':!modoEditar,'ik refresh-ccw ik-refresh-ccw':modoEditar}"> {{tituloBoton}} </i>  </button>

          </div>
        </form>
      </div>
    </div>
  </div>
</div></div>
</template>

<script>
  import Vue from 'vue';
  import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';
export default {
  created() {
    this.getCategorias();

  },
  data() {
    let sortOrders = {};
    let columns = [
    {label: 'Nombre', name: 'nombre' },


    ];
    columns.forEach((column) => {
     sortOrders[column.nombre] = -1;
   });

    return {
      tituloModal:'',
      tituloBoton:'',

      modoEditar: false,
      btnAccion:true,
      categorias: [],

      columns: columns,
        //sortKey: 'EstadoPiso',
        sortOrders: sortOrders,
        length: 10,
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
        categoria: {
         nombre: '',

       },
       
     }
   },

   methods: {


    modalNuevo()
    {
     this.tituloModal="Registrar una categoría"
     
     this.tituloBoton="Guardar";
     
     $("#modalCategoria").modal("show");
     

     this.reset();
     this.modoEditar = false;



   },
   registrarCategoria()
   {
    axios.post('/categoria', {
     nombre:this.categoria.nombre
   })
    .then(response => {

     this.reset();
     Vue.$toast.open({
      message:'Registro exitoso',
      type: 'success',
      position: 'top-right',
      duration: 5000,
      dismissible: true
    // all of other options may go here
  })

     this.categorias.unshift(response.data);
     /*$("#ModalPrioridad").modal("hide");*/


   })

    .catch(error => {
     this.errors = [];
     _.forEach(error.response.data.errors, function(value, key) {
      Vue.$toast.open({
        message: value[0],
        type: 'error',
        position: 'top-right',
        duration: 5000,
        dismissible: true
    // all of other options may go here
  })


    });
   });
  },
  reset()
  {
    this.categoria.nombre = '';

    this.modoEditar = false;
  },modalEditar(item){
    this.modoEditar = true;
    
    this.tituloModal="Editar esta categoría"

    this.tituloBoton="Editar";
    $("#modalCategoria").modal("show");

    this.categoria.nombre = item.nombre;
    
    this.categoria.id = item.id;
    
  },actualizaCategoria(categoria){


    const params = {nombre: categoria.nombre};


    axios.put(`/categoria/${categoria.id}`, params)
    .then(response=>{
      this.ModoEditar = false;
      Vue.$toast.open({
        message:'Registo actualizado exitosamente',
        type: 'success',
        position: 'top-right',
        duration: 5000,
        dismissible: true
    // all of other options may go here
  })
      $("#modalCategoria").modal("hide");
      

      const index = this.categorias.findIndex(busqueda => busqueda.id === response.data.id)
      this.categorias[index].nombre=response.data.nombre;
      
      

    })
    .catch(error => {
      this.modoEditar = true;


      _.forEach(error.response.data.errors, function(value, key) {
       Vue.$toast.open({
        message: value[0],
        type: 'error',
        position: 'top-right',
        duration: 5000,
        dismissible: true
    // all of other options may go here
  })

     });


    });




  },
  getCategorias() {
    axios.get('/api/categoria', {params: this.tableShow})
    .then(response => {
      this.categorias = response.data;
      
      this.pagination.total = this.categorias.length;
    })
    .catch(errors => {

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

  filteredCategorias() {
    let categorias = this.categorias;
    if (this.search) {
      categorias = categorias.filter((row) => {
        return Object.keys(row).some((key) => {
          return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        })
      });
    }
    let sortKey = this.sortKey;
    let order = this.sortOrders[sortKey] || 1;
    if (sortKey) {
      categorias = categorias.slice().sort((a, b) => {
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
    return categorias;
  },
  paginatedCategorias() {
    return this.paginate(this.filteredCategorias, this.length, this.pagination.currentPage);
  }
}
};
</script>

